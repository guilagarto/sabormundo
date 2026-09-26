<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * O caminho padrão de redirecionamento pós-autenticação do Laravel Breeze.
     * No padrão moderno de mercado, declaramos a constante diretamente aqui.
     */
    public const HOME = '/adm/receitas';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
