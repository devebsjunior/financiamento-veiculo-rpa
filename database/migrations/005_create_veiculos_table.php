<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {

            $table->id();

            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('modelo');

            $table->integer('ano_fabricacao');
            $table->integer('ano_modelo');

            $table->string('cor')->nullable();

            $table->string('renavam')->nullable();
            $table->string('chassi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
