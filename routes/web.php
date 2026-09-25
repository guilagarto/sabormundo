<?php

use App\Http\Controllers\ReceitaController;
use Illuminate\Support\Facades\Route;

// 1. Altere a raiz para carregar a sua nova Home Page do escopo
Route::get('/', function () {
    return view('home');
});

// 2. Protege a sua Dashboard de receitas para entrar APENAS quem estiver logado
Route::middleware(['auth', 'verified'])->group(function () {
    // Listagem principal e Filtro por País
    Route::get('/dashboard', [ReceitaController::class, 'index'])->name('dashboard');
    
    // Cadastro de Nova Receita
    Route::get('/dashboard/receitas/criar', [ReceitaController::class, 'create'])->name('dashboard.create');
    Route::post('/dashboard/receitas/salvar', [ReceitaController::class, 'store'])->name('dashboard.store');

    // NOVAS ROTAS DE AÇÃO:
    // Tela de Edição (passando o ID da receita na URL)
    Route::get('/dashboard/receitas/{id}/editar', [ReceitaController::class, 'edit'])->name('dashboard.edit');
    // Envio dos dados editados (Método PUT para atualização)
    Route::put('/dashboard/receitas/{id}/atualizar', [ReceitaController::class, 'update'])->name('dashboard.update');
    // Ação de Exclusão (Método DELETE por segurança)
    Route::delete('/dashboard/receitas/{id}/excluir', [ReceitaController::class, 'destroy'])->name('dashboard.destroy');
});


// Mantém as rotas de autenticação automáticas do Breeze (Login, Registro, etc.)
require __DIR__.'/auth.php';
