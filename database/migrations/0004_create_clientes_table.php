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
        Schema::create('clientes', function (Blueprint $table) {

            $table->id();

            $table->string('nome');
            $table->string('cpf', 14)->unique();

            $table->date('data_nascimento')->nullable();

            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();

            $table->string('cep', 9)->nullable();

            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('bairro')->nullable();

            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
