<?php

namespace App\Http\Controllers;

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
}
