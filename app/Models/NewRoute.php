<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewRoute extends Model
{
    use HasFactory;


    public function segments(): HasMany
    {
        return $this->hasMany(Segment::class);
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
}
