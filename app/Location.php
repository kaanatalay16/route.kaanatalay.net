<?php

namespace App;

class Location
{

    public $latitude;
    public $longitude;

    /**
     * Create a new class instance.
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
