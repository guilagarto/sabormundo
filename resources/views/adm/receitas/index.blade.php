<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel ADM - Listagem de Receitas</title>
    <style>
        /* Estilos nativos de alta performance */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; color: #334155; margin: 0; padding: 0; }
        .container { max-width: 1000px; margin: 40px auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 25px; }
        .header h1 { margin: 0; font-size: 24px; color: #0f172a; }
        .header p { margin: 5px 0 0 0; font-size: 14px; color: #64748b; }
        .btn-criar { text-decoration: none; padding: 10px 20px; font-size: 14px; font-weight: 600; color: #ffffff; background-color: #0f172a; border-radius: 8px; transition: background 0.2s; }
        .btn-criar:hover { background-color: #1e293b; }
        
        /* Barra de Filtros */
        .filtro-wrapper { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 10px; margin-bottom: 25px; }
        .filtro-form { display: flex; gap: 15px; align-items: flex-end; }
        .filtro-group { display: flex; flex-direction: column; flex: 1; }
        .filtro-group label { font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; }
        select { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background-color: #fff; }
        .btn-filtrar { background-color: #10b981; color: white; border: none; padding: 9px 20px; font-size: 14px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background 0.2s; }
        .btn-filtrar:hover { background-color: #059669; }
        .btn-limpar { text-decoration: none; background-color: #e2e8f0; color: #475569; padding: 9px 20px; font-size: 14px; font-weight: 600; border-radius: 6px; text-align: center; transition: background 0.2s; }
        .btn-limpar:hover { background-color: #cbd5e1; }

        /* Alertas de Sucesso */
        .alert-success { background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 25px; font-size: 14px; font-weight: 500; }

        /* Tabela Otimizada */
        .table-responsive { width: 100%; overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background-color: #f8fafc; padding: 14px; font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0; }
        td { padding: 14px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        tr:hover { background-color: #f8fafc; }
        
        .badge-pais { display: inline-block; background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        
        /* Grid Nutricional Compacto */
        .nutri-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 4px; font-size: 12px; color: #64748b; background-color: #fefce8; padding: 8px; border: 1px solid #fef08a; border-radius: 6px; max-width: 220px; }
        .nutri-grid strong { color: #854d0e; }

        /* Ações */
        .actions { display: flex; gap: 10px; }
        .btn-edit { text-decoration: none; background-color: #3b82f6; color: white; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 4px; transition: background 0.2s; }
        .btn-edit:hover { background-color: #2563eb; }
        .btn-delete { background-color: #ef4444; color: white; border: none; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 4px; cursor: pointer; transition: background 0.2s; }
        .btn-delete:hover { background-color: #dc2626; }

        /* Paginação */
        .pagination-container { margin-top: 25px; display: flex; justify-content: center; }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Cabeçalho -->
        <div class="header">
            <div>
                <h1>Gerenciamento de Receitas</h1>
                <p>Monitore, filtre e gerencie os pratos tradicionais e seus impactos nutricionais.</p>
            </div>
            <a href="{{ route('adm.receitas.create') }}" class="btn-criar">+ Nova Receita</a>
        </div>

        <!-- Alerta de Operação bem-sucedida -->
        @if(session('success'))
            <div class="alert-success">
                🎉 {{ session('success') }}
            </div>
        @endif

        <!-- Bloco de Filtros por País -->
        <div class="filtro-wrapper">
            <form action="{{ route('adm.receitas.index') }}" method="GET" class="filtro-form">
                <div class="filtro-group">
                    <label for="pais_id">Filtrar por Seleção</label>
                    <select name="pais_id" id="pais_id">
                        <option value="">-- Todos os Países --</option>
                        @foreach($paises as $pais)
                            <option value="{{ $pais->id }}" {{ request('pais_id') == $pais->id ? 'selected' : '' }}>
                                {{ $pais->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filtrar">Filtrar</button>
                @if(request()->filled('pais_id'))
                    <a href="{{ route('adm.receitas.index') }}" class="btn-limpar">Limpar</a>
                @endif
            </form>
        </div>

        <!-- Tabela de Dados -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20%;">Prato</th>
                        <th style="width: 15%;">País</th>
                        <th style="width: 35%;">Modo de Preparo</th>
                        <th style="width: 20%;">Total Nutricional (Receita)</th>
                        <th style="width: 10%;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receitas as $receita)
                        <tr>
                            <td><strong>{{ $receita->nome }}</strong></td>
                            <td><span class="badge-pais">{{ $receita->pais->nome ?? 'N/A' }}</span></td>
                            <td style="color: #64748b; font-size: 13px; line-height: 1.4;">
                                {{ Str::limit($receita->descricao, 120, '...') }}
                            </td>
                            <td>
                                <!-- Painel Nutricional automático vindo do Accessor do Model -->
                                <div class="nutri-grid">
                                    <div><strong>Kcal:</strong> {{ number_format($receita->valores_nutricionais['calorias'], 1, ',', '.') }}</div>
                                    <div><strong>Carb:</strong> {{ number_format($receita->valores_nutricionais['carboidratos'], 1, ',', '.') }}g</div>
                                    <div><strong>Prot:</strong> {{ number_format($receita->valores_nutricionais['proteinas'], 1, ',', '.') }}g</div>
                                    <div><strong>Gord:</strong> {{ number_format($receita->valores_nutricionais['gorduras'], 1, ',', '.') }}g</div>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('adm.receitas.edit', $receita->id) }}" class="btn-edit">✏️</a>
                                    
                                    <form action="{{ route('adm.receitas.destroy', $receita->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                                Nenhuma receita localizada no banco sabor_db.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação nativa padrão Bootstrap/Simple do Laravel -->
        <div class="pagination-container">
            {{ $receitas->appends(request()->query())->links() }}

        </div>

    </div>

</body>
</html>
