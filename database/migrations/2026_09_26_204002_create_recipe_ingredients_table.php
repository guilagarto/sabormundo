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
        $table->foreignId('receita_id')->constrained('receitas')->onDelete('cascade');
        $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
        $table->decimal('quantidade', 8, 2); // Quantidade exata usada na receita (ex: 150.00)
        $table->string('unidade_medida');    // gramas, ml, xícara, colher
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
