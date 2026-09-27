<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel ADM') - Mundo Sabor</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; color: #334155; margin: 0; padding: 0; }
        
        /* HEADER / NAVBAR EXPANSÍVEL (Alta performance) */
        .admin-header { background-color: #0f172a; color: #ffffff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .admin-brand { display: flex; align-items: center; gap: 20px; }
        .admin-logo { font-size: 20px; font-weight: 800; color: #38bdf8; text-decoration: none; }
        
        /* LINKS DO MENU (Fácil de adicionar coisas novas depois) */
        .admin-menu { display: flex; gap: 15px; }
        .menu-link { text-decoration: none; color: #94a3b8; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 6px; transition: all 0.2s; }
        .menu-link:hover, .menu-link.active { color: #ffffff; background-color: #1e293b; }
        
        /* PERFIL E BOTÃO SAIR */
        .admin-user-zone { display: flex; align-items: center; gap: 15px; }
        .user-name { font-size: 14px; color: #cbd5e1; font-weight: 500; }
        .btn-logout { background: none; border: 1px solid #ef4444; color: #ef4444; padding: 6px 12px; font-size: 13px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: all 0.2s; }
        .btn-logout:hover { background-color: #ef4444; color: #ffffff; }
        
        .main-container { max-width: 1000px; margin: 40px auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
    </style>
    @yield('styles')
</head>
<body>

    <!-- HEADER PRINCIPAL COMPARTILHADO -->
    <header class="admin-header">
        <div class="admin-brand">
            <a href="{{ route('public.home') }}" class="admin-logo">🌍 Mundo Sabor ADM</a>
            
            <!-- Links do Menu: Expansível para novas abas futuramente -->
                        <!-- Links do Menu: Expansível para novas abas -->
            <nav class="admin-menu">
                <a href="{{ route('adm.receitas.index') }}" class="menu-link {{ request()->routeIs('adm.receitas.*') ? 'active' : '' }}">🍲 Receitas</a>
                <a href="{{ route('adm.paises.index') }}" class="menu-link {{ request()->routeIs('adm.paises.*') ? 'active' : '' }}">🏳️ Países</a>
            </nav>

        </div>

        <!-- SESSÃO DO USUÁRIO LOGADO -->
        <div class="admin-user-zone">
            <span class="user-name">👤 {{ Auth::user()->name ?? 'Admin' }}</span>
            
            <!-- Formulário seguro para deslogar (padrão de mercado contra ataques CSRF) -->
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>
    </header>

    <!-- CONTEÚDO DINÂMICO DE CADA TELA -->
    <div class="main-container">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
