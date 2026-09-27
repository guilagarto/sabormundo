<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Plano Nutricional Personalizado</title>
    <style>
        body {
            background-color: #0f172a;
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .res-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            color: #1e293b;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            box-sizing: border-box;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 12px;
            margin-bottom: 30px;
        }
        .res-title {
            color: #166534;
            margin: 0;
            font-weight: bold;
            font-size: 24px;
        }
        .btn-back {
            background-color: #475569;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-back:hover {
            background-color: #334155;
        }
        .panel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .panel-box {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .box-title {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .box-value {
            font-size: 32px;
            font-weight: bold;
            color: #0f172a;
        }
        .box-value-target {
            color: #166534;
        }
        .alert-directive {
            background-color: #f0fdf4;
            border-left: 4px solid #166534;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 35px;
        }
        .alert-title {
            font-weight: bold;
            color: #166534;
            margin-bottom: 8px;
            font-size: 16px;
        }
        .recipe-title-section {
            color: #475569;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        /* Nova Grid Organizadora das Imagens dos Cards */
        .recipes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(430px, 1fr));
            gap: 25px;
        }
        .recipe-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }
        
        /* Estilização Responsiva do Bloco de Imagem da Receita */
        .recipe-image-wrapper {
            width: 100%;
            height: 180px;
            background-color: #f1f5f9;
            position: relative;
            overflow: hidden;
        }
        .recipe-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .recipe-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #15803d 0%, #166534 100%);
            color: #ffffff;
            font-size: 40px;
            font-weight: bold;
        }
        .recipe-placeholder-text {
            font-size: 14px;
            margin-top: 8px;
            font-weight: 500;
            color: #bbf7d0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .recipe-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        /* Estilização das Barras de Progresso de Macros */
        .macro-section {
            margin-bottom: 20px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }
        .macro-container {
            margin-bottom: 12px;
        }
        .macro-info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 4px;
        }
        .progress-bar {
            width: 100%;
            height: 8px;
            border-radius: 4px;
            background-color: #e2e8f0;
            display: block;
            appearance: none;
            border: none;
        }
        /* Cores customizadas para as barras */
        .progress-carb::-webkit-progress-value { background-color: #2563eb; border-radius: 4px; }
        .progress-prot::-webkit-progress-value { background-color: #dc2626; border-radius: 4px; }
        .progress-fat::-webkit-progress-value  { background-color: #d97706; border-radius: 4px; }
        .progress-carb::-moz-progress-bar { background-color: #2563eb; border-radius: 4px; }
        .progress-prot::-moz-progress-bar { background-color: #dc2626; border-radius: 4px; }
        .progress-fat::-moz-progress-bar  { background-color: #d97706; border-radius: 4px; }

        .recipe-name {
            color: #15803d;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 0;
        }
        .recipe-origin {
            font-size: 13px;
            color: #64748b;
            line-height: 1.4;
            margin-bottom: 15px;
            background-color: #f1f5f9;
            padding: 8px 12px;
            border-radius: 6px;
        }
        .energy-badge {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #166534;
        }
        .sodium-text {
            font-size: 12px;
            color: #94a3b8;
            text-align: right;
            margin-top: -5px;
            margin-bottom: 15px;
            font-weight: 500;
        }
        .btn-view-recipe {
            display: block;
            text-align: center;
            background-color: #166534;
            color: #ffffff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-view-recipe:hover {
            background-color: #15803d;
        }
        .no-recipes {
            background-color: #fffbeb;
            border: 1px solid #fef3c7;
            color: #b45309;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="res-container">
    <div class="header-actions">
        <h2 class="res-title">🥗 Seu Plano Nutricional Personalizado</h2>
        <a href="{{ route('public.blognutricional') }}" class="btn-back">⬅ Voltar</a>
    </div>
    
    <div class="panel-grid">
        <div class="panel-box">
            <div class="box-title">Gasto Calórico Diário Estimado</div>
            <div class="box-value">{{ $gastoTotal }} <small style="font-size: 16px; color: #64748b;">kcal</small></div>
        </div>
        <div class="panel-box" style="border-color: #bbf7d0; background-color: #f0fdf4;">
            <div class="box-title" style="color: #166534;">Meta Diária Sugerida</div>
            <div class="box-value box-value-target">{{ $caloriasAlvo }} <small style="font-size: 16px; color: #166534;">kcal</small></div>
        </div>
    </div>

    <div class="alert-directive">
        <div class="alert-title">📋 Diretriz Nutricional Recomendada:</div>
        <p style="margin: 0; color: #334155; line-height: 1.6;">{{ $resposta }}</p>
    </div>

    <h4 class="recipe-title-section">🍽️ Sugestões de Pratos para o Cardápio Diário:</h4>
    
    <div class="recipes-grid">
        @forelse($receitas as $receita)
            @php
                // Proporções para as barras baseado em metas padrão de refeição (80g Carb, 40g Prot, 25g Fat)
                $percentCarb = ($receita->total_carboidratos / 80) * 100;
                $percentProt = ($receita->total_proteinas / 40) * 100;
                $percentFat  = ($receita->total_gorduras / 25) * 100;
            @endphp
            <div class="recipe-card">
                <!-- Seção Superior: Imagem Dinâmica da Receita -->
                <div class="recipe-image-wrapper">
                    @if(!empty($receita->imagen) && file_exists(public_path('uploads/receitas/' . $receita->imagen)))
                        <img src="{{ asset('uploads/receitas/' . $receita->imagen) }}" alt="{{ $receita->nome }}" class="recipe-img">
                    @else
                        <div class="recipe-placeholder">
                            🍲
                            <div class="recipe-placeholder-text">Mundo Sabor</div>
                        </div>
                    @endif
                </div>

                <!-- Seção Inferior: Conteúdo e Nutrientes -->
                <div class="recipe-content">
                    <div>
                        <div class="recipe-name">{{ $receita->nome }}</div>
                        <div class="recipe-origin">📍 <strong>Origem:</strong> {{ $receita->origem }}</div>
                        
                        <div class="energy-badge">
                            <span>🔥 Energia Total:</span>
                            <span>{{ round($receita->total_calorias, 0) }} kcal</span>
                        </div>

                        <div class="macro-section">
                            <div class="macro-container">
                                <div class="macro-info">
                                    <span style="color: #2563eb;">🍞 Carboidratos</span>
                                    <span>{{ round($receita->total_carboidratos, 1) }}g</span>
                                </div>
                                <progress class="progress-bar progress-carb" value="{{ $percentCarb }}" max="100"></progress>
                            </div>

                            <div class="macro-container">
                                <div class="macro-info">
                                    <span style="color: #dc2626;">🥩 Proteínas</span>
                                    <span>{{ round($receita->total_proteinas, 1) }}g</span>
                                </div>
                                <progress class="progress-bar progress-prot" value="{{ $percentProt }}" max="100"></progress>
                            </div>

                            <div class="macro-container">
                                <div class="macro-info">
                                    <span style="color: #d97706;">🧈 Gorduras</span>
                                    <span>{{ round($receita->total_gorduras, 1) }}g</span>
                                </div>
                                <progress class="progress-bar progress-fat" value="{{ $percentFat }}" max="100"></progress>
                            </div>
                        </div>

                        <div class="sodium-text">🧂 Sódio: {{ round($receita->total_sodio, 0) }} mg</div>
                    </div>
                    
                    <a href="{{ route('public.receita.show', $receita->slug) }}" class="btn-view-recipe" target="_blank">📖 Ver Receita Completa</a>
                </div>
            </div>
        @empty
            <div class="no-recipes" style="grid-column: 1 / -1;">
                💡 Nenhuma receita recomendada atendeu aos critérios na base de dados.
            </div>
        @endforelse
    </div>
</div>

</body>
</html>
