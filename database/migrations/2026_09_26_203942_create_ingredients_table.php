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
    Schema::create('ingredients', function (Blueprint $table) {
        $table->id();
        $table->string('nome')->unique();
        // Valores nutricionais de referência calculados sempre para cada 100g do alimento
        $table->decimal('calorias', 8, 2)->default(0);     // kcal
        $table->decimal('carboidratos', 8, 2)->default(0); // g
        $table->decimal('proteinas', 8, 2)->default(0);    // g
        $table->decimal('gorduras', 8, 2)->default(0);     // g
        $table->decimal('sodio', 8, 2)->default(0);        // mg
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
