<?php

namespace App\Http\Controllers;
use App\Models\Ingredient;
use App\Models\Pais;
use App\Models\Receita;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Página Inicial Pública: Lista todas as seleções/países da Copa.
     * (Equivalente à sua antiga estrutura da Imagem 2)
     */
    public function index()
    {
        // Padrão de mercado: Busca apenas os dados necessários organizados por ordem alfabética
        $paises = Pais::select('id', 'nome', 'bandeira')
            ->orderBy('nome')
            ->get();

        return view('public.home', compact('paises'));
    }

    /**
     * Cardápio do País: Lista todas as receitas associadas a uma seleção específica.
     * (Equivalente à sua antiga estrutura da Imagem 3)
     */
    public function paisReceitas($id)
    {
        // Carrega o país e já faz o Eager Loading das receitas vinculadas a ele de forma performática
        $pais = Pais::with(['receitas' => function ($query) {
            $query->select('id', 'pais_id', 'nome', 'slug');
        }])->findOrFail($id);

        return view('public.cardapio', compact('pais'));
    }

    /**
     * Detalhes da Receita: Exibe o modo de preparo e o painel nutricional somado.
     * (Equivalente à sua antiga estrutura da Imagem 4)
     */
    public function showReceita($slug)
    {
        // Busca a receita pelo Slug amigável (padrão de SEO de mercado) trazendo país e ingredientes
        $receita = Receita::with(['pais', 'ingredients'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Dispara o nosso Accessor/Attribute do Model para obter o array de macronutrientes já calculados
        $tabelaNutricional = $receita->valores_nutricionais;

        return view('public.receita', compact('receita', 'tabelaNutricional'));
    }
  public function calculadora()
    {
        $ingredients = Ingredient::orderBy('nome', 'asc')->get();
        return view('public.calculadora', compact('ingredients'));
    }

    /**
     * Processa o cruzamento inteligente: Busca receitas compatíveis com os ingredientes que o usuário possui
     */
    public function buscarPorIngredientes(Request $request)
    {
        $ingredientesPossuidos = $request->input('ingredients', []);

        if (empty($ingredientesPossuidos)) {
            return response()->json(['receitas_completas' => [], 'receitas_quase_la' => []]);
        }

        // Busca todas as receitas carregando os ingredientes relacionados
        $receitas = Receita::with(['ingredients', 'pais'])->get();

        $receitasCompletas = [];
        $receitasQuaseLa = [];

        foreach ($receitas as $receita) {
            $idIngredientesReceita = $receita->ingredients->pluck('id')->toArray();
            
            // Verifica quais ingredientes da receita o usuário NÃO possui
            $ingredientesFaltantesIds = array_diff($idIngredientesReceita, $ingredientesPossuidos);
            $totalFaltantes = count($ingredientesFaltantesIds);

            if ($totalFaltantes === 0) {
                // Usuário tem todos os ingredientes!
                $receitasCompletas[] = [
                    'nome' => $receita->nome,
                    'slug' => $receita->slug,
                    'pais' => $receita->pais->nome ?? 'Mundial',
                    'bandeira' => $receita->pais->bandeira ?? '🌍'
                ];
            } elseif ($totalFaltantes <= 2) {
                // Falta apenas 1 ou 2 ingredientes para conseguir fazer o prato
                $nomesFaltantes = Ingredient::whereIn('id', $ingredientesFaltantesIds)->pluck('nome')->toArray();
                
                $receitasQuaseLa[] = [
                    'nome' => $receita->nome,
                    'slug' => $receita->slug,
                    'pais' => $receita->pais->nome ?? 'Mundial',
                    'bandeira' => $receita->pais->bandeira ?? '🌍',
                    'faltando' => $nomesFaltantes
                ];
            }
        }

        return response()->json([
            'receitas_completas' => $receitasCompletas,
            'receitas_quase_la' => $receitasQuaseLa
        ]);
    }


}
