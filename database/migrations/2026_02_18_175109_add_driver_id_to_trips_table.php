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
        Schema::table('trips', function (Blueprint $table) {
            // Drop the taxi_id added previously if it exists
            if (Schema::hasColumn('trips', 'taxi_id')) {
                $table->dropForeign(['taxi_id']);
                $table->dropColumn('taxi_id');
            }
            
            // Add driver_id (user_id with role driver)
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn('driver_id');
            $table->foreignId('taxi_id')->nullable()->constrained('taxis')->onDelete('cascade');
        });
    }
};
