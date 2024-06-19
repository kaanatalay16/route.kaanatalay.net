<?php

use App\Models\Route;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('graphs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Route::class, "route_id");
            $table->json("time");
            $table->json("distance");
            $table->json("totalCellPowerEnergyConsumption");
            $table->json("drivingProfile");
            $table->json("batteryPower");
            $table->json("soc");
            $table->json("capacityRetention");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graphs');
    }
};
