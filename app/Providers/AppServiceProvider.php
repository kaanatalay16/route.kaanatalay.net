<?php

namespace App\Providers;

use App\Services\RouteService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleMapsService;
use App\Services\TomTomService;
use App\Services\MatlabService;






class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('googlemaps', function ($app) {
            return new GoogleMapsService();
        });

        $this->app->singleton('tomtom', function ($app) {
            return new TomTomService();
        });

        $this->app->singleton('matlab', function ($app) {
            return new MatlabService();
        });


        $this->app->singleton('route', function ($app) {
            return new RouteService();
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();


    }
}
