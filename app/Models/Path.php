<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Path extends Model
{
    use HasFactory;


    protected function averageSpeed(): Attribute
    {
        return new Attribute(
            get: fn() => ($this->lengthInMeters / 1000.0) / ($this->travelTimeInSeconds / 3600.0),
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'legs' => 'array',
            'tags' => 'array',
        ];
    }
}
