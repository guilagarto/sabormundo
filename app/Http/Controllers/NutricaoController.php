<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receita;
use App\Models\LeadNewsletter;

class NutricaoController extends Controller
{
    public function calcular(Request $request)
    {
        // 1. Validação dos dados digitados
        $data = $request->validate([
            'objetivo' => 'required|string',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'altura' => 'required|numeric',
            'peso' => 'required|numeric',
            'nivel_atividade' => 'required|string',
            'frequencia' => 'required|integer',
            'restricoes' => 'nullable|string',
            'rejeitados' => 'nullable|string',
        ]);

        // 2. Cálculo da Taxa Metabólica Basal (Fórmula de Harris-Benedict)
        if ($data['sexo'] === 'M') {
            $bmr = 66.47 + (13.75 * $data['peso']) + (5.00 * $data['altura']) - (6.75 * $data['idade']);
        } else {
            $bmr = 655.1 + (9.56 * $data['peso']) + (1.85 * $data['altura']) - (4.68 * $data['idade']);
        }

        // 3. Ajuste do fator de atividade física baseado no nível selecionado
        $fatores = [
            'sedentario' => 1.2,
            'leve'       => 1.375,
            'moderado'   => 1.55,
            'intenso'    => 1.725
        ];
        $fatorAtividade = $fatores[$data['nivel_atividade']] ?? 1.2;
        $tdee = $bmr * $fatorAtividade; // Gasto Calórico Total Diário

        // 4. Definição do plano calórico, macros e resposta explicativa personalizada
        $caloriasAlvo = $tdee;
        $respostaTexto = "";

        switch ($data['objetivo']) {
            case 'emagrecimento':
                $caloriasAlvo = $tdee - 500; // Déficit calórico de segurança
                $respostaTexto = "Para emagrecer de forma saudável, você precisa entrar em déficit calórico moderado. Seu plano foi ajustado para focar em alimentos de alta densidade nutricional e baixo valor calórico, garantindo saciedade com carboidratos complexos e fibras.";
                break;
                
            case 'ganho_massa':
                $caloriasAlvo = $tdee + 350; // Superávit para construção muscular
                $respostaTexto = "Para o ganho de massa muscular (hipertrofia), seu corpo necessita de um superávit calórico controlado combinado com o aporte correto de proteínas para regenerar os tecidos musculares. Priorize receitas ricas em proteínas magras e carboidratos de boa qualidade.";
                break;
                
            case 'ganho_peso':
                $caloriasAlvo = $tdee + 500;
                $respostaTexto = "Para ganhar peso geral, o foco do seu plano é o superávit calórico saudável, consumindo mais energia do que gasta. Selecionamos opções com gorduras boas e carboidratos densos para bater suas metas sem sobrecarregar o estômago.";
                break;
                
            case 'equilibrio':
                $respostaTexto = "Seu foco é a manutenção do peso e o equilíbrio celular. Seu plano prioriza a máxima variedade de micronutrientes (vitaminas e minerais), controlando açúcares refinados e gorduras saturadas para promover longevidade e bem-estar.";
                break;
        }

        // 5. Processamento dos termos indesejados para filtragem inteligente
        $termosParaBloquear = [];
        if (!empty($data['restricoes'])) {
            $termosParaBloquear = array_merge($termosParaBloquear, explode(',', $data['restricoes']));
        }
        if (!empty($data['rejeitados'])) {
            $termosParaBloquear = array_merge($termosParaBloquear, explode(',', $data['rejeitados']));
        }
        
        // Limpa espaços em branco dos termos digitados pelo usuário
        $termosParaBloquear = array_map('trim', $termosParaBloquear);

        // 6. Query Avançada no Banco de Dados para buscar receitas ideais
               // 6. Query Avançada no Banco de Dados para buscar receitas ideais
        $receitasSugeridas = Receita::with('ingredients');

        // Só aplica o filtro se houver algum ingrediente para bloquear
        if (!empty($termosParaBloquear) && count(array_filter($termosParaBloquear)) > 0) {
            $receitasSugeridas->whereDoesntHave('ingredients', function($query) use ($termosParaBloquear) {
                $query->where(function($q) use ($termosParaBloquear) {
                    foreach ($termosParaBloquear as $termo) {
                        if (!empty($termo)) {
                            $q->orWhere('nome', 'LIKE', '%' . $termo . '%');
                        }
                    }
                });
            });
        }

                // Busca as 4 receitas filtradas
        $receitasSugeridas = $receitasSugeridas->inRandomOrder()->limit(4)->get();

        // Faz o cálculo matemático somando os macros reais da tabela TACO para cada receita
        foreach ($receitasSugeridas as $receita) {
            $totalCalorias = 0;
            $totalCarboidratos = 0;
            $totalProteinas = 0;
            $totalGorduras = 0;
            $totalSodio = 0;

            foreach ($receita->ingredients as $ingrediente) {
                // Pega o peso em gramas do ingrediente cadastrado na tabela pivot recipe_ingredients
                $quantidadeUsada = $ingrediente->pivot->quantidade;
                
                // Como os dados da TACO são mapeados por 100g base, calculamos o fator multiplicador
                $fator = $quantidadeUsada / 100;

                $totalCalorias += $ingrediente->calorias * $fator;
                $totalCarboidratos += $ingrediente->carboidratos * $fator;
                $totalProteinas += $ingrediente->proteinas * $fator;
                $totalGorduras += $ingrediente->gorduras * $fator;
                $totalSodio += $ingrediente->sodio * $fator;
            }

            // Injeta as propriedades calculadas dinamicamente na receita para usar no Blade
            $receita->total_calorias = $totalCalorias;
            $receita->total_carboidratos = $totalCarboidratos;
            $receita->total_proteinas = $totalProteinas;
            $receita->total_gorduras = $totalGorduras;
            $receita->total_sodio = $totalSodio;
        }

        // 7. Retorna a view de resultado levando todas as variáveis calculadas
        return view('public.resultado', [
            'caloriasAlvo' => round($caloriasAlvo, 0),
            'gastoTotal'   => round($tdee, 0),
            'resposta'     => $respostaTexto,
            'receitas'     => $receitasSugeridas,
            'objetivo'     => $data['objetivo']
        ]);




    }
    public function salvarNewsletter(Request $request)
{
    // Valida se o campo é um e-mail real e se já não existe no banco
    $request->validate([
        'email' => 'required|email|unique:lead_newsletters,email',
    ], [
        'email.required' => 'O campo de e-mail é obrigatório.',
        'email.email' => 'Por favor, insira um endereço de e-mail válido.',
        'email.unique' => 'Este e-mail já está cadastrado na nossa newsletter!',
    ]);

    // Salva o e-mail no banco de dados
    LeadNewsletter::create([
        'email' => $request->email
    ]);

    // Retorna para a página anterior com uma mensagem de sucesso
    return redirect()->back()->with('success', 'Inscrição realizada com sucesso! Obrigado por fazer parte do Mundo Sabor.');
}
}
