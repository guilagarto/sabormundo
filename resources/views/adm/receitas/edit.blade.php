@extends('layouts.admin')

@section('title', 'Editar Receita')

@section('styles')
    <style>
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #1e293b; }
        input[type="text"], input[type="number"], textarea, select { width: 100%; box-sizing: border-box; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; background-color: #fff; }
        input:focus, textarea:focus, select:focus { border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .secao-ingredientes { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 10px; margin-top: 25px; }
        .secao-topo { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .secao-titulo { font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-add { background-color: #3b82f6; color: white; border: none; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px; cursor: pointer; }
        .btn-add:hover { background-color: #2563eb; }
        .linha-ingrediente { display: flex; gap: 12px; margin-bottom: 12px; align-items: center; }
        .col-select { flex: 2; }
        .col-qtd { width: 100px; }
        .col-medida { width: 150px; }
        .btn-remover { background: none; border: none; font-size: 16px; cursor: pointer; color: #ef4444; padding: 8px; }
        .btn-remover:hover { color: #b91c1c; }
        .footer-form { display: flex; justify-content: flex-end; padding-top: 20px; border-top: 1px solid #f1f5f9; margin-top: 25px; }
        .btn-salvar { background-color: #0f172a; color: white; border: none; padding: 12px 24px; font-size: 15px; font-weight: 600; border-radius: 8px; cursor: pointer; }
        .btn-salvar:hover { background-color: #1e293b; }
        .alert-erro { background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 25px; font-size: 14px; }
        .alert-erro ul { margin: 5px 0 0 0; padding-left: 20px; }
        .header-context { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 25px; }
        .header-context h2 { margin: 0; font-size: 22px; color: #0f172a; }
        .header-context p { margin: 5px 0 0 0; font-size: 14px; color: #64748b; }
        .btn-voltar { text-decoration: none; padding: 8px 16px; font-size: 14px; font-weight: 500; color: #475569; background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; }
    </style>
@endsection

@section('content')
    <div class="header-context">
        <div>
            <h2>Modificar Receita</h2>
            <p>Ajuste as propriedades do prato ou modifique as proporções da tabela nutricional.</p>
        </div>
        <a href="{{ route('adm.receitas.index') }}" class="btn-voltar">Cancelar</a>
    </div>

    @if (\$errors->any())
        <div class="alert-erro">
            <strong>Atenção! Verifique as informações:</strong>
            <ul>
                @foreach (\(errors->all() as\)error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adm.receitas.update', \$receita->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="pais_id">Seleção da Copa (País)</label>
                <select name="pais_id" id="pais_id" required>
                    @foreach(\(paises as\)pais)
                        <option value="{{ \$pais->id }}" {{ (old('pais_id', \(receita->pais_id) ==\)pais->id) ? 'selected' : '' }}>
                            {{ \$pais->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nome">Nome do Prato</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', \$receita->nome) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="descricao">Modo de Preparo</label>
            <textarea name="descricao" id="descricao" rows="5" required>{{ old('descricao', \$receita->descricao) }}</textarea>
        </div>

        <div class="secao-ingredientes">
            <div class="secao-topo">
                <span class="secao-titulo">Ingredientes da Receita (TACO/TBCA)</span>
                <button type="button" id="btn-add" class="btn-add">+ Adicionar Linha</button>
            </div>

            <div id="container-linhas">
                @foreach(\$receita->ingredients as \(index =>\)currentIngredient)
                    <div class="linha-ingrediente item-ingrediente">
                        <div class="col-select">
                            <select name="ingredients[{{ \$index }}][id]" required>
                                @foreach(\(ingredients as\)ing)
                                    <option value="{{ \$ing->id }}" {{ \(currentIngredient->id ==\)ing->id ? 'selected' : '' }}>
                                        {{ \$ing->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-qtd">
                            <input type="number" step="0.01" name="ingredients[{{ \(index }}][quantidade]" value="{{ \)currentIngredient->pivot->quantidade }}" required>
                        </div>
                        <div class="col-medida">
                            <input type="text" name="ingredients[{{ \(index }}][unidade_medida]" value="{{ \)currentIngredient->pivot->unidade_medida }}" required>
                        </div>
                        <button type="button" onclick="removerLinha(this)" class="btn-remover">🗑️</button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="footer-form">
            <button type="submit" class="btn-salvar">Atualizar Registro</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        let indiceAtual = {{ \$receita->ingredients->count() }};

        document.getElementById('btn-add').addEventListener('click', function() {
            const container = document.getElementById('container-linhas');
            const novaLinha = document.createElement('div');
            novaLinha.className = 'linha-ingrediente item-ingrediente';

            novaLinha.innerHTML = `
                <div class="col-select">
                    <select name="ingredients[${indiceAtual}][id]" required>
                        <option value="">-- Selecione o Alimento (TACO) --</option>
                        @foreach($ingredients as $ing)
                            <option value="{{ $ing->id }}">{{ $ing->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-qtd">
                    <input type="number" step="0.01" name="ingredients[${indiceAtual}][quantidade]" required placeholder="Qtd">
                </div>
                <div class="col-medida">
                    <input type="text" name="ingredients[${indiceAtual}][unidade_medida]" required placeholder="Ex: g, ml, xícara">
                </div>
                <button type="button" onclick="removerLinha(this)" class="btn-remover">🗑️</button>
            `;

            container.appendChild(novaLinha);
            indiceAtual++;
        });

        function removerLinha(botao) {
            const linha = botao.closest('.item-ingrediente');
            if (linha) {
                linha.remove();
            }
        }
    </script>
@endsection
