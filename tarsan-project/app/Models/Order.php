<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'user_id',
        'check_in',
        'check_out',
        'nights',
        'total_price',
        'gross_amount',
        'payment_status',
        'booking_status',
        'status',
        'checked_in_at',
        'checked_out_at',
        'is_walkin',
        'guest_name',
        'guest_phone',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'is_walkin' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* =====================
     | RELATIONSHIPS
     ===================== */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /* =====================
     | STATUS OPERASIONAL
     ===================== */
    public function getOperationalStatusAttribute(): string
    {
        if ($this->checked_out_at) {
            return 'completed';
        }

        if ($this->checked_in_at) {
            return 'ongoing';
        }

        if (now()->lt($this->check_in_date)) {
            return 'upcoming';
        }

        return 'waiting';
    }

    /* =====================
     | AVAILABILITY CHECK
     ===================== */
    public static function isRoomAvailable(
        int $roomId,
        Carbon $checkIn,
        Carbon $checkOut
    ): bool {
        return ! self::where('room_id', $roomId)
            ->whereNull('checked_out_at') // masih aktif
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in_date', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                  ->orWhere(function ($sub) use ($checkIn, $checkOut) {
                      $sub->where('check_in_date', '<=', $checkIn)
                          ->where('check_out_date', '>=', $checkOut);
                  });
            })
            ->exists();
    }

     /* =====================
     | HELPER NAMA TAMU
     ===================== */
    public function getGuestDisplayNameAttribute()
    {
        return $this->is_walkin
            ? $this->guest_name
            : optional($this->user)->name;
    }

    public function add(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::findOrFail($request->room_id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);

        // 🔹 Buat ORDER
        $order = Order::create([
            'user_id' => auth()->id(),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $nights,
            'total_price' => $room->price_per_night * $nights,
            'payment_status' => 'pending',
            'booking_status' => 'upcoming',
            'status' => 'pending',
        ]);

        // 🔹 Buat ORDER ITEM
        OrderItem::create([
            'order_id' => $order->id,
            'room_id' => $room->id,
            'qty' => 1,
            'price_per_night' => $room->price_per_night,
            'nights' => $nights,
            'subtotal' => $room->price_per_night * $nights,
        ]);

        return redirect()->route('tamu.checkout.index', $order->id);
    }
}
