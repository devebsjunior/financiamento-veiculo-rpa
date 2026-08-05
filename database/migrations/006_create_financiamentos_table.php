<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financiamentos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cliente_id')
                ->constrained('clientes');

            $table->foreignId('veiculo_id')
                ->constrained('veiculos');

            $table->string('numero_contrato')->unique();

            $table->decimal('valor_veiculo', 15, 2);

            $table->decimal('valor_entrada', 15, 2);

            $table->decimal('valor_financiado', 15, 2);

            $table->decimal('taxa_juros', 5, 2);

            $table->integer('quantidade_parcelas');

            $table->date('data_contratacao');

            $table->string('situacao')
                ->default('ATIVO');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financiamentos');
    }
};
