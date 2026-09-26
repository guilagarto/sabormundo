<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'calorias',
        'carboidratos',
        'proteinas',
        'gorduras',
        'sodio',
    ];

    /**
     * Relacionamento: Um ingrediente do catálogo pode estar em várias receitas (N:N).
     * Mapeamos a tabela pivô 'recipe_ingredients' trazendo a quantidade e unidade junto.
     */
    public function receitas(): BelongsToMany
    {
        return $this->belongsToMany(Receita::class, 'recipe_ingredients')
                    ->withPivot('quantidade', 'unidade_medida')
                    ->withTimestamps();
    }
}
