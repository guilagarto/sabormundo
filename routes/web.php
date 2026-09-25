<?php

use App\Http\Controllers\ReceitaController;
use Illuminate\Support\Facades\Route;

// 1. Altere a raiz para carregar a sua nova Home Page do escopo
Route::get('/', function () {
    return view('home');
});

// 2. Protege a sua Dashboard de receitas para entrar APENAS quem estiver logado
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Lista as receitas na Dashboard
    // Altere apenas o ->name() para 'dashboard' para alinhar com o motor do Breeze
Route::get('/dashboard', [ReceitaController::class, 'index'])->name('dashboard');

    
    // Abre o formulário de cadastro
    Route::get('/dashboard/receitas/criar', [ReceitaController::class, 'create'])->name('dashboard.create');
    
    // Salva a receita nova no banco
    Route::post('/dashboard/receitas/salvar', [ReceitaController::class, 'store'])->name('dashboard.store');
});

// Mantém as rotas de autenticação automáticas do Breeze (Login, Registro, etc.)
require __DIR__.'/auth.php';
