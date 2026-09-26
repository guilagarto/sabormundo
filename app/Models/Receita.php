<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Receita extends Model
{
    use HasFactory;

    protected $fillable = [
        'pais_id',
        'nome',
        'slug',
        'descricao',
        'imagen',
    ];

    /**
     * Relacionamento: A receita pertence a um País específico (N:1).
     */
    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    /**
     * Relacionamento: A receita possui muitos ingredientes do catálogo (N:N).
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
                    ->withPivot('quantidade', 'unidade_medida')
                    ->withTimestamps();
    }

    /**
     * REGRA DE NEGÓCIO MODERNA: Calcula os valores nutricionais totais da receita.
     * Soma o peso proporcional de cada ingrediente cadastrado com base na referência de 100g.
     */
    protected function valoresNutricionais(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totais = [
                    'calorias'     => 0.00,
                    'carboidratos' => 0.00,
                    'proteinas'    => 0.00,
                    'gorduras'     => 0.00,
                    'sodio'        => 0.00,
                ];

                // Varre os ingredientes associados e calcula a regra de três
                foreach ($this->ingredients as $ingredient) {
                    $pesoUtilizado = (float) $ingredient->pivot->quantidade;

                    // Cálculo: (Valor do nutriente por 100g / 100) * Peso colocado na receita
                    $totais['calorias']     += ($ingredient->calorias / 100) * $pesoUtilizado;
                    $totais['carboidratos'] += ($ingredient->carboidratos / 100) * $pesoUtilizado;
                    $totais['proteinas']    += ($ingredient->proteinas / 100) * $pesoUtilizado;
                    $totais['gorduras']     += ($ingredient->gorduras / 100) * $pesoUtilizado;
                    $totais['sodio']        += ($ingredient->sodio / 100) * $pesoUtilizado;
                }

                return $totais;
            }
        );
    }
}
