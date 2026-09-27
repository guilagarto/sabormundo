@extends('layouts.public')

@section('title', 'Culinária das Seleções Mundiais')

@section('styles')
    <style>
        .home-header { text-align: center; margin: 40px 0 50px 0; }
        .home-header h1 { font-size: 38px; font-weight: 800; margin-bottom: 12px; color: #ffffff; letter-spacing: -0.5px; }
        .home-header p { font-size: 16px; color: #94a3b8; max-width: 600px; margin: 0 auto; line-height: 1.6; }
        
        /* Grid das Seleções da Copa */
        .countries-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; }
        .country-card { background-color: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 25px 15px; text-align: center; text-decoration: none; color: #ffffff; transition: transform 0.2s, border-color 0.2s, background-color 0.2s; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .country-card:hover { transform: translateY(-4px); border-color: #38bdf8; background-color: #243249; }
        .country-flag { font-size: 42px; margin-bottom: 12px; display: block; line-height: 1; }
        .country-name { font-size: 16px; font-weight: 700; color: #f8fafc; }
    </style>
@endsection

@section('content')
    <!-- Cabeçalho de Introdução -->
    <div class="home-header">
        <h1>Culinária das Seleções Mundiais</h1>
        <p>Escolha um dos países participantes da Copa do Mundo para explorar as receitas tradicionais e conferir as tabelas nutricionais completas (TACO).</p>
    </div>

    <!-- Grid Dinâmico dos 48 Países -->
    <div class="countries-grid">
        @forelse($paises as $pais)
            <a href="{{ route('public.pais.receitas', $pais->id) }}" class="country-card">
                <span class="country-flag">{{ $pais->bandeira ?? '🏳️' }}</span>
                <span class="country-name">{{ $pais->nome }}</span>
            </a>
        @empty
            <div style="grid-column: 1/-1; background-color: #1e293b; border: 1px dashed #334155; padding: 40px; text-align: center; color: #94a3b8; border-radius: 12px;">
                Nenhum país localizado no banco sabor_db.
            </div>
        @endforelse
    </div>
@endsection
