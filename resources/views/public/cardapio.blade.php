<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Sabor - {{ $pais->nome }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; padding: 0; }
        .navbar { background-color: #1e293b; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-size: 22px; font-weight: 800; color: #38bdf8; text-decoration: none; letter-spacing: 0.5px; }
        .navbar .btn-voltar { text-decoration: none; color: #94a3b8; font-size: 14px; font-weight: 600; transition: color 0.2s; }
        .navbar .btn-voltar:hover { color: #f8fafc; }
        
        .container { max-width: 800px; margin: 50px auto; padding: 0 20px; }
        .titulo-pais { font-size: 32px; font-weight: 800; margin-bottom: 5px; color: #ffffff; display: flex; align-items: center; gap: 10px; }
        .subtitulo { font-size: 15px; color: #94a3b8; margin-bottom: 35px; }
        
        /* Lista de Pratos */
        .recipes-list { display: flex; flex-direction: column; gap: 15px; }
        .recipe-item { display: flex; justify-content: space-between; align-items: center; background-color: #1e293b; border: 1px solid #334155; padding: 20px 25px; border-radius: 10px; text-decoration: none; color: #ffffff; transition: border-color 0.2s, background-color 0.2s; }
        .recipe-item:hover { border-color: #10b981; background-color: #243249; }
        .recipe-name { font-size: 18px; font-weight: 700; color: #ffffff; }
        .btn-ver { background-color: #10b981; color: white; padding: 6px 14px; font-size: 13px; font-weight: 600; border-radius: 6px; }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar">
        <a href="{{ route('public.home') }}" class="logo">🌍 Mundo Sabor</a>
        <a href="{{ route('public.home') }}" class="btn-voltar">← Mudar de País</a>
    </nav>

    <div class="container">
        
        <!-- Título da Seleção -->
        <h1 class="titulo-pais">🏳️ {{ $pais->nome }}</h1>
        <p class="subtitulo">Explore as receitas tradicionais cadastradas para esta seleção da Copa.</p>

        <!-- Listagem de Pratos Oficiais do País -->
        <div class="recipes-list">
            @forelse($pais->receitas as $receita)
                <a href="{{ route('public.receita.show', $receita->slug) }}" class="recipe-item">
                    <span class="recipe-name">{{ $receita->nome }}</span>
                    <span class="btn-ver">Ver Receita Completa →</span>
                </a>
            @empty
                <div style="background-color: #1e293b; border: 1px dashed #334155; padding: 30px; text-align: center; color: #94a3b8; border-radius: 10px;">
                    Nenhuma receita cadastrada para o país {{ $pais->nome }} no momento.
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>
