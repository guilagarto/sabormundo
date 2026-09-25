<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Receitas - Sabormundo</title>
    <style>
        /* CSS Interno Ultra-Leve e Focado em Celular */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background-color: #f4f6f9; color: #333; padding: 15px; }
        
        .container { max-width: 800px; margin: 0 auto; }
        
        /* Cabeçalho do Painel */
        .header-panel { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #1a1a1a; padding: 15px; border-radius: 8px; color: #fff; }
        .header-panel h2 { font-size: 1.2rem; font-weight: bold; }
        
        /* Botões */
        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; display: inline-block; border: none; cursor: pointer; }
        .btn-add { background-color: #ff6b6b; color: #fff; }
        .btn-add:hover { background-color: #ff4747; }
        .btn-edit { background-color: #ffc107; color: #212529; margin-right: 5px; }
        .btn-del { background-color: #dc3545; color: #fff; }
        
        /* Lista estilo Cards para Celular / Tabela Leve */
        .recipe-list { background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); overflow: hidden; list-style: none; }
        .recipe-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 15px; border-bottom: 1px solid #eee; }
        .recipe-item:last-child { border-bottom: none; }
        
        .recipe-info { display: flex; align-items: center; gap: 15px; }
        .recipe-id { font-size: 0.85rem; color: #999; font-weight: bold; }
        .recipe-thumb { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; background: #eee; }
        .recipe-title { font-size: 0.95rem; font-weight: 600; color: #222; }
        
        .recipe-actions { display: flex; align-items: center; }

        /* Estilização da Paginação do Laravel */
        .pagination-container { margin-top: 20px; display: flex; justify-content: center; }
        .pagination-container nav { display: flex; gap: 5px; list-style: none; }
        .pagination-container a, .pagination-container span { padding: 8px 12px; background: #fff; border: 1px solid #ddd; color: #333; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .pagination-container .active span { background: #1a1a1a; color: #fff; border-color: #1a1a1a; }

        @media (max-width: 576px) {
            .recipe-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .recipe-actions { width: 100%; justify-content: flex-end; border-top: 1px dashed #eee; padding-top: 8px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <header class="header-panel">
            <h2>🌍 Painel Sabormundo</h2>
            <a href="{{ route('dashboard.create') }}" class="btn btn-add">+ Nova Receita</a>
        </header>

        <ul class="recipe-list">
            @foreach($receitas as $receita)
            <li class="recipe-item">
                <div class="recipe-info">
                    <span class="recipe-id">#{{ $receita->id }}</span>
                    @if($receita->imagem)
                        <img src="{{ $receita->imagem }}" class="recipe-thumb" alt="Foto">
                    @else
                        <div class="recipe-thumb" style="display:flex; align-items:center; justify-content:center; font-size:0.6rem; color:#aaa; text-align:center;">Sem foto</div>
                    @endif
                    <span class="recipe-title">{{ $receita->titulo }}</span>
                </div>
                <div class="recipe-actions">
                    <a href="#" class="btn btn-edit">Editar</a>
                    <button class="btn btn-del">Excluir</button>
                </div>
            </li>
            @endforeach
        </ul>

        <!-- Exibe os links de página 1, 2, 3... de forma automatizada -->
        <div class="pagination-container">
            {{ $receitas->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>

</body>
</html>
