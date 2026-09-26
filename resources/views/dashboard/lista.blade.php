<!-- BARRA DE FILTRO INTEGRADA -->
<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; border-bottom: 2px solid #f3f4f6; padding-bottom: 12px;">
    <h3 style="font-size: 18px; font-weight: bold; color: #1f2937; margin: 0;">
        🍽️ Minhas Receitas Cadastradas
    </h3>
    
    <form method="GET" action="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 8px;">
        <select name="filtrar_pais" onchange="this.form.submit()" style="padding: 6px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background-color: white; color: #4b5563; min-width: 200px;">
            <option value="">🌐 Todos os Países</option>
            @foreach($paises as $p)
                <option value="{{ $p->nome }}" {{ (isset($paisFiltro) && $paisFiltro == $p->nome) ? 'selected' : '' }}>
                    📍 {{ $p->nome }}
                </option>
            @endforeach
        </select>
        
        @if(!empty($paisFiltro))
            <a href="{{ route('dashboard') }}" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">Limpar Filtro</a>
        @endif
    </form>
</div>

<div style="display: flex; flex-direction: column; gap: 20px;">
    @forelse($receitas as $receita)
        <div style="border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; background-color: #f9fafb;">
            <h4 style="font-size: 18px; font-weight: bold; color: #111827;">
                {{ $receita->titulo }} 
                <span style="font-weight: normal; font-size: 13px; color: #6b7280; background-color: #e5e7eb; padding: 3px 8px; border-radius: 4px; margin-left: 6px;">
                    {{ $receita->pais ?? 'Origem Geral' }}
                </span>
            </h4>

            <!-- BOTÕES DE CONTROLE: EDITAR E EXCLUIR -->
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <a href="{{ route('receitas.edit', $receita->id) }}" style="font-size: 12px; background-color: #ffffff; color: #1f2937; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    ✏️ Editar Receita
                </a>

                <form method="POST" action="{{ route('receitas.destroy', $receita->id) }}" onsubmit="return confirm('Tem certeza que deseja apagar essa receita para sempre?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="font-size: 12px; background-color: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 6px; font-weight: bold; border: 1px solid #fca5a5; cursor: pointer;">
                        🗑️ Excluir
                    </button>
                </form>
            </div>
            
            <!-- Lista de Ingredientes Cadastrados -->
            <div style="margin: 14px 0; background: white; padding: 12px; border-radius: 8px; border: 1px solid #e5e7eb;">
                <strong style="font-size: 13px; color: #4b5563; display: block; margin-bottom: 6px;">📋 Ingredientes:</strong>
                <ul style="list-style-type: disc; padding-left: 20px; font-size: 14px; color: #374151; display: flex; flex-direction: column; gap: 4px;">
                    @foreach($receita->ingredientes as $ingrediente)
                        <li><strong>{{ $ingrediente->nome }}</strong> — {{ $ingrediente->quantidade }} {{ $ingrediente->unidade_medida }}</li>
                    @endforeach
                </ul>
            </div>

            <p style="font-size: 14px; color: #374151; line-height: 1.5; white-space: pre-line;"><strong>📖 Modo de Preparo:</strong><br>{{ $receita->modo_preparo }}</p>
        </div>
    @empty
        <p style="color: #6b7280; font-size: 14px; text-align: center; padding: 20px 0;">Nenhuma receita encontrada para o filtro selecionado.</p>
    @endforelse
</div>
