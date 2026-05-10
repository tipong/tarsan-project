<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('rooms', 'facilities')) {
            return;
        }

        $rooms = DB::table('rooms')
            ->select('id', 'facilities')
            ->whereNotNull('facilities')
            ->get();

        foreach ($rooms as $room) {
            $facilityNames = collect(explode(',', (string) $room->facilities))
                ->map(fn (string $name) => trim($name))
                ->filter()
                ->unique();

            foreach ($facilityNames as $facilityName) {
                $slug = Str::slug($facilityName);

                $facilityId = DB::table('facilities')->where('slug', $slug)->value('id');

                if (! $facilityId) {
                    $facilityId = DB::table('facilities')->insertGetId([
                        'name' => $facilityName,
                        'slug' => $slug,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('facility_room')->updateOrInsert(
                    [
                        'facility_id' => $facilityId,
                        'room_id' => $room->id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('facilities');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('rooms', 'facilities')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->text('facilities')->nullable()->after('available_rooms');
            });
        }

        $roomIds = DB::table('rooms')->pluck('id');

        foreach ($roomIds as $roomId) {
            $facilityNames = DB::table('facility_room')
                ->join('facilities', 'facilities.id', '=', 'facility_room.facility_id')
                ->where('facility_room.room_id', $roomId)
                ->orderBy('facilities.name')
                ->pluck('facilities.name')
                ->implode(', ');

            DB::table('rooms')
                ->where('id', $roomId)
                ->update(['facilities' => $facilityNames]);
        }
    }
};
