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
        Schema::create('monitor_targets', function (Blueprint $table) {
    $table->id();
    $table->string('name');           // Nombre descriptivo
    $table->string('host');           // IP o DNS
    $table->boolean('is_online')->default(false); // Estado del ping
    $table->integer('latency')->nullable();       // Tiempo en ms
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitor_targets');
    }
};
