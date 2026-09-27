@extends('layouts.admin')

@section('title', 'Editar Curiosidades do País')

@section('styles')
    <style>
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #1e293b; }
        textarea { width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; transition: border-color 0.2s; background-color: #fff; line-height: 1.5; }
        textarea:focus { border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .footer-form { display: flex; justify-content: flex-end; padding-top: 20px; border-top: 1px solid #f1f5f9; margin-top: 25px; }
        .btn-salvar { background-color: #0f172a; color: white; border: none; padding: 12px 24px; font-size: 15px; font-weight: 600; border-radius: 8px; cursor: pointer; }
        .btn-salvar:hover { background-color: #1e293b; }
        .header-context { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 25px; }
        .header-context h2 { margin: 0; font-size: 22px; color: #0f172a; display: flex; align-items: center; gap: 10px; }
        .header-context p { margin: 5px 0 0 0; font-size: 14px; color: #64748b; }
        .btn-voltar { text-decoration: none; padding: 8px 16px; font-size: 14px; font-weight: 500; color: #475569; background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; }
    </style>
@endsection

@section('content')
    <div class="header-context">
        <div>
            <h2>{{ $pais->bandeira ?? '🏳️' }} Editar Informações: {{ $pais->nome }}</h2>
            <p>Escreva curiosidades gastronômicas ou fatos interessantes sobre a seleção para os usuários lerem.</p>
        </div>
        <a href="{{ route('adm.paises.index') }}" class="btn-voltar">Cancelar</a>
    </div>

    <form action="{{ route('adm.paises.update', $pais->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="descricao">Fatos Históricos, Culturais e Curiosidades Culinárias</label>
            <textarea name="descricao" id="descricao" rows="8" placeholder="Ex: O Brasil é o maior produtor de café do mundo e sua culinária traz fortes influências indígenas, africanas e europeias, tendo a feijoada como prato nacional absoluto...">{{ old('descricao', $pais->descricao) }}</textarea>
        </div>

        <div class="footer-form">
            <button type="submit" class="btn-salvar">Atualizar Curiosidades</button>
        </div>
    </form>
@endsection
