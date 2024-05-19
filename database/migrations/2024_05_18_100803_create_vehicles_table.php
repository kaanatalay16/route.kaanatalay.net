<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->string("name");
            $table->integer("vehicleMaxSpeed");
            $table->integer("vehicleWeight");
            $table->integer("vehicleAxleWeight");
            $table->integer("vehicleNumberOfAxles");
            $table->double("vehicleLength");
            $table->double("vehicleWidth");
            $table->double("vehicleHeight");
            $table->string("vehicleEngineType");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
