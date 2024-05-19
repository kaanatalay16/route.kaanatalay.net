<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Route;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paths', function (Blueprint $table) {
            $table->id();
            $table->integer("index");
            $table->foreignIdFor(Route::class, "route_id");
            $table->integer("lengthInMeters");
            $table->integer("travelTimeInSeconds");
            $table->integer("trafficDelayInSeconds");
            $table->integer("trafficLengthInMeters");
            $table->dateTime("departureTime");
            $table->dateTime("arrivalTime");
            $table->json("legs");
            $table->json("tags");
            $table->double("cost");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paths');
    }
};
