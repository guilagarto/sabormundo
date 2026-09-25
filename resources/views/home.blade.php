<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabormundo - Receitas do Mundo</title>
    <style>
        /* CSS Interno e Otimizado para Carregamento Instantâneo */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f6f9; color: #333; line-height: 1.6; }
        
        /* Menu Superior */
        .navbar { background-color: #1a1a1a; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .navbar-brand { color: #fff; text-decoration: none; font-weight: bold; font-size: 1.3rem; }
        .btn-login { background-color: transparent; color: #fff; border: 1px solid #fff; padding: 6px 15px; border-radius: 4px; text-decoration: none; font-size: 0.9rem; transition: 0.2s; }
        .btn-login:hover { background-color: #fff; color: #1a1a1a; }

        /* Banner de Busca */
        .banner { background: linear-gradient(135deg, #ff6b6b, #ff8e8e); color: #fff; text-align: center; padding: 60px 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .banner h1 { font-size: 2.5rem; margin-bottom: 10px; font-weight: 800; }
        .search-box { width: 100%; max-width: 500px; padding: 12px 25px; border: none; border-radius: 25px; font-size: 1rem; margin-top: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); outline: none; }

        /* Layout em Colunas */
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; display: flex; gap: 30px; }
        
        /* Sidebar Lateral */
        .sidebar { flex: 1; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; height: fit-content; }
        .sidebar-title { background-color: #1a1a1a; color: #fff; padding: 15px; font-weight: bold; font-size: 1rem; }
        .sidebar-item { display: block; padding: 12px 15px; color: #555; text-decoration: none; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        .sidebar-item:hover { background-color: #f8f9fa; color: #ff6b6b; padding-left: 20px; transition: 0.2s; }

        /* Conteúdo das Receitas */
        .content { flex: 3; }
        .content-title { font-size: 1.5rem; margin-bottom: 20px; font-weight: 700; color: #222; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        
        /* Cards */
        .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
        .card-title { font-size: 1.1rem; font-weight: bold; margin-bottom: 10px; color: #1a1a1a; }
        .card-text { font-size: 0.9rem; color: #777; margin-bottom: 15px; }

        /* Responsividade para Celulares */
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .banner h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a class="navbar-brand" href="/">🌍 Sabormundo</a>
        <div>
            <a href="{{ route('login') }}" class="btn-login">Entrar (Painel)</a>
        </div>
    </nav>

    <div class="banner">
        <h1>O que você vai cozinhar hoje?</h1>
        <p>Encontre receitas do mundo inteiro organizadas de forma ultra-rápida.</p>
        <input type="text" class="search-box" placeholder="🔍 Buscar receitas ou ingredientes...">
    </div>

    <div class="container">
        <!-- Menu Lateral baseado no Escopo -->
        <aside class="sidebar">
            <div class="sidebar-title">🍴 Refeições</div>
            <a href="#" class="sidebar-item">Todas as receitas</a>
            <a href="#" class="sidebar-item">Café da manhã</a>
            <a href="#" class="sidebar-item">Almoço</a>
            <a href="#" class="sidebar-item">Jantar</a>
        </aside>

        <!-- Grade de Receitas -->
        <main class="content">
            <h3 class="content-title">⭐ Receitas em Destaque</h3>
            <div class="grid">
                <div class="card">
                    <h5 class="card-title">Exemplo de Receita</h5>
                    <p class="card-text">O layout está limpo, leve e pronto para carregar os dados instantaneamente.</p>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
