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
        
        .container { max-width: 800px; margin: 50px auto; padding: 0 20px; }
        .badge-pais { display: inline-block; background-color: #0284c7; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; }
        h1 { font-size: 36px; font-weight: 800; margin: 0 0 15px 0; color: #ffffff; }
        
        .layout-grid { display: grid; grid-template-columns: 1fr; gap: 30px; margin-top: 30px; }
        @media(min-width: 768px) { .layout-grid { grid-template-columns: 1.6fr 1fr; } }
        
        .card-info { background-color: #1e293b; border: 1px solid #334155; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .card-title { font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 15px; border-bottom: 1px solid #334155; padding-bottom: 10px; color: #38bdf8; }
        
        p { line-height: 1.6; color: #cbd5e1; font-size: 15px; margin: 0; }
        
        /* Lista de Ingredientes Usados */
        .ing-list { margin: 0; padding-left: 20px; color: #cbd5e1; font-size: 14px; }
        .ing-list li { margin-bottom: 8px; }

        /* Tabela Nutricional Estilo Profissional */
        .nutri-table { width: 100%; background-color: #0f172a; border-radius: 8px; padding: 15px; box-sizing: border-box; border: 1px solid #451a03; }
        .nutri-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #334155; font-size: 14px; }
        .nutri-row:last-child { border-bottom: none; }
        .nutri-row.principal { font-weight: 800; font-size: 16px; border-bottom: 2px solid #334155; color: #fbbf24; }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar">
        <a href="{{ route('public.home') }}" class="logo">🌍 Mundo Sabor</a>
    </nav>

    <div class="container">
        
        <span class="badge-pais">🏳️ {{ $receita->pais->nome ?? 'Mundial' }}</span>
        <h1>{{ $receita->nome }}</h1>

        <div class="layout-grid">
            
            <!-- Coluna Esquerda: Preparo e Ingredientes -->
            <div class="space-y-4" style="display: flex; flex-direction: column; gap: 20px;">
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
                                {{ number_format($ingrediente->pivot->quantidade, 2, ',', '.') }} {{ $ingrediente->pivot->unidade_medida }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Coluna Direita: Painel de Macronutrientes -->
            <div>
                <div class="card-info" style="border-color: #ca8a04;">
                    <h2 class="card-title" style="color: #fbbf24;">📊 Ficha Nutricional Total</h2>
                    <p style="font-size: 12px; color: #94a3b8; margin-bottom: 15px;">Valores consolidados de acordo com o peso proporcional de cada ingrediente (TACO/TBCA).</p>
                    
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
                        <div class="nutri-row" style="color: #94a3b8; font-size: 12px;">
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
