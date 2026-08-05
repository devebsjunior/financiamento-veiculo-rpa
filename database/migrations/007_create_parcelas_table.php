<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financiamento_id')
                ->constrained('financiamentos')
                ->cascadeOnDelete();
            $table->integer('numero_parcela');
            $table->date('data_vencimento');
            $table->decimal('valor_parcela', 15, 2);
            $table->decimal('valor_pago', 15, 2)
                ->nullable();
            $table->date('data_pagamento')
                ->nullable();
            $table->string('situacao')
                ->default('PENDENTE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};
