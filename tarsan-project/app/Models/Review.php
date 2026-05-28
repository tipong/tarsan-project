<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'order_id',
        'rating',
        'review',
        'admin_reply',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /* =====================
     | RELATIONSHIPS
     ===================== */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* =====================
     | HELPERS
     ===================== */

    // ⭐ Tampilan bintang
    public function getStarsAttribute(): string
    {
        return str_repeat('⭐', $this->rating);
    }

    // ✅ Apakah review bisa diedit?
    public function canBeEdited(): bool
    {
        return true; // bisa dikembangkan (misal 7 hari)
    }
}
