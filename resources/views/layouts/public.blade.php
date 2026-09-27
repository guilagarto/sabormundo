<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mundo Sabor') - Seleções da Copa</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; padding: 0; }
        
        /* HEADER VERDE PADRÃO (Referência: Imagem 2 do escopo) */
        .public-navbar { background-color: #14532d; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2); }
        .public-logo { font-size: 20px; font-weight: 800; color: #38bdf8; text-decoration: none; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; }
        
        .public-menu { display: flex; gap: 15px; align-items: center; }
        .menu-item { text-decoration: none; color: #cbd5e1; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 6px; transition: all 0.2s; }
        .menu-item:hover, .menu-item.active { color: #ffffff; background-color: #166534; }
        
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; box-sizing: border-box; }
    </style>
    @yield('styles')
</head>
<body>

    <!-- NAVBAR PÚBLICA VERDE UNIFICADA -->
    <nav class="public-navbar">
        <a href="{{ route('public.home') }}" class="public-logo">🌍 Mundo Sabor</a>
        
        <div class="public-menu">
            <a href="{{ route('public.home') }}" class="menu-item {{ request()->routeIs('public.home') ? 'active' : '' }}">🔥 Início</a>
            <a href="#" class="menu-item">📊 Guia Nutricional</a>
            <a href="#" class="menu-item">📖 Sobre</a>
            <a href="#" class="menu-item">📰 Blog Nutricional</a>
            <a href="{{ route('public.calculadora') }}" class="menu-item {{ request()->routeIs('public.calculadora') ? 'active' : '' }}">🧮 Calculadora</a>
            <a href="{{ route('adm.receitas.index') }}" class="menu-item" style="background-color: #166534; color: #f8fafc;">💻 ADM</a>
        </div>
    </nav>

    <!-- CONTEÚDO DINÂMICO DAS PÁGINAS -->
    <div class="container">
        @yield('content')
    </div>
@yield('scripts')

</body>
</html>
