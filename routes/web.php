<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReceitaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NutricaoController;
use App\Models\Receita;
/*
|--------------------------------------------------------------------------
| 1. ROTAS DA ÁREA PÚBLICA (Usuário Final)
|--------------------------------------------------------------------------
*/

// Página Inicial: Lista todos os países da Copa (Referência: Imagem 2)
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// Cardápio do País: Exibe as receitas daquele país específico (Referência: Imagem 3)
Route::get('/pais/{id}', [PublicController::class, 'paisReceitas'])->name('public.pais.receitas');

// Detalhes da Receita: Exibe o modo de preparo e a tabela nutricional completa (Referência: Imagem 4)
Route::get('/receita/{slug}', [PublicController::class, 'showReceita'])->name('public.receita.show');
Route::post('/calculadora/buscar-receitas', [PublicController::class, 'buscarPorIngredientes'])->name('public.calculadora.buscar');
// Rota para exibir a página inicial do Blog Nutricional (onde fica o formulário)
Route::get('/blognutricional', function () {
    return view('blognutricional'); // Certifique-se de que o arquivo se chama blognutricional.blade.php
})->name('public.blognutricional');

// Rota POST que processa o formulário (aquela que criamos na etapa anterior)
Route::post('/blognutricional/calcular', [App\Http\Controllers\NutricaoController::class, 'calcular'])->name('nutricao.calcular');
Route::get('/sobre', function () {
    // Conta quantas linhas existem na tabela de receitas em tempo real
    $totalReceitas = Receita::count(); 
    
    return view('public.sobre', compact('totalReceitas'));
})->name('public.sobre');

Route::post('/newsletter/salvar', [App\Http\Controllers\NutricaoController::class, 'salvarNewsletter'])->name('public.newsletter.salvar');
// Rota para a página interna de leitura completa do artigo
Route::get('/guia-nutricional/{slug}', [App\Http\Controllers\NutricaoController::class, 'exibirPostCompleto'])->name('public.guia.show');

//Route::get('/guia-nutricional', function () {
  //  return view('public.guianutricional'); 
//})->name('public.guianutricional'); 
// Altere a rota antiga por esta linha direcionada ao Controller
Route::get('/guia-nutricional', [App\Http\Controllers\NutricaoController::class, 'exibirGuia'])->name('public.guianutricional');
// Nome alterado para bater com o menu
 // Ajuste o nome da rota se o seu cabeçalho usar outro apelido

/*
|--------------------------------------------------------------------------
| 2. ROTAS DA ÁREA ADMINISTRATIVA (Painel ADM)
|--------------------------------------------------------------------------
| Usamos o 'prefix' para que todas as URLs comecem com /adm (ex: /adm/receitas)
| Usamos o 'name' para que os apelidos comecem com adm. (ex: route('adm.receitas.index'))
*/
Route::group(['prefix' => 'adm', 'as' => 'adm.'], function () {
    
    // Lista as receitas cadastradas e exibe os filtros por país
    Route::get('/receitas', [ReceitaController::class, 'index'])->name('receitas.index');
    
    // Formulário de criação de nova receita
    Route::get('/receitas/criar', [ReceitaController::class, 'create'])->name('receitas.create');
    
    // Processa o salvamento da nova receita no banco de dados
    Route::post('/receitas', [ReceitaController::class, 'store'])->name('receitas.store');
    
    // Formulário de edição de uma receita existente
    Route::get('/receitas/{id}/editar', [ReceitaController::class, 'edit'])->name('receitas.edit');
    
    // Processa a atualização dos dados da receita alterada
    Route::put('/receitas/{id}', [ReceitaController::class, 'update'])->name('receitas.update');
    
    // Remove uma receita do banco de dados
    Route::delete('/receitas/{id}', [ReceitaController::class, 'destroy'])->name('receitas.destroy');
});


Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/pais/{id}', [PublicController::class, 'paisReceitas'])->name('public.pais.receitas');
Route::get('/receita/{slug}', [PublicController::class, 'showReceita'])->name('public.receita.show');
Route::get('/calculadora', [PublicController::class, 'calculadora'])->name('public.calculadora');

/*
|--------------------------------------------------------------------------
| 2. ROTAS DE AUTENTICAÇÃO (Login e Logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. ROTAS ADMINISTRATIVAS PROTEGIDAS (Painel ADM)
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'adm', 'as' => 'adm.', 'middleware' => 'auth'], function () {
    Route::get('/receitas', [ReceitaController::class, 'index'])->name('receitas.index');
    Route::get('/receitas/criar', [ReceitaController::class, 'create'])->name('receitas.create');
    Route::post('/receitas', [ReceitaController::class, 'store'])->name('receitas.store');
    Route::get('/receitas/{id}/editar', [ReceitaController::class, 'edit'])->name('receitas.edit');
    Route::put('/receitas/{id}', [ReceitaController::class, 'update'])->name('receitas.update');
    Route::delete('/receitas/{id}', [ReceitaController::class, 'destroy'])->name('receitas.destroy');
     Route::get('/paises', [App\Http\Controllers\PaisController::class, 'index'])->name('paises.index');
    Route::get('/paises/{id}/editar', [App\Http\Controllers\PaisController::class, 'edit'])->name('paises.edit');
    Route::put('/paises/{id}', [App\Http\Controllers\PaisController::class, 'update'])->name('paises.update');
});
    
