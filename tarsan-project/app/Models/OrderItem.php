<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'room_id',
        'qty',
        'price_per_night',
        'nights',
        'subtotal',
    ];

    protected static array $persistableColumns = [];

    public static function createBookingItem(array $attributes): self
    {
        $pricePerNight = $attributes['price_per_night']
            ?? $attributes['price']
            ?? null;

        if ($pricePerNight === null) {
            throw new \RuntimeException('Order item price is missing.');
        }

        $payload = [
            'order_id' => $attributes['order_id'],
            'room_id' => $attributes['room_id'],
            'qty' => $attributes['qty'] ?? 1,
            'price_per_night' => $pricePerNight,
            'nights' => $attributes['nights'],
            'subtotal' => $attributes['subtotal'],
        ];

        return static::create(
            array_intersect_key($payload, static::persistableColumns())
        );
    }

    protected static function persistableColumns(): array
    {
        $table = (new static)->getTable();

        if (! isset(static::$persistableColumns[$table])) {
            static::$persistableColumns[$table] = array_flip(
                Schema::getColumnListing($table)
            );
        }

        return static::$persistableColumns[$table];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
