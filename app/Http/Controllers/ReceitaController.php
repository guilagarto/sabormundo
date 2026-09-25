<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Pais;
use Illuminate\Http\Request;

class ReceitaController extends Controller
{
    // Modificado: Lista os países ou filtra as receitas se um país for selecionado
    public function index(Request $request)
    {
        // Pega todos os países para montar o menu/filtros
        $paises = Pais::all();

        // Se o usuário clicou em um país específico, filtra por ele
        if ($request->has('pais_id')) {
            $receitas = Receita::with('pais')
                ->where('pais_id', $request->pais_id)
                ->paginate(15);
        } else {
            // Se não clicou em nada, traz todas de forma paginada
            $receitas = Receita::with('pais')->paginate(15);
        }

        return view('dashboard.index', compact('receitas', 'paises'));
    }

   public function create()
{
    $paises = Pais::all(); // Puxa os países para o formulário de cadastro
    return view('dashboard.create', compact('paises'));
}


    public function store(Request $request)
    {
        // (Mantenha o seu código atual da função store aqui...)
    }
    

// ... (mantenha seus métodos index, create e store)

// 1. Abre a tela de edição buscando os dados da receita atual e listando os países
public function edit($id)
{
    $receita = Receita::findOrFail($id);
    $paises = Pais::all(); // Necessário para o select de países no formulário
    return view('dashboard.edit', compact('receita', 'paises'));
}

// 2. Salva as alterações da receita editada no banco
public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|max:255',
        'ingredientes' => 'required',
        'modo_preparo' => 'required',
        'pais_id' => 'required|integer',
    ]);

    $receita = Receita::findOrFail($id);
    $receita->titulo = $request->titulo;
    $receita->slug = \Illuminate\Support\Str::slug($request->titulo);
    $receita->ingredientes = $request->ingredientes;
    $receita->modo_preparo = $request->modo_preparo;
    $receita->pais_id = $request->pais_id;
    $receita->imagem = $request->imagem;
    $receita->save();

   return redirect()->route('dashboard')->with('sucesso', 'Receita lançada com sucesso!');

}

// 3. Exclui a receita do banco de dados de forma definitiva
public function destroy($id)
{
    $receita = Receita::findOrFail($id);
    $receita->delete();

    return redirect()->back()->with('sucesso', 'Receita excluída com sucesso!');
}

}
