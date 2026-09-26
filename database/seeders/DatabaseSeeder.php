<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Inserir Países de Exemplo
        $paises = ['África do Sul', 'Alemanha', 'Arábia Saudita', 'Brasil', 'Japão'];
        foreach ($paises as $pais) {
            DB::table('paises')->insert([
                'nome' => $pais,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Inserir Ingredientes Base (Valores por 100g - Referência TACO)
        $ingredients = [
            ['nome' => 'Arroz Integral Cozido', 'calorias' => 124.00, 'carboidratos' => 25.80, 'proteinas' => 2.60, 'gorduras' => 1.00, 'sodio' => 1.00],
            ['nome' => 'Feijão Carioca Cozido', 'calorias' => 76.00, 'carboidratos' => 13.60, 'proteinas' => 4.80, 'gorduras' => 0.50, 'sodio' => 2.00],
            ['nome' => 'Peito de Frango Grelhado', 'calorias' => 159.00, 'carboidratos' => 0.00, 'proteinas' => 32.00, 'gorduras' => 2.50, 'sodio' => 50.00],
            ['nome' => 'Carpa / Peixe Inteiro', 'calorias' => 138.00, 'carboidratos' => 0.00, 'proteinas' => 18.90, 'gorduras' => 5.60, 'sodio' => 50.00],
            ['nome' => 'Azeite de Oliva', 'calorias' => 884.00, 'carboidratos' => 0.00, 'proteinas' => 0.00, 'gorduras' => 100.00, 'sodio' => 0.00],
        ];

        foreach ($ingredients as $ing) {
            DB::table('ingredients')->insert(array_merge($ing, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
