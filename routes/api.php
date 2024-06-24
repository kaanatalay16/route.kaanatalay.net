<?php

use App\Http\Controllers\GeojsonController;
use App\Http\Controllers\KmlController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/test', [TestController::class, "index"]);

Route::apiResource('/routes', RouteController::class);
Route::apiResource('/paths', PathController::class);
Route::get('/geojsons/route/{id}', [GeojsonController::class, "route"]);
Route::get('/kml/route/{id}/{time}', [KmlController::class, "route"]);
Route::get('/kml/navigation/{id}/{time}', [KmlController::class, "navigation"]);
Route::get('/paths/route/{id}', [PathController::class, "route"]);
Route::apiResource('/vehicles', VehicleController::class);
