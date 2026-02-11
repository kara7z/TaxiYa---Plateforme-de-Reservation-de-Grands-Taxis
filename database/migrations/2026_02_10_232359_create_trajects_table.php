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
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('start_city_id')
                  ->constrained('cities')
                  ->cascadeOnDelete();

            $table->foreignId('arrival_city_id')
                  ->constrained('cities')
                  ->cascadeOnDelete();

            $table->decimal('base_price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajects');
    }
};
