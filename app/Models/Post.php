<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Adicione esta propriedade abaixo para liberar o cadastro em lote pelo controlador
    protected $fillable = [
        'titulo',
        'slug',
        'categoria',
        'conteudo',
        'imagem',
        'visualizacoes'
    ];
}
