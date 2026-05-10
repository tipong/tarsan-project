<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Room extends Model
{
    protected static ?Collection $facilityOptionsCache = null;
    protected static ?bool $supportsFacilityRelationsCache = null;
    protected static ?bool $supportsLegacyFacilitiesColumnCache = null;

    protected $fillable = [
        'room_name',
        'price_per_night',
        'capacity',
        'total_rooms',
        'available_rooms',
        'facilities',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class)->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeWithRoomRelations(Builder $query): Builder
    {
        $query->with('images');

        if (self::supportsFacilityRelations()) {
            $query->with('facilities');
        }

        return $query;
    }

    public function scopeFilterByFacility(Builder $query, string $facilitySlug): Builder
    {
        if (self::supportsFacilityRelations()) {
            return $query->whereHas('facilities', function (Builder $facilityQuery) use ($facilitySlug) {
                $facilityQuery->where('slug', $facilitySlug);
            });
        }

        if (! self::supportsLegacyFacilitiesColumn()) {
            return $query;
        }

        $facilityName = self::facilityOptions()
            ->firstWhere('slug', $facilitySlug)?->name;

        if (! $facilityName) {
            return $query;
        }

        return $query->whereRaw(
            'FIND_IN_SET(?, REPLACE(facilities, ", ", ",")) > 0',
            [$facilityName]
        );
    }

    public function getFacilitiesTextAttribute(): string
    {
        return $this->facility_names->implode(', ');
    }

    public function getFacilityNamesAttribute(): Collection
    {
        if (self::supportsFacilityRelations()) {
            $relation = $this->relationLoaded('facilities')
                ? $this->getRelation('facilities')
                : $this->facilities()->get();

            return $relation->pluck('name')->filter()->values();
        }

        if (self::supportsLegacyFacilitiesColumn()) {
            return collect(explode(',', (string) $this->getAttribute('facilities')))
                ->map(fn (string $facility) => trim($facility))
                ->filter()
                ->values();
        }

        return collect();
    }

    public static function facilityOptions(): Collection
    {
        if (self::$facilityOptionsCache !== null) {
            return self::$facilityOptionsCache;
        }

        if (self::supportsFacilityRelations()) {
            return self::$facilityOptionsCache = Facility::query()
                ->orderBy('name')
                ->get();
        }

        if (! self::supportsLegacyFacilitiesColumn()) {
            return self::$facilityOptionsCache = collect();
        }

        return self::$facilityOptionsCache = static::query()
            ->whereNotNull('facilities')
            ->pluck('facilities')
            ->flatMap(fn ($facilityList) => explode(',', (string) $facilityList))
            ->map(fn (string $facility) => trim($facility))
            ->filter()
            ->unique(fn (string $facility) => Str::lower($facility))
            ->sort()
            ->values()
            ->map(fn (string $facility) => (object) [
                'id' => Str::slug($facility),
                'name' => $facility,
                'slug' => Str::slug($facility),
            ]);
    }

    public static function supportsFacilityRelations(): bool
    {
        if (self::$supportsFacilityRelationsCache !== null) {
            return self::$supportsFacilityRelationsCache;
        }

        return self::$supportsFacilityRelationsCache =
            Schema::hasTable('facilities') && Schema::hasTable('facility_room');
    }

    public static function supportsLegacyFacilitiesColumn(): bool
    {
        if (self::$supportsLegacyFacilitiesColumnCache !== null) {
            return self::$supportsLegacyFacilitiesColumnCache;
        }

        return self::$supportsLegacyFacilitiesColumnCache =
            Schema::hasColumn('rooms', 'facilities');
    }
}
