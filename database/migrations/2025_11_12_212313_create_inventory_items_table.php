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
        Schema::create('inventory_items', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Nombre del producto o insumo
    $table->string('model')->nullable(); // Modelo
    $table->string('serial_number')->nullable(); // Número de serie
    $table->integer('quantity')->default(1); // Cantidad
    $table->text('description')->nullable(); // Descripción
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
