<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    // Avisa o Laravel para usar a sua tabela existente em português
    protected $table = 'receitas';

    // Desative os timestamps automáticos (created_at/updated_at) 
    // caso sua tabela antiga não possua essas duas colunas exatas
    public $timestamps = false; 
}
