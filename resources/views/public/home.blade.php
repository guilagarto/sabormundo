<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Sabor - Seleções da Copa</title>
    <style>
        /* CSS Puro de Alta Performance */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; padding: 0; }
        .navbar { background-color: #1e293b; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-size: 22px; font-weight: 800; color: #38bdf8; text-decoration: none; letter-spacing: 0.5px; }
        .navbar .btn-adm { text-decoration: none; color: #f8fafc; background-color: #334155; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600; transition: background 0.2s; }
        .navbar .btn-adm:hover { background-color: #475569; }
        
        .container { max-width: 1000px; margin: 50px auto; padding: 0 20px; text-align: center; }
        .hero h1 { font-size: 36px; font-weight: 800; margin-bottom: 10px; color: #ffffff; }
        .hero p { font-size: 16px; color: #94a3b8; margin-bottom: 40px; }
        
        /* Grid das Seleções / Países */
        .countries-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 25px; }
        .country-card { display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #1e293b; border: 1px solid #334155; padding: 30px 20px; border-radius: 12px; text-decoration: none; color: #ffffff; font-weight: 700; font-size: 18px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s, border-color 0.2s; }
        .country-card:hover { transform: translateY(-4px); border-color: #38bdf8; background-color: #243249; }
        .country-flag { font-size: 40px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <!-- Header / Navbar (Referência: Imagem 2 do escopo) -->
    <nav class="navbar">
        <a href="{{ route('public.home') }}" class="logo">🌍 Mundo Sabor</a>
        <a href="{{ route('adm.receitas.index') }}" class="btn-adm">Painel Administrador</a>
    </nav>

    <div class="container">
        
        <!-- Seção Hero -->
        <div class="hero">
            <h1>Culinária das Seleções Mundiais</h1>
            <p>Escolha um dos países abaixo para explorar as receitas tradicionais e conferir sua tabela nutricional completa.</p>
        </div>

        <!-- Grid de Países vindos do Banco Sabor_db -->
        <div class="countries-grid">
            @forelse($paises as $pais)
                <a href="{{ route('public.pais.receitas', $pais->id) }}" class="country-card">
                    <!-- Ícone de bandeira padrão caso o campo esteja vazio no banco -->
                    <div class="country-flag">🏳️</div>
                    <div>{{ $pais->nome }}</div>
                </a>
            @empty
                <div style="grid-column: span 4; color: #94a3b8; padding: 40px;">
                    Nenhum país cadastrado no banco ainda. Certifique-se de rodar o seeder.
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>
