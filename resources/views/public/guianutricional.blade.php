@extends('layouts.public')

@section('content')
<style>
    .guia-body {
        background-color: #0f172a;
        margin: 0;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f8fafc;
    }
    .guia-container {
        max-width: 1100px;
        margin: 0 auto;
        box-sizing: border-box;
    }

    /* Categorias Filtros Rápidos */
    .cat-nav {
        display: flex;
        gap: 10px;
        margin-bottom: 35px;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    .cat-btn {
        background-color: #1e293b;
        color: #94a3b8;
        padding: 8px 18px;
        border: 1px solid #334155;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .cat-btn.active, .cat-btn:hover {
        background-color: #22c55e;
        color: #ffffff;
        border-color: #22c55e;
    }

    /* Layout Principal: Grid de Conteúdo + Sidebar */
    .guia-main-grid {
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 30px;
    }
    @media (max-width: 992px) {
        .guia-main-grid { grid-template-columns: 1fr; }
    }

    /* Post em Destaque (Banner Superior Grande) */
    .featured-post {
        background-color: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 35px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .featured-img-box {
        width: 100%;
        height: 320px;
        background: linear-gradient(135deg, #15803d 0%, #0f172a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
    }
    .featured-content {
        padding: 25px;
    }
    .post-tag {
        display: inline-block;
        background-color: rgba(34, 197, 94, 0.15);
        color: #22c55e;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .featured-title {
        font-size: 26px;
        font-weight: bold;
        color: #ffffff;
        margin: 0 0 12px 0;
        line-height: 1.3;
    }
    .featured-excerpt {
        font-size: 15px;
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .post-meta {
        font-size: 12px;
        color: #64748b;
        display: flex;
        gap: 15px;
    }

    /* Grid de Notícias Secundárias */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    .news-card {
        background-color: #1e293b;
        border: 1px solid #334155;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .news-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }
    .card-img-box {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #166534 0%, #1e293b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
    }
    .card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #ffffff;
        margin: 0 0 10px 0;
        line-height: 1.4;
    }
    .card-excerpt {
        font-size: 13px;
        color: #94a3b8;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    .btn-read {
        display: inline-block;
        color: #22c55e;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        margin-top: 10px;
    }
    .btn-read:hover {
        text-decoration: underline;
    }

    /* Barra Lateral (Sidebar) */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    .side-widget {
        background-color: #1e293b;
        border: 1px solid #334155;
        border-radius: 10px;
        padding: 20px;
    }
    .widget-title {
        font-size: 16px;
        font-weight: bold;
        color: #ffffff;
        border-bottom: 2px solid #334155;
        padding-bottom: 8px;
        margin-top: 0;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-side-action {
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
    .btn-side-action:hover {
        background-color: #15803d;
    }
    .side-input {
        width: 100%;
        padding: 10px;
        background-color: #0f172a;
        border: 1px solid #334155;
        border-radius: 6px;
        color: #ffffff;
        margin-bottom: 10px;
        box-sizing: border-box;
    }
    .side-input:focus {
        border-color: #22c55e;
        outline: none;
    }
</style>

<div class="guia-body">
    <div class="guia-container">
        
        <!-- Filtro de Categorias -->
               <!-- Filtro de Categorias Dinâmico Integrado com o Banco -->
        <div class="cat-nav">
            <a href="{{ route('public.guianutricional') }}" 
               class="cat-btn {{ empty($categoriaSelecionada) ? 'active' : '' }}">📚 Todos os Posts</a>
            
            <a href="{{ route('public.guianutricional', ['categoria' => 'Curiosidades Globais']) }}" 
               class="cat-btn {{ $categoriaSelecionada === 'Curiosidades Globais' ? 'active' : '' }}">🌍 Curiosidades Globais</a>
            
            <a href="{{ route('public.guia.show', ['slug' => 'proteinas-globais-hipertrofia']) }}" 
               class="cat-btn {{ $categoriaSelecionada === 'Nutrição Prática' ? 'active' : '' }}">🥩 Nutrição Prática</a>
            
            <a href="{{ route('public.guia.show', ['slug' => 'alergias-ocultas-molhos']) }}" 
               class="cat-btn {{ $categoriaSelecionada === 'Dicas de Saúde' ? 'active' : '' }}">🥗 Dicas de Saúde</a>
        </div>


        <div class="guia-main-grid">
            
            <!-- Coluna Esquerda: Notícias Dinâmicas -->
            <div>
                <!-- 1. Post em Destaque Principal -->
                @if($postDestaque)
                    <article class="featured-post">
                        <div class="featured-img-box">🍋</div>
                        <div class="featured-content">
                            <span class="post-tag">{{ $postDestaque->categoria }}</span>
                            <h2 class="featured-title">{{ $postDestaque->titulo }}</h2>
                            <p class="featured-excerpt">{{ Str::limit($postDestaque->conteudo, 220) }}</p>
                            <div class="post-meta">
                                <span>📅 {{ $postDestaque->created_at->format('d/m/Y') }}</span>
                                <span>👁️ {{ $postDestaque->visualizacoes }} Visualizações</span>
                            </div>
                            <a href="{{ route('public.guia.show', $postDestaque->slug) }}" class="btn-read">Ler Artigo Completo ➔</a>
                        </div>
                    </article>
                @endif

                <!-- 2. Grid de Artigos Secundários -->
                <div class="news-grid">
                    @forelse($outrosPosts as $post)
                        <div class="news-card">
                            <div class="card-img-box">
                                @if($post->categoria == 'Nutrição Prática') 🥩 @else 🛡️ @endif
                            </div>
                            <div class="card-content">
                                <div>
                                    <span class="post-tag">{{ $post->categoria }}</span>
                                    <h3 class="card-title">{{ $post->titulo }}</h3>
                                    <p class="card-excerpt">{{ Str::limit($post->conteudo, 130) }}</p>
                                </div>
                                <div>
                                    <div class="post-meta" style="margin-bottom: 10px;">
                                        <span>📅 {{ $post->created_at->format('m/Y') }}</span>
                                    </div>
                                    <a href="{{ route('public.guia.show', $post->slug) }}" class="btn-read">Ler Mais ➔</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted" style="grid-column: 1/-1;">Nenhum artigo secundário cadastrado no momento.</p>
                    @endforelse
                </div>
            </div>

            <!-- Coluna Direita: Barra Lateral (Sidebar) -->
            <div class="sidebar">
                
                <div class="side-widget" style="border: 1px solid #22c55e; background-color: rgba(34, 197, 94, 0.02);">
                    <h4 class="widget-title" style="color: #22c55e;">🎯 Meta Calórica</h4>
                    <p style="font-size: 13px; color: #cbd5e1; line-height: 1.5; margin-bottom: 15px;">Descubra seu gasto energético diário exato baseado no seu nível de treino e receba sugestões sem os alimentos que você não gosta!</p>
                    <a href="{{ route('public.blognutricional') }}" class="btn-side-action">Fazer Evaluation Grátis</a>
                </div>

                <div class="side-widget">
                    <h4 class="widget-title">📩 Newsletter</h4>
                    <p style="font-size: 13px; color: #cbd5e1; line-height: 1.5; margin-bottom: 15px;">Receba novos artigos de saúde e as últimas atualizações de receitas da tabela TACO direto no e-mail.</p>
                    
                    <form action="{{ route('public.newsletter.salvar') }}" method="POST">
                        @csrf
                        <input type="email" name="email" class="side-input" placeholder="Seu melhor e-mail..." required>
                        <button type="submit" class="btn-side-action" style="width: 100%; background-color: #475569;">Cadastrar</button>
                    </form>
                </div>

            </div>
@endsection
