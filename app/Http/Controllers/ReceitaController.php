<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use Illuminate\Http\Request;

class ReceitaController extends Controller
{
    // Método que vai abrir a página inicial da Dashboard com a lista de receitas
        public function index()
    {
        // Puxa apenas 15 receitas por página ao invés de todas
        $receitas = Receita::paginate(15);

        return view('dashboard.index', compact('receitas'));
    }

    // Abre a página com o formulário de cadastro
public function create()
{
    return view('dashboard.create');
}

// Recebe os dados do formulário e grava no banco de dados
public function store(Request $request)
{
    // Validação rápida dos campos obrigatórios conforme seu banco de dados
    $request->validate([
        'titulo' => 'required|max:255',
        'ingredientes' => 'required',
        'modo_preparo' => 'required',
        'pais_id' => 'required|integer',
    ]);

    // Cria a receita usando o modelo Eloquent
    $receita = new Receita();
    $receita->titulo = $request->titulo;
    
    // Gerando um slug simples baseado no título para manter o padrão da tabela
    $receita->slug = \Illuminate\Support\Str::slug($request->titulo);
    
    $receita->ingredientes = $request->ingredientes;
    $receita->modo_preparo = $request->modo_preparo;
    $receita->pais_id = $request->pais_id;
    $receita->imagem = $request->imagem; // temporariamente como texto simples
    
    $receita->save();

    // Redireciona de volta para a lista com mensagem de sucesso
    return redirect()->route('dashboard.index')->with('sucesso', 'Receita lançada com sucesso!');
}

}
