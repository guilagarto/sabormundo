<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $receita->nome }} - Detalhes</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; padding: 0; }
        .navbar { background-color: #1e293b; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-size: 22px; font-weight: 800; color: #38bdf8; text-decoration: none; letter-spacing: 0.5px; }
        
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; box-sizing: border-box; }
        
        /* BANNER DO TOPO EM DESTAQUE */
        .banner-wrapper { width: 100%; height: 350px; border-radius: 12px; overflow: hidden; border: 1px solid #334155; box-shadow: 0 6px 15px rgba(0,0,0,0.4); margin-bottom: 30px; background-color: #1e293b; }
        .recipe-banner { width: 100%; height: 100%; object-fit: cover; display: block; }
        
        /* Cabeçalho do Prato */
        .recipe-header { border-bottom: 1px solid #334155; padding-bottom: 20px; margin-bottom: 30px; }
        .badge-pais { display: inline-block; background-color: #0284c7; color: white; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 12px; }
        h1 { font-size: 42px; font-weight: 800; margin: 0 0 8px 0; color: #ffffff; letter-spacing: -0.5px; }
        .origem-text { font-size: 15px; color: #38bdf8; font-weight: 600; display: flex; align-items: center; gap: 6px; }
        
        /* Grid Principal de Conteúdo */
        .layout-grid { display: grid; grid-template-columns: 1fr; gap: 30px; }
        @media(min-width: 768px) { .layout-grid { grid-template-columns: 1.5fr 1fr; } }
        
        /* Cards Informativos */
        .card-info { background-color: #1e293b; border: 1px solid #334155; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 25px; }
        .card-title { font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 15px; border-bottom: 1px solid #334155; padding-bottom: 10px; color: #38bdf8; display: flex; align-items: center; gap: 8px; }
        
        p { line-height: 1.7; color: #cbd5e1; font-size: 16px; margin: 0; }
        .ing-list { margin: 0; padding-left: 20px; color: #cbd5e1; font-size: 15px; }
        .ing-list li { margin-bottom: 10px; }

        /* Tabela Nutricional Estilo Profissional */
        .nutri-box { border: 2px solid #ca8a04; border-radius: 12px; background-color: #1e293b; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); height: fit-content; position: sticky; top: 20px; }
        .nutri-table { width: 100%; background-color: #0f172a; border-radius: 8px; padding: 18px; box-sizing: border-box; border: 1px solid #451a03; margin-top: 15px; }
        .nutri-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #334155; font-size: 15px; }
        .nutri-row:last-child { border-bottom: none; }
        .nutri-row.principal { font-weight: 800; font-size: 18px; border-bottom: 2px solid #334155; color: #fbbf24; padding-bottom: 12px; }
        
        /* Player do YouTube Responsivo */
        .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px; border: 1px solid #334155; background-color: #000; }
        .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('public.home') }}" class="logo">🌍 Mundo Sabor</a>
    </nav>

    <div class="container">
        
        <!-- BANNER DE DESTAQUE NO TOPO ABSOLUTO -->
        <div class="banner-wrapper">
            <!-- Busca a imagem da feijoada na pasta publica de uploads -->
            <img src="{{ asset('uploads/receitas/feijoada.jpg') }}" class="recipe-banner" alt="{{ $receita->nome }}">
        </div>

        <!-- Cabeçalho Principal -->
        <div class="recipe-header">
            <span class="badge-pais">{{ $receita->pais->bandeira ?? '🏳️' }} {{ $receita->pais->nome ?? 'Seleção' }}</span>
            <h1>{{ $receita->nome }}</h1>
            @if($receita->origem)
                <div class="origem-text">📍 Região de Origem: {{ $receita->origem }}</div>
            @endif
        </div>

        <!-- Grid de Conteúdo -->
        <div class="layout-grid">
            
            <!-- Coluna da Esquerda -->
            <div>
                <div class="card-info">
                    <h2 class="card-title">📝 Modo de Preparo</h2>
                    <p>{!! nl2br(e($receita->descricao)) !!}</p>
                </div>

                <div class="card-info">
                    <h2 class="card-title">🛒 Ingredientes Utilizados</h2>
                    <ul class="ing-list">
                        @foreach($receita->ingredients as $ingrediente)
                            <li>
                                <strong>{{ $ingrediente->nome }}</strong>: 
                                {{ number_format($ingrediente->pivot->quantidade, 0, ',', '.') }} {{ $ingrediente->pivot->unidade_medida }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($receita->video_url)
                    <div class="card-info">
                        <h2 class="card-title">📺 Passo a Passo em Vídeo</h2>
                        <div class="video-wrapper">
                            <iframe src="{{ $receita->video_url }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Coluna da Direita (Tabela Nutricional) -->
            <div>
                <div class="nutri-box">
                    <h2 class="card-title" style="color: #fbbf24; border-bottom-color: #ca8a04;">📊 Valores Nutricionais Totais</h2>
                    <p style="font-size: 13px; color: #94a3b8;">Soma total dos macronutrientes da receita calculada de acordo com a pesagem informada (Tabela TACO).</p>
                    
                    <div class="nutri-table">
                        <div class="nutri-row principal">
                            <span>Valor Energético</span>
                            <span>{{ number_format($tabelaNutricional['calorias'], 1, ',', '.') }} kcal</span>
                        </div>
                        <div class="nutri-row">
                            <span>Carboidratos</span>
                            <span>{{ number_format($tabelaNutricional['carboidratos'], 1, ',', '.') }} g</span>
                        </div>
                        <div class="nutri-row">
                            <span>Proteínas</span>
                            <span>{{ number_format($tabelaNutricional['proteinas'], 1, ',', '.') }} g</span>
                        </div>
                        <div class="nutri-row">
                            <span>Gorduras Totais</span>
                            <span>{{ number_format($tabelaNutricional['gorduras'], 1, ',', '.') }} g</span>
                        </div>
                        <div class="nutri-row" style="color: #94a3b8; font-size: 13px;">
                            <span>Sódio</span>
                            <span>{{ number_format($tabelaNutricional['sodio'], 1, ',', '.') }} mg</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
