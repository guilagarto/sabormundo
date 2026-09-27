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
        'origem',     // Novo campo
        'video_url',  // Novo campo
        'imagen',     // Campo de foto
    ];

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
                    ->withPivot('quantidade', 'unidade_medida')
                    ->withTimestamps();
    }

    /**
     * MUTATOR MODERNO: Pega qualquer link normal do YouTube enviado pelo ADM 
     * e o converte no código de EMBED correto para rodar direto na página.
     */
    protected function videoUrl(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (empty($value)) return null;
                
                // Trata links formato ://youtube.com ou youtu.be/ID
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $match);
                
                return isset($match[1]) ? 'https://youtube.com' . $match[1] : $value;
            }
        );
    }

    /**
     * Calcula os valores nutricionais totais somados
     */
    protected function valoresNutricionais(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totais = ['calorias' => 0, 'carboidratos' => 0, 'proteinas' => 0, 'gorduras' => 0, 'sodio' => 0];
                foreach ($this->ingredients as $ingredient) {
                    $peso = (float) $ingredient->pivot->quantidade;
                    $totais['calorias']     += ($ingredient->calorias / 100) * $peso;
                    $totais['carboidratos'] += ($ingredient->carboidratos / 100) * $peso;
                    $totais['proteinas']    += ($ingredient->proteinas / 100) * $peso;
                    $totais['gorduras']     += ($ingredient->gorduras / 100) * $peso;
                    $totais['sodio']        += ($ingredient->sodio / 100) * $peso;
                }
                return $totais;
            }
        );
    }
}
