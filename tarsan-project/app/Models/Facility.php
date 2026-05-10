<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class)->withTimestamps();
    }
}
