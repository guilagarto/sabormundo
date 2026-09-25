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
    Schema::create('receitas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('slug')->unique();
        $table->text('modo_preparo');
        
        // CORREÇÃO: Remove o constrained que quebra o banco e usa texto puro para o País
        $table->string('pais')->nullable(); 
        
        $table->string('imagem')->nullable();
        $table->timestamps();
    });
}


public function down(): void
{
    Schema::dropIfExists('receitas');
}

};
