<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            '1 Bed Super King',
            '2 Bed Single',
            '1 Bed Single',
            'AC',
            'Shower',
            'Bathroom',
            'Balcony',
            'Garden View',
            'WiFi',
            'Private',
            'Sharing',
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(
                ['slug' => Str::slug($facility)],
                ['name' => $facility]
            );
        }
    }
}
