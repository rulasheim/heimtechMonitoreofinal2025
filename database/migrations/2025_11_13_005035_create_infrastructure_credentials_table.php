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
        Schema::create('infrastructure_credentials', function (Blueprint $table) {
    $table->id();
    $table->string('name');                    // Nombre lógico del acceso
    $table->string('type');                    // servidor, switch, firewall, app, etc
    $table->string('host')->nullable();        // IP / DNS
    $table->string('username');               
    $table->text('password');                  // Encriptado
    $table->text('description')->nullable();   
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_credentials');
    }
};
