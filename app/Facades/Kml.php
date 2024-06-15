<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Kml extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kml';
    }
}
