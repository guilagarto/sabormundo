<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Ingredient;
use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReceitaController extends Controller
{
    /**
     * Painel Administrativo: Lista todas as receitas cadastradas com paginação.
     */
    public function index(Request $request)
    {
        $paises = Pais::select('id', 'nome')->orderBy('nome')->get();
        
        // Eager Loading (with) para carregar o país e os ingredientes evitando lentidão no banco
        $query = Receita::with(['pais', 'ingredients']);

        // Filtro opcional por país
        if ($request->filled('pais_id')) {
            $query->where('pais_id', $request->pais_id);
        }

        $receitas = $query->latest()->paginate(10);

        return view('adm.receitas.index', compact('receitas', 'paises'));
    }

    /**
     * Exibe o formulário de cadastro de receitas.
     */
    public function create()
    {
        $paises = Pais::select('id', 'nome')->orderBy('nome')->get();
        $ingredients = Ingredient::select('id', 'nome')->orderBy('nome')->get();

        return view('adm.receitas.create', compact('paises', 'ingredients'));
    }

    /**
     * Processa e salva a nova receita com seus ingredientes associados.
     */
    public function store(Request $request)
    {
        // 1. Validação estrita
        $validated = $request->validate([
            'pais_id'     => 'required|exists:paises,id',
            'nome'        => 'required|string|max:255',
            'descricao'   => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantidade' => 'required|numeric|min:0.01',
            'ingredients.*.unidade_medida' => 'required|string|max:50',
        ]);

        // 2. Geração automática do Slug com o helper do Laravel
        $slug = Str::slug($validated['nome']);
        
        // Garante que o slug seja único se houver pratos com o mesmo nome
        $count = Receita::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // 3. Persistência da Receita Base
        $receita = Receita::create([
            'pais_id'   => $validated['pais_id'],
            'nome'      => $validated['nome'],
            'slug'      => $slug,
            'descricao' => $validated['descricao'],
        ]);

        // 4. Mapeamento e Salvamento dos ingredientes na tabela pivô
        $syncData = [];
        foreach ($validated['ingredients'] as $item) {
            $syncData[$item['id']] = [
                'quantidade'     => $item['quantidade'],
                'unidade_medida' => $item['unidade_medida']
            ];
        }
        $receita->ingredients()->attach($syncData);

        return redirect()->route('adm.receitas.index')->with('success', 'Receita cadastrada com absoluto sucesso!');
    }

    /**
     * Exibe o formulário de edição pré-populado.
     */
    public function edit($id)
    {
        // Traz a receita ou falha com erro 404 de forma limpa
        $receita = Receita::with('ingredients')->findOrFail($id);
        $paises = Pais::select('id', 'nome')->orderBy('nome')->get();
        $ingredients = Ingredient::select('id', 'nome')->orderBy('nome')->get();

        return view('adm.receitas.edit', compact('receita', 'paises', 'ingredients'));
    }

    /**
     * Processa a atualização da receita e sincroniza novos ingredientes.
     */
    public function update(Request $request, $id)
    {
        $receita = Receita::findOrFail($id);

        $validated = $request->validate([
            'pais_id'     => 'required|exists:paises,id',
            'nome'        => 'required|string|max:255',
            'descricao'   => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantidade' => 'required|numeric|min:0.01',
            'ingredients.*.unidade_medida' => 'required|string|max:50',
        ]);

        // Atualiza os dados principais e refaz o slug baseado no novo nome caso mude
        $receita->update([
            'pais_id'   => $validated['pais_id'],
            'nome'      => $validated['nome'],
            'slug'      => Str::slug($validated['nome']),
            'descricao' => $validated['descricao'],
        ]);

        // O método 'sync' remove do banco os ingredientes antigos que saíram da lista 
        // e adiciona os novos/modificados automaticamente de uma só vez
        $syncData = [];
        foreach ($validated['ingredients'] as $item) {
            $syncData[$item['id']] = [
                'quantidade'     => $item['quantidade'],
                'unidade_medida' => $item['unidade_medida']
            ];
        }
        $receita->ingredients()->sync($syncData);

        return redirect()->route('adm.receitas.index')->with('success', 'Receita atualizada perfeitamente!');
    }

    /**
     * Remove a receita e todas as suas associações automaticamente por causa da constraint Cascade.
     */
    public function destroy($id)
    {
        $receita = Receita::findOrFail($id);
        $receita->delete();

        return redirect()->route('adm.receitas.index')->with('success', 'Receita excluída do sistema.');
    }
}
