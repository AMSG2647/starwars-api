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
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('cost_in_credits')->nullable();
            $table->string('length')->nullable();
            $table->string('max_atmosphering_speed')->nullable();
            $table->string('crew')->nullable();
            $table->string('passengers')->nullable();
            $table->string('cargo_capacity')->nullable();
            $table->string('consumables')->nullable();
            $table->string('vehicle_class')->nullable();
            $table->string('pilots')->nullable();
            $table->string('films')->nullable();
            $table->string('created')->nullable();
            $table->string('edited')->nullable();
            $table->string('url')->nullable();
            $table->bigInteger('starship_id')->unsigned();
            $table->foreign('starship_id')->references('id')->on('starships')->onUpdate('cascade');
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
