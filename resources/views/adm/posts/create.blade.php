@extends('layouts.admin')

@section('content')
<style>
    .post-adm-card {
        background-color: #1e293b;
        color: #f8fafc;
        border-radius: 10px;
        padding: 30px;
        margin: 20px auto;
        max-width: 900px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .post-adm-title {
        color: #22c55e;
        border-bottom: 2px solid #334155;
        padding-bottom: 12px;
        margin-bottom: 25px;
        font-weight: bold;
        font-size: 22px;
        margin-top: 0;
    }
    .post-adm-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #cbd5e1;
        font-size: 14px;
    }
    .post-adm-input, .post-adm-select, .post-adm-textarea {
        width: 100%;
        padding: 12px;
        background-color: #0f172a;
        border: 1px solid #334155;
        border-radius: 6px;
        color: #ffffff;
        margin-bottom: 20px;
        box-sizing: border-box;
        font-family: inherit;
        font-size: 14px;
    }
    .post-adm-input:focus, .post-adm-select:focus, .post-adm-textarea:focus {
        border-color: #22c55e;
        outline: none;
    }
    .post-adm-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    .btn-post-submit {
        background-color: #166534;
        color: #ffffff;
        padding: 15px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-post-submit:hover {
        background-color: #15803d;
    }
    .btn-post-back {
        display: inline-block;
        color: #94a3b8;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .btn-post-back:hover {
        color: #ffffff;
    }
</style>

<div class="post-adm-card">
    <a href="{{ route('public.guianutricional') }}" class="btn-post-back">⬅ Voltar para o Guia</a>
    <h2 class="post-adm-title">✍️ Escrever Nova Notícia (Guia Nutricional)</h2>

    @if($errors->any())
        <div style="background-color: #b91c1c; color: #ffffff; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adm.posts.store') }}" method="POST">
        @csrf

        <label class="post-adm-label">Título do Artigo</label>
        <input type="text" name="titulo" class="post-adm-input" placeholder="Ex: Os Benefícios Ocultos do Inhame..." required>

        <div class="post-adm-row">
            <div>
                <label class="post-adm-label">Categoria</label>
                <select name="categoria" class="post-adm-select" required>
                    <option value="Curiosidades Globais">🌍 Curiosidades Globais</option>
                    <option value="Nutrição Prática">🥩 Nutrição Prática</option>
                    <option value="Dicas de Saúde">🥗 Dicas de Saúde</option>
                </select>
            </div>
            <div>
                <label class="post-adm-label">URL Amigável (Slug - Deixe vazio para automático)</label>
                <input type="text" name="slug" class="post-adm-input" placeholder="Ex: os-beneficios-do-inhame">
            </div>
        </div>

        <label class="post-adm-label">Conteúdo Completo da Notícia</label>
        <textarea name="conteudo" rows="10" class="post-adm-textarea" placeholder="Escreva o texto completo do seu artigo aqui... Use quebras de parágrafo normais para formatação." required></textarea>

        <button type="submit" class="btn-post-submit">🚀 Publicar Notícia no Portal</button>
    </form>
</div>
@endsection
