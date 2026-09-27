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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('slug')->unique(); // Para criar URLs amigáveis (ex: sabormundo.site/guia-nutricional/beneficios-da-aveia)
        $table->string('categoria'); // Nutrição, Curiosidades, Dicas, etc.
        $table->text('conteudo'); // O texto completo do artigo
        $table->string('imagem')->nullable(); // Foto de capa da notícia
        $table->integer('visualizacoes')->default(0); // Contador de cliques para você saber quais posts fazem mais sucesso
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
