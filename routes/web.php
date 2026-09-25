<?php

use App\Http\Controllers\ReceitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\Receita;

// 1. Altere a raiz para carregar a sua nova Home Page do escopo
Route::get('/', function () {
    $receitas = Receita::with('ingredientes')->orderBy('created_at', 'desc')->get();
    return view('home', compact('receitas'));
});

// 2. Protege a sua Dashboard de receitas para entrar APENAS quem estiver logado
// 2. Protege a sua Dashboard de receitas
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Listagem principal e filtro
    Route::get('/dashboard', [ReceitaController::class, 'index'])->name('dashboard');
    
    // Telas de criação e salvamento de novas receitas
    Route::get('/dashboard/receitas/criar', [ReceitaController::class, 'create'])->name('receitas.create');
    Route::post('/dashboard/receitas/salvar', [ReceitaController::class, 'store'])->name('receitas.store');
    
    // Telas de edição e atualização de receitas existentes
    Route::get('/dashboard/receitas/{id}/editar', [ReceitaController::class, 'edit'])->name('receitas.edit');
    Route::put('/dashboard/receitas/{id}/atualizar', [ReceitaController::class, 'update'])->name('receitas.update');
    
    // Ação de exclusão
    Route::delete('/dashboard/receitas/{id}/excluir', [ReceitaController::class, 'destroy'])->name('receitas.destroy');
});
// Rota pública do site (Acessível a qualquer visitante)
Route::get('/', [ReceitaController::class, 'homePublica'])->name('home');


// Mantém as rotas de autenticação automáticas do Breeze (Login, Registro, etc.)
require __DIR__.'/auth.php';
