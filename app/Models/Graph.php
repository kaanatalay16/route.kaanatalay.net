<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'time' => 'array',
            'distance' => 'array',
            'totalCellPowerEnergyConsumption' => 'array',
            'drivingProfile' => 'array',
            'batteryPower' => 'array',
            'soc' => 'array',
            'capacityRetention' => 'array',
        ];
    }
}
