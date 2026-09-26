<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pais extends Model
{
    use HasFactory;

    // Define o nome correto da tabela em português no banco
    protected $table = 'paises';

    protected $fillable = [
        'nome',
        'bandeira',
    ];

    /**
     * Relacionamento: Um país possui muitas receitas (1:N).
     */
    public function receitas(): HasMany
    {
        return $this->hasMany(Receita::class, 'pais_id');
    }
}
