<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReceitaController;
use Illuminate\Support\Facades\Route;

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
