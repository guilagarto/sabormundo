@extends('layouts.admin')

@section('title', 'Gerenciar Países')

@section('styles')
    <style>
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header-actions h1 { margin: 0; font-size: 24px; color: #0f172a; }
        .header-actions p { margin: 5px 0 0 0; font-size: 14px; color: #64748b; }
        .alert-success { background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 25px; font-size: 14px; font-weight: 500; }
        .table-responsive { width: 100%; overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background-color: #f8fafc; padding: 14px; font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0; }
        td { padding: 14px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        tr:hover { background-color: #f8fafc; }
        .badge-flag { font-size: 20px; }
        .text-desc { color: #64748b; font-size: 13px; line-height: 1.4; }
        .btn-edit { text-decoration: none; background-color: #3b82f6; color: white; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 4px; display: inline-block; }
        .pagination-container { margin-top: 25px; display: flex; justify-content: center; }
    </style>
@endsection

@section('content')
    <div class="header-actions">
        <div>
            <h1>Curiosidades das Seleções</h1>
            <p>Gerencie as descrições culturais e fatos gastronômicos das 48 nações da Copa 2026.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">🎉 {{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Bandeira</th>
                    <th style="width: 25%;">País</th>
                    <th style="width: 50%;">Curiosidade / Descrição Cultural</th>
                    <th style="width: 15%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paises as $pais)
                    <tr>
                        <td><span class="badge-flag">{{ $pais->bandeira ?? '🏳️' }}</span></td>
                        <td><strong>{{ $pais->nome }}</strong></td>
                        <td class="text-desc">
                            {{ $pais->descricao ? Str::limit($pais->descricao, 110, '...') : 'Nenhuma curiosidade cadastrada ainda.' }}
                        </td>
                        <td>
                            <a href="{{ route('adm.paises.edit', $pais->id) }}" class="btn-edit">✏️ Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94a3b8; padding: 30px;">Nenhum país localizado no banco sabor_db.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $paises->links() }}
    </div>
@endsection
