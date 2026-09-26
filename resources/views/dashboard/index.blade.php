<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Sabormundo</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background-color: #f4f6f9; color: #333; padding: 15px; }
        .container { max-width: 900px; margin: 0 auto; }
        
        /* HEADER PRINCIPAL DA DASHBOARD */
        .header-dashboard { background: #1a1a1a; padding: 15px 20px; border-radius: 8px; color: #fff; margin-bottom: 20px; }
        .nav-top { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #333; padding-bottom: 12px; margin-bottom: 12px; }
        .nav-links { display: flex; gap: 15px; align-items: center; }
        .nav-links a { color: #ccc; text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: 0.2s; }
        .nav-links a:hover { color: #fff; }
        
        .user-info { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; }
        .user-icon { background: #ff6b6b; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #fff; }
        
        .btn-logout { background: none; border: none; color: #ff6b6b; cursor: pointer; font-size: 0.9rem; font-weight: bold; }
        
        .header-action { display: flex; justify-content: space-between; align-items: center; }
        .header-action h2 { font-size: 1.3rem; font-weight: bold; }
        
        /* BOTÕES */
        .btn { padding: 6px 14px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; display: inline-block; border: none; cursor: pointer; }
        .btn-add { background-color: #ff6b6b; color: #fff; }
        .btn-add:hover { background-color: #ff4747; }
        .btn-edit { background-color: #ffc107; color: #212529; margin-right: 5px; }
        .btn-del { background-color: #dc3545; color: #fff; }

        /* SEÇÃO DE FILTRO POR PAÍSES */
        .paises-filter { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .paises-title { font-size: 0.95rem; font-weight: bold; margin-bottom: 10px; color: #555; }
        .paises-grid { display: flex; gap: 8px; flex-wrap: wrap; }
        .pais-badge { font-size: 0.8rem; background: #e9ecef; color: #495057; padding: 5px 12px; border-radius: 15px; text-decoration: none; transition: 0.2s; }
        .pais-badge:hover, .pais-badge.active { background: #1a1a1a; color: #fff; }
        
        /* LISTA DE RECEITAS */
        .recipe-list { background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); overflow: hidden; list-style: none; }
        .recipe-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 15px; border-bottom: 1px solid #eee; }
        .recipe-item:last-child { border-bottom: none; }
        
        .recipe-info { display: flex; align-items: center; gap: 15px; }
        .recipe-id { font-size: 0.85rem; color: #999; font-weight: bold; }
        .recipe-thumb { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; background: #eee; }
        .recipe-title { font-size: 0.95rem; font-weight: 600; color: #222; }
        .pais-tag { font-size: 0.7rem; background: #fff0f0; color: #ff6b6b; border: 1px solid #ffcccc; padding: 1px 6px; border-radius: 10px; margin-top: 3px; display: inline-block; }
        
        .recipe-actions { display: flex; align-items: center; }

        /* PAGINAÇÃO */
        .pagination-container { margin-top: 20px; display: flex; justify-content: center; }
        .pagination-container nav { display: flex; gap: 5px; }
        .pagination-container a, .pagination-container span { padding: 8px 12px; background: #fff; border: 1px solid #ddd; color: #333; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .pagination-container .active span { background: #1a1a1a; color: #fff; border-color: #1a1a1a; }

        @media (max-width: 576px) {
            .nav-top { flex-direction: column; gap: 10px; align-items: flex-start; }
            .recipe-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .recipe-actions { width: 100%; justify-content: flex-end; border-top: 1px dashed #eee; padding-top: 8px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- HEADER COMPLETO REORGANIZADO -->
        <header class="header-dashboard">
            <div class="nav-top">
                <div class="nav-links">
                    <a href="/">🏠 Voltar ao Site</a>
                    <a href="{{ route('dashboard') }}" style="font-weight: bold; color: #ff6b6b;">🍽️ Receitas</a>
                </div>
                
                <div class="user-info">
                    <!-- Ícone com a inicial do usuário logado nativo do Breeze -->
                    <div class="user-icon">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span>Olá, <strong>{{ Auth::user()->name }}</strong></span>
                    
                    <!-- Formulário de Logout Seguro exigido pelo Laravel -->
                    <form method="POST" action="{{ route('logout') }}" style="margin-left: 10px;">
                        @csrf
                        <button type="submit" class="btn-logout">Sair</button>
                    </form>
                </div>
            </div>

            <div class="header-action">
                <h2>Gerenciador de Culinária</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-add">+ Nova Receita</a>

            </div>
        </header>

        <!-- SEÇÃO DE FILTROS POR PAÍS -->
        <section class="paises-filter">
            <div class="paises-title">Filtrar por País ({{ $paises->count() }} cadastrados):</div>
            <div class="paises-grid">
                <a href="{{ route('dashboard') }}" class="pais-badge {{ !request()->has('pais_id') ? 'active' : '' }}">Todos</a>
                @foreach($paises as $p)
                    <a href="{{ route('dashboard', ['pais_id' => $p->id]) }}" class="pais-badge {{ request('pais_id') == $p->id ? 'active' : '' }}">
                        {{ $p->nome }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- LISTAGEM DINÂMICA -->
        <ul class="recipe-list">
            @forelse($receitasCadastradas as $receita)
            <li class="recipe-item">
                <div class="recipe-info">
                    <span class="recipe-id">#{{ $receita->id }}</span>
                    @if($receita->imagem)
                        <img src="{{ $receita->imagem }}" class="recipe-thumb" alt="Foto">
                    @else
                        <div class="recipe-thumb" style="display:flex; align-items:center; justify-content:center; font-size:0.6rem; color:#aaa;">Sem foto</div>
                    @endif
                    <div>
                        <span class="recipe-title" style="display: block;">{{ $receita->titulo }}</span>
                        @if($receita->pais)
                            <span class="pais-tag">📍 {{ $receita->pais->nome }}</span>
                        @endif
                    </div>
                </div>
                <div class="recipe-actions">
    <!-- Link de Editar chamando a rota com o ID da receita -->
                <a href="{{ route('dashboard.edit', $receita->id) }}" class="btn btn-edit">Editar</a>
                
                <!-- Formulário seguro para Deletar a Receita -->
                <form action="{{ route('dashboard.destroy', $receita->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta receita permanente?');" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-del">Excluir</button>
                </form>
            </div>

            </li>
            @empty
            <li class="recipe-item" style="justify-content: center; color: #888;">Nenhuma receita encontrada para este país.</li>
            @endforelse
        </ul>

        <div class="pagination-container">
            {{ $receitas->appends(request()->query())->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>

</body>
</html>
