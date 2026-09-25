<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    // Informa o nome exato da tabela no banco do XAMPP
    protected $table = 'paises';
    
    // Desativa os timestamps já que sua tabela não tem as colunas created_at/updated_at
    public $timestamps = false;
}
