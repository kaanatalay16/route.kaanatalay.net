<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Matlab extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'matlab';
    }
}
