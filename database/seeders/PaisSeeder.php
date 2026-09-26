<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa registros anteriores para evitar duplicações
        DB::table('paises')->truncate();

        // Injeta os 48 principais países focados no ecossistema da Copa 2026
        DB::table('paises')->insert([
            // Anfitriões da Copa 2026
            ['nome' => 'Estados Unidos'],
            ['nome' => 'México'],
            ['nome' => 'Canadá'],

            // CONMEBOL (América do Sul)
            ['nome' => 'Brasil'],
            ['nome' => 'Argentina'],
            ['nome' => 'Uruguai'],
            ['nome' => 'Colômbia'],
            ['nome' => 'Equador'],
            ['nome' => 'Paraguai'],
            ['nome' => 'Venezuela'],
            ['nome' => 'Chile'],
            ['nome' => 'Peru'],
            ['nome' => 'Bolívia'],

            // UEFA (Europa)
            ['nome' => 'Portugal'],
            ['nome' => 'França'],
            ['nome' => 'Itália'],
            ['nome' => 'Espanha'],
            ['nome' => 'Alemanha'],
            ['nome' => 'Inglaterra'],
            ['nome' => 'Holanda'],
            ['nome' => 'Bélgica'],
            ['nome' => 'Croácia'],
            ['nome' => 'Suíça'],
            ['nome' => 'Dinamarca'],
            ['nome' => 'Áustria'],

            // CAF (África)
            ['nome' => 'Marrocos'],
            ['nome' => 'Senegal'],
            ['nome' => 'Tunísia'],
            ['nome' => 'Argélia'],
            ['nome' => 'Egito'],
            ['nome' => 'Nigéria'],
            ['nome' => 'Camarões'],
            ['nome' => 'Costa do Marfim'],

            // AFC (Ásia)
            ['nome' => 'Japão'],
            ['nome' => 'Coreia do Sul'],
            ['nome' => 'Irã'],
            ['nome' => 'Arábia Saudita'],
            ['nome' => 'Austrália'],
            ['nome' => 'Catar'],
            ['nome' => 'Iraque'],
            ['nome' => 'Uzbequistão'],

            // CONCACAF (América Central e Norte extras)
            ['nome' => 'Costa Rica'],
            ['nome' => 'Panamá'],
            ['nome' => 'Jamaica'],
            ['nome' => 'Honduras'],

            // OFC (Oceânia)
            ['nome' => 'Nova Zelândia']
        ]);
    }
}
