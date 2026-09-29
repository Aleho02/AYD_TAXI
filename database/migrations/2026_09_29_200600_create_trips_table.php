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
            $table->foreignId('passenger_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('origin_address');
            $table->decimal('origin_latitude', 10, 7);
            $table->decimal('origin_longitude', 10, 7);
            $table->string('destination_address');
            $table->decimal('destination_latitude', 10, 7);
            $table->decimal('destination_longitude', 10, 7);
            $table->decimal('distance_km', 8, 2)->default(0.00);
            $table->decimal('estimated_fare', 10, 2)->default(0.00);
            $table->enum('status', ['solicitado', 'aceptado', 'en_camino', 'completado', 'cancelado'])->default('solicitado');
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
