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
          Schema::create('pontos', function (Blueprint $table) {
              $table->id();
              $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
              $table->date('data');
              $table->json('horarios');
              $table->decimal('total_horas', 5, 2)->default(0);
              $table->text('observacao')->nullable();
              $table->timestamps();

              $table->unique(['user_id', 'data']);
          });
      }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pontos');
    }
};
