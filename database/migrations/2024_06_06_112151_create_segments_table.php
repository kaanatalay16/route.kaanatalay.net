<?php

use App\Models\NewRoute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NewRoute::class, "new_route_id");
            $table->double("latitude");
            $table->double("longitude");
            $table->double("slope")->nullable();
            $table->double("speed")->nullable();
            $table->json("data")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
