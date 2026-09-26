<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Pais;
use Illuminate\Http\Request;

class ReceitaController extends Controller
{
    // Modificado: Lista os países ou filtra as receitas se um país for selecionado
 public function index()
    {
        // Busca os países em ordem alfabética da tabela nova
        $paises = \DB::table('paises')->orderBy('nome', 'asc')->get();
        
        // Pega as receitas com os ingredientes acoplados
        $receitas = Receita::with('ingredientes')->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('paises', 'receitas'));
    }


   public function create()
{
    // REMOVA A LINHA: $paises = Pais::all();
    
    // Lista estática temporária para alimentar o formulário de cadastro
    $paises = collect([
        ['id' => 'Brasil', 'nome' => 'Brasil'],
        ['id' => 'Portugal', 'nome' => 'Portugal'],
        ['id' => 'Italia', 'nome' => 'Itália'],
        ['id' => 'Franca', 'nome' => 'França'],
        ['id' => 'Japao', 'nome' => 'Japão'],
    ])->map(fn($p) => (object)$p);

    return view('dashboard.create', compact('paises'));
}


    /**
     * Salva uma nova receita e seus ingredientes associados no banco de dados.
     */
    public function store(Request $request)
    {
        // 1. Validação simples dos dados do formulário fixo
        $request->validate([
            'titulo' => 'required|max:255',
            'modo_preparo' => 'required',
        ]);

        // 2. Salva os dados básicos da receita na tabela principal
        $receita = new Receita();
        $receita->titulo = $request->titulo;
        $receita->slug = \Illuminate\Support\Str::slug($request->titulo);
        $receita->modo_preparo = $request->modo_preparo;
        $receita->pais = $request->pais; // Se adaptando ao campo de texto do País que criamos
        $receita->imagem = $request->imagem;
        $receita->save(); // Aqui a receita ganha um ID oficial no banco

        // 3. Salva a lista de ingredientes individuais vinculados a esse ID
        if ($request->has('ingredientes_nome')) {
            foreach ($request->ingredientes_nome as $index => $nome) {
                // Só grava se o nome do ingrediente não estiver em branco
                if (!empty($nome)) {
                    \App\Models\RecipeIngredient::create([
                        'receita_id'     => $receita->id,
                        'nome'           => $nome,
                        'quantidade'     => $request->ingredientes_qtd[$index] ?? '',
                        'unidade_medida' => $request->ingredientes_unidade[$index] ?? '',
                    ]);
                }
            }
        }

        // Redireciona de volta para evitar telas brancas
        return redirect()->route('dashboard')->with('sucesso', 'Receita cadastrada com sucesso!');
    }

    

// ... (mantenha seus métodos index, create e store)

// 1. Abre a tela de edição buscando os dados da receita atual e listando os países
  public function edit($id)
    {
        $receita = Receita::with('ingredientes')->findOrFail($id);
        
        // Carrega os países para o select de edição também
        $paises = \DB::table('paises')->orderBy('nome', 'asc')->get();

        return view('dashboard.edit', compact('receita', 'paises'));
    }

// 2. Salva as alterações da receita editada no banco
public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'modo_preparo' => 'required',
        ]);

        $receita = Receita::findOrFail($id);
        $receita->titulo = $request->titulo;
        $receita->slug = \Illuminate\Support\Str::slug($request->titulo);
        $receita->modo_preparo = $request->modo_preparo;
        $receita->pais = $request->pais;
        $receita->imagem = $request->imagem;
        $receita->save();

        // Limpa os ingredientes antigos vinculados para reinserir a nova lista atualizada
        // Essa estratégia é extremamente estável para formulários dinâmicos
        $receita->ingredientes()->delete();

        // Insere a nova lista de ingredientes atualizada vinda da tela
        if ($request->has('ingredientes_nome')) {
            foreach ($request->ingredientes_nome as $index => $nome) {
                if (!empty($nome)) {
                    \App\Models\RecipeIngredient::create([
                        'receita_id'     => $receita->id,
                        'nome'           => $nome,
                        'quantidade'     => $request->ingredientes_qtd[$index] ?? '',
                        'unidade_medida' => $request->ingredientes_unidade[$index] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('sucesso', 'Receita atualizada com sucesso!');
    }

// 3. Exclui a receita do banco de dados de forma definitiva
    public function destroy($id)
        {
            $receita = Receita::findOrFail($id);
            $receita->delete(); // Deleta a receita e o banco apaga os ingredientes associados sozinho

            return redirect()->route('dashboard')->with('sucesso', 'Receita excluída da base de dados!');
        }
    /**
     * Exibe a página pública (Vitrine de Receitas) com os ingredientes acoplados.
     */
    public function homePublica()
    {
        $receitas = \App\Models\Receita::with('ingredientes')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('home', compact('receitas'));
    }

}
