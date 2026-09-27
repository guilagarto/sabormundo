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
    Schema::create('lead_newsletters', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique(); // E-mail único para evitar duplicados
        $table->timestamps(); // Cria as colunas created_at e updated_at
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_newsletters');
    }
};
