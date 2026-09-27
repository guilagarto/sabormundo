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
        $validated = $request->validate([
            'pais_id'     => 'required|exists:paises,id',
            'nome'        => 'required|string|max:255',
            'descricao'   => 'required|string',
            'origem'      => 'nullable|string|max:255',
            'video_url'   => 'nullable|url',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB seguro
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantidade' => 'required|numeric|min:0.01',
            'ingredients.*.unidade_medida' => 'required|string|max:50',
        ]);

        // Processamento do Upload da Foto Real
        $nomeImagem = null;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            // Cria um nome exclusivo baseado no tempo para não sobrescrever arquivos
            $nomeImagem = time() . '_' . Str::slug($validated['nome']) . '.' . $file->getClientOriginalExtension();
            // Move fisicamente para a pasta pública oficial do projeto (Leve e performático)
            $file->move(public_path('uploads/receitas'), $nomeImagem);
        }

        $slug = Str::slug($validated['nome']);
        $count = Receita::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) { $slug = $slug . '-' . ($count + 1); }

        $receita = Receita::create([
            'pais_id'   => $validated['pais_id'],
            'nome'      => $validated['nome'],
            'slug'      => $slug,
            'descricao' => $validated['descricao'],
            'origem'    => $validated['origem'],
            'video_url' => $validated['video_url'],
            'imagen'    => $nomeImagem, // Salva o nome do arquivo no banco
        ]);

        $syncData = [];
        foreach ($validated['ingredients'] as $item) {
            $syncData[$item['id']] = ['quantidade' => $item['quantidade'], 'unidade_medida' => $item['unidade_medida']];
        }
        $receita->ingredients()->attach($syncData);

        return redirect()->route('adm.receitas.index')->with('success', 'Receita e foto gravados com absoluto sucesso!');
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
            'origem'      => 'nullable|string|max:255',
            'video_url'   => 'nullable|url',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantidade' => 'required|numeric|min:0.01',
            'ingredients.*.unidade_medida' => 'required|string|max:50',
        ]);

        // Se o administrador enviou uma nova foto
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nomeImagem = time() . '_' . Str::slug($validated['nome']) . '.' . $file->getClientOriginalExtension();
            
            // Move a nova imagem para a pasta física
            $file->move(public_path('uploads/receitas'), $nomeImagem);

            // Deleta de forma limpa a foto antiga da pasta caso ela exista para não acumular lixo no servidor
            if ($receita->imagen && file_exists(public_path('uploads/receitas/' . $receita->imagen))) {
                @unlink(public_path('uploads/receitas/' . $receita->imagen));
            }

            $receita->imagen = $nomeImagem;
        }

        // Atualiza os dados textuais principais
        $receita->update([
            'pais_id'   => $validated['pais_id'],
            'nome'      => $validated['nome'],
            'slug'      => Str::slug($validated['nome']),
            'descricao' => $validated['descricao'],
            'origem'    => $validated['origem'],
            'video_url' => $validated['video_url'],
        ]);

        // Sincroniza os insumos alimentares da tabela pivô
        $syncData = [];
        foreach ($validated['ingredients'] as $item) {
            $syncData[$item['id']] = [
                'quantidade'     => $item['quantidade'],
                'unidade_medida' => $item['unidade_medida']
            ];
        }
        $receita->ingredients()->sync($syncData);

        return redirect()->route('adm.receitas.index')->with('success', 'Receita e foto atualizados perfeitamente!');
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
