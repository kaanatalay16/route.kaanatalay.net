<?php

use Illuminate\Support\Facades\Route;

Route::get('/tomtom', function () {


});


Route::get('/output', function () {
    return Storage::response("python/distance.png");
});
