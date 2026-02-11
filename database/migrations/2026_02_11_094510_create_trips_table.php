<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->time('departure_hour');
            $table->time('estimated_arrival_hour');
            $table->time('range_of_lateness');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['confirmed', 'cancelled']);
            $table->date('date');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            // $table->foreignId('taxi_id')->constrained('taxis');
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
