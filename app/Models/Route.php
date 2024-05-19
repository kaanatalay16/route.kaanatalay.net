<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    use HasFactory;




    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function paths(): HasMany
    {
        return $this->hasMany(Path::class);
    }

    protected $fillable = [
        'startingLocation',
        'endingLocation',
    ];

    protected $appends = [
        'startingLocation',
        'endingLocation',
    ];



    public function getStartingLocationAttribute(): array
    {
        return [
            "lat" => (float) $this->startingLatitude,
            "lng" => (float) $this->startingLongitude,
        ];
    }

    public function getEndingLocationAttribute(): array
    {
        return [
            "lat" => (float) $this->endingLatitude,
            "lng" => (float) $this->endingLongitude,
        ];
    }


    /**
     * Takes a Google style Point array of 'lat' and 'lng' values and assigns them to the
     * 'startingLatitude' and 'startingLongitude' attributes on this model.
     *
     * Used by the Filament Google Maps package.
     *
     * Requires the 'startingLocation' attribute be included in this model's $fillable array.
     *
     * @param ?array $location
     * @return void
     */
    public function setStartingLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['startingLatitude'] = $location['lat'];
            $this->attributes['startingLongitude'] = $location['lng'];
            unset($this->attributes['startingLocation']);
        }
    }

    public function setEndingLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['endingLatitude'] = $location['lat'];
            $this->attributes['endingLongitude'] = $location['lng'];
            unset($this->attributes['endingLocation']);
        }
    }

    /**
     * Get the lat and lng attribute/field names used on this table
     *
     * Used by the Filament Google Maps package.
     *
     * @return string[]
     */
    // public static function getLatLngAttributes(): array
    // {
    //     return [
    //         'lat' => 'startingLatitude',
    //         'lng' => 'startingLongitude',
    //     ];
    // }

    /**
     * Get the name of the computed location attribute
     *
     * Used by the Filament Google Maps package.
     *
     * @return string
     */
    // public static function getComputedLocation(): string
    // {
    //     return 'startingLocation';
    // }
}
