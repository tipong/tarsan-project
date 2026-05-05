<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'amount',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * 🔥 STATUS DINAMIS (TIDAK DISIMPAN DI DB)
     */
    public function getStatusAttribute(): string
    {
        $now = Carbon::now('Asia/Makassar'); // WITA

        // Admin manual disable
        if (! $this->is_active) {
            return 'inactive';
        }

        // Belum mulai
        if ($now->lt($this->starts_at)) {
            return 'scheduled';
        }

        // Sudah lewat
        if ($now->gt($this->ends_at)) {
            return 'expired';
        }

        // Aktif
        return 'active';
    }
}
