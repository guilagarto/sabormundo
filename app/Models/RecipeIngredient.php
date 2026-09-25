<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    protected $table = 'recipe_ingredients';

    protected $fillable = ['receita_id', 'nome', 'quantidade', 'unidade_medida'];

    // Um ingrediente pertence a uma Receita
    public function receita()
    {
        return $this->belongsTo(Receita::class, 'receita_id');
    }
}
