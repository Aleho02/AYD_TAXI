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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('license_plate')->unique(); // e.g. UBA123
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('color')->default('Amarillo');
            $table->enum('status', ['operativo', 'mantenimiento', 'inactivo'])->default('operativo');
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
