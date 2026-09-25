<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaborMundo | Receitas Internacionais</title>
    <style>
        /* CSS focado em usabilidade e leitura confortável no celular */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f8fafc; color: #1e293b; padding-bottom: 40px; }
        
        /* Header Fixo no Topo */
        header { background: #ffffff; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 20px; font-weight: 800; color: #ea580c; text-decoration: none; }
        .btn-painel { background-color: #0f172a; color: white; text-decoration: none; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: bold; }

        /* Banner de Introdução */
        .hero { background: linear-gradient(135deg, #ffedd5 0%, #ffffff 100%); padding: 35px 20px; text-align: center; border-bottom: 1px solid #fed7aa; }
        .hero h1 { font-size: 24px; font-weight: 800; color: #7c2d12; margin-bottom: 6px; }
        .hero p { font-size: 14px; color: #475569; }

        /* Feed de Receitas */
        .feed-container { max-width: 550px; margin: 24px auto; padding: 0 16px; display: flex; flex-direction: column; gap: 24px; }
        
        /* Card de Receita Expandido */
        .card-receita { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .recipe-body { padding: 20px; }
        
        .recipe-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 10px; }
        .recipe-title { font-size: 19px; font-weight: 800; color: #0f172a; line-height: 1.3; }
        .badge-pais { background: #ffedd5; color: #ea580c; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; white-space: nowrap; }
        
        /* Box de Ingredientes Individuais */
        .ingredients-box { background: #f8fafc; border-radius: 12px; padding: 14px; margin: 16px 0; border: 1px dashed #cbd5e1; }
        .ingredients-box h3 { font-size: 12px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 8px; letter-spacing: 0.5px; }
        .ingredients-list { list-style: none; display: flex; flex-direction: column; gap: 6px; }
        .ingredients-list li { font-size: 14px; color: #334155; position: relative; padding-left: 20px; }
        .ingredients-list li::before { content: "•"; position: absolute; left: 4px; color: #ea580c; font-weight: bold; font-size: 16px; top: -1px; }

        .preparo-title { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block; }
        .preparo-text { font-size: 14px; color: #334155; line-height: 1.6; white-space: pre-line; }
    </style>
</head>
<body>

    <!-- Cabeçalho de Navegação -->
    <header>
        <a href="/" class="logo">🌍 SaborMundo</a>
        <a href="{{ route('dashboard') }}" class="btn-painel">Acessar Painel</a>
    </header>

    <!-- Banner Central -->
    <section class="hero">
        <h1>Explore Sabores do Mundo</h1>
        <p>Receitas internacionais autênticas com controle de ingredientes por porção.</p>
    </section>

    <!-- Listagem Dinâmica Pública -->
    <main class="feed-container">
        @forelse($receitas as $receita)
            <article class="card-receita">
                <div class="recipe-body">
                    <div class="recipe-header">
                        <h2 class="recipe-title">{{ $receita->titulo }}</h2>
                        <span class="badge-pais">📍 {{ $receita->pais ?? 'Internacional' }}</span>
                    </div>

                    <!-- Bloco de Renderização de Ingredientes Cadastrados via Loop -->
                    <div class="ingredients-box">
                        <h3>📋 Ingredientes Necessários</h3>
                        <ul class="ingredients-list">
                            @foreach($receita->ingredientes as $ingrediente)
                                <li><strong>{{ $ingrediente->nome }}</strong> — {{ $ingrediente->quantidade }} {{ $ingrediente->unidade_medida }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Texto Completo do Modo de Preparo -->
                    <div style="margin-top: 14px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                        <strong class="preparo-title">📖 Modo de Preparo:</strong>
                        <p class="preparo-text">{{ $receita->modo_preparo }}</p>
                    </div>
                </div>
            </article>
            @empty
        <div style="text-align: center; padding: 40px 20px; color: #64748b;">
            <p style="font-size: 15px;">Nenhuma receita culinária foi publicada no feed ainda.</p>
        </div>
    @endforelse

    </main>

</body>
</html>
