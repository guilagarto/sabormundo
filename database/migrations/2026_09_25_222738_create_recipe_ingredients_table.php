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
    Schema::create('recipe_ingredients', function (Blueprint $table) {
        $table->id();
        
        // Versão explícita e mais segura contra erros de nomenclatura
        $table->unsignedBigInteger('receita_id');
        $table->foreign('receita_id')
              ->references('id')
              ->on('receitas') // <-- COLOQUE O NOME EXATO DA SUA TABELA DE RECEITAS AQUI (receita ou receitas)
              ->onDelete('cascade');

      $table->string('nome');
        $table->string('quantidade');
        $table->string('unidade_medida');
        $table->timestamps();
    }); // <-- Fecha o Schema::create
} // <-- FECHOU A FUNÇÃO up() QUE ESTAVA FALTANDO! (Adicione esta linha antes da 34)

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::dropIfExists('recipe_ingredients');
}
};
