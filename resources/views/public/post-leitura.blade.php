@extends('layouts.public')

@section('content')
<style>
    .leitura-body {
        background-color: #0f172a;
        margin: 0;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f8fafc;
    }
    .leitura-container {
        max-width: 1100px;
        margin: 0 auto;
        box-sizing: border-box;
    }
    .btn-voltar-guia {
        display: inline-block;
        color: #22c55e;
        text-decoration: none;
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 25px;
        transition: color 0.2s;
    }
    .btn-voltar-guia:hover {
        color: #15803d;
    }
    .leitura-grid {
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 40px;
    }
    @media (max-width: 992px) {
        .leitura-grid { grid-template-columns: 1fr; }
    }
    .artigo-completo {
        background-color: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 35px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .artigo-banner {
        width: 100%;
        height: 250px;
        background: linear-gradient(135deg, #166534 0%, #1e293b 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        margin-bottom: 25px;
    }
    .artigo-tag {
        display: inline-block;
        background-color: rgba(34, 197, 94, 0.15);
        color: #22c55e;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    .artigo-title {
        font-size: 32px;
        font-weight: bold;
        color: #ffffff;
        margin: 0 0 15px 0;
        line-height: 1.3;
    }
    .artigo-meta {
        font-size: 13px;
        color: #64748b;
        border-bottom: 1px solid #334155;
        padding-bottom: 15px;
        margin-bottom: 25px;
        display: flex;
        gap: 20px;
    }
    .artigo-texto {
        font-size: 16px;
        color: #cbd5e1;
        line-height: 1.8;
    }
    .artigo-texto p {
        margin-bottom: 20px;
    }
    
    /* Sidebar Lateral */
    .sidebar-leitura {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    .widget-leitura {
        background-color: #1e293b;
        border: 1px solid #334155;
        border-radius: 10px;
        padding: 20px;
    }
    .widget-title {
        font-size: 15px;
        font-weight: bold;
        color: #ffffff;
        border-bottom: 2px solid #334155;
        padding-bottom: 8px;
        margin-top: 0;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .link-recente {
        display: block;
        color: #cbd5e1;
        text-decoration: none;
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(51, 65, 85, 0.5);
    }
    .link-recente:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .link-recente:hover {
        color: #22c55e;
    }
    .btn-side {
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
    .btn-side:hover {
        background-color: #15803d;
    }
</style>

<div class="leitura-body">
    <div class="leitura-container">
        
        <a href="{{ route('public.guianutricional') }}" class="btn-voltar-guia">⬅ Voltar para o Guia Nutricional</a>

        <div class="leitura-grid">
            
            <!-- Coluna da Esquerda: Conteúdo Completo do Artigo -->
            <article class="artigo-completo">
                <div class="artigo-banner">
                    @if($post->categoria == 'Nutrição Prática') 🥩 @elseif($post->categoria == 'Dicas de Saúde') 🛡️ @else 🌍 @endif
                </div>
                
                <span class="artigo-tag">{{ $post->categoria }}</span>
                <h1 class="artigo-title">{{ $post->titulo }}</h1>
                
                <div class="artigo-meta">
                    <span>📅 Publicado em: {{ $post->created_at->format('d/m/Y') }}</span>
                    <span>👁️ {{ $post->visualizacoes }} Visualizações</span>
                </div>

                <div class="artigo-texto">
                    <!-- nl2br garante as quebras de parágrafo vindo do banco de dados -->
                    {!! nl2br(e($post->conteudo)) !!}
                </div>
            </article>

            <!-- Coluna da Direita: Sidebar Lateral -->
            <div class="sidebar-leitura">
                
                <!-- Outros Artigos Recentes -->
                <div class="widget-leitura">
                    <h4 class="widget-title">🔥 Leia Também</h4>
                    @forelse($postsRecentes as $recente)
                        <a href="{{ route('public.guia.show', $recente->slug) }}" class="link-recente">
                            <strong>[{{ $recente->categoria }}]</strong> {{ Str::limit($recente->titulo, 55) }}
                        </a>
                    @empty
                        <p class="text-muted" style="font-size: 13px; margin: 0;">Nenhuma outra recomendação disponível.</p>
                    @endforelse
                </div>

                <!-- Atalho Rápido para Avaliação -->
                <div class="widget-leitura" style="border-color: #22c55e;">
                    <h4 class="widget-title" style="color: #22c55e;">🎯 Avaliação Física</h4>
                    <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin-bottom: 15px;">Descubra sua meta de calorias diárias e monte um cardápio livre de alergias de forma totalmente integrada!</p>
                    <a href="{{ route('public.blognutricional') }}" class="btn-side">Fazer Diagnóstico</a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
