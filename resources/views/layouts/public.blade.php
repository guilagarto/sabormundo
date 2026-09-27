<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mundo Sabor') - Seleções da Copa</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; padding: 0; }
        
        /* NAVBAR RESPONSIVA COM MENU HAMBÚRGUER */
        .public-navbar { background-color: #14532d; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2); position: relative; z-index: 999; }
        .public-logo { font-size: 20px; font-weight: 800; color: #38bdf8; text-decoration: none; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; }
        
        /* Ícone dos Três Tracinhos */
        .menu-toggle { display: none; background: none; border: none; color: #ffffff; font-size: 24px; cursor: pointer; padding: 5px; outline: none; }
        
        .public-menu { display: flex; gap: 10px; align-items: center; }
        .menu-item { text-decoration: none; color: #cbd5e1; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 6px; transition: all 0.2s; }
        .menu-item:hover, .menu-item.active { color: #ffffff; background-color: #166534; }
        
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; box-sizing: border-box; }

        /* REGRAS DE DESIGN SÓ PARA CELULARES */
        @media (max-width: 768px) {
            .menu-toggle { display: block; } /* Ativa os três risquinhos */
            
            .public-menu { 
                display: none; /* Esconde o menu por padrão */
                flex-direction: column; 
                position: absolute; 
                top: 100%; 
                left: 0; 
                width: 100%; 
                background-color: #14532d; 
                padding: 15px 0; 
                box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3);
                gap: 5px;
            }
            
            /* Classe que o JavaScript vai injetar ao clicar nos 3 risquinhos */
            .public-menu.active { display: flex; } 
            
            .menu-item { width: 90%; justify-content: center; padding: 12px 0; font-size: 15px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- NAVBAR PÚBLICA VERDE RESPONSIVA -->
    <nav class="public-navbar">
        <a href="{{ route('public.home') }}" class="public-logo">🌍 Mundo Sabor</a>
        
        <!-- Botão Hambúrguer -->
        <button class="menu-toggle" id="menu-mobile-trigger" aria-label="Abrir Menu">☰</button>
        
        <div class="public-menu" id="public-menu-box">
            <a href="{{ route('public.home') }}" class="menu-item {{ request()->routeIs('public.home') ? 'active' : '' }}">🔥 Início</a>
            <a href="{{ route('public.guianutricional') }}" class="menu-item {{ request()->routeIs('public.guianutricional') ? 'active' : '' }}">📊 Blog Nutricional</a>
            <a href="{{ route('public.sobre') }}" class="menu-item {{ request()->routeIs('public.sobre') ? 'active' : '' }}">📖 Sobre</a>
            <a href="{{ route('public.blognutricional') }}" class="menu-item {{ request()->routeIs('public.blognutricional') ? 'active' : '' }}">📰 Guia Nutricional</a>
            <a href="{{ route('public.calculadora') }}" class="menu-item {{ request()->routeIs('public.calculadora') ? 'active' : '' }}">🧮 Calculadora</a>
            <a href="{{ route('adm.receitas.index') }}" class="menu-item" style="background-color: #166534; color: #f8fafc;">💻 ADM</a>
        </div>


    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Script de ativação do menu móvel -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('menu-mobile-trigger');
            const menu = document.getElementById('public-menu-box');

            if (trigger && menu) {
                trigger.addEventListener('click', function() {
                    menu.classList.toggle('active');
                    // Alterna o ícone entre os três risquinhos (☰) e o X de fechar (✕)
                    if (menu.classList.contains('active')) {
                        trigger.innerHTML = '✕';
                    } else {
                        trigger.innerHTML = '☰';
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
