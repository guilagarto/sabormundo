@extends('layouts.admin')

@section('title', 'Cadastrar Receita')

@section('styles')
    <style>
        /* Apenas regras de layout específicas para os formulários integrados */
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #1e293b; }
        input[type="text"], input[type="number"], textarea, select { width: 100%; box-sizing: border-box; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; transition: border-color 0.2s; background-color: #fff; }
        input:focus, textarea:focus, select:focus { border-color: #10b981; outline: none; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); }
        .secao-ingredientes { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 10px; margin-top: 25px; }
        .secao-topo { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .secao-titulo { font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-add { background-color: #10b981; color: white; border: none; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background 0.2s; }
        .btn-add:hover { background-color: #059669; }
        .linha-ingrediente { display: flex; gap: 12px; margin-bottom: 12px; align-items: center; }
        .col-select { flex: 2; }
        .col-qtd { width: 100px; }
        .col-medida { width: 150px; }
        .btn-remover { background: none; border: none; font-size: 16px; cursor: pointer; color: #ef4444; padding: 8px; transition: color 0.2s; }
        .btn-remover:hover { color: #b91c1c; }
        .footer-form { display: flex; justify-content: flex-end; padding-top: 20px; border-top: 1px solid #f1f5f9; margin-top: 25px; }
        .btn-salvar { background-color: #0f172a; color: white; border: none; padding: 12px 24px; font-size: 15px; font-weight: 600; border-radius: 8px; cursor: pointer; transition: background 0.2s; }
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
    <!-- Cabeçalho Local do Formulário -->
    <div class="header-context">
        <div>
            <h2>Nova Receita Mundial</h2>
            <p>Insira as informações básicas e adicione os ingredientes da tabela TACO/TBCA.</p>
        </div>
        <a href="{{ route('adm.receitas.index') }}" class="btn-voltar">Voltar à Lista</a>
    </div>

    <!-- Mensagens de Erro do Laravel -->
    @if (\$errors->any())
        <div class="alert-erro">
            <strong>Atenção! Corrija os seguintes erros:</strong>
            <ul>
                @foreach (errors->all() as error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário Oficial -->
    <form action="{{ route('adm.receitas.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <!-- Seleção de País -->
            <div class="form-group">
                <label for="pais_id">Seleção da Copa (País)</label>
                <select name="pais_id" id="pais_id" required>
                    <option value="">-- Selecione o País --</option>
                    @foreach(paises as pais)
                        <option value="{{ \(pais->id }}" {{ old('pais_id') == \)pais->id ? 'selected' : '' }}>
                            {{ \$pais->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nome do Prato -->
            <div class="form-group">
                <label for="nome">Nome do Prato Tradicional</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required placeholder="Ex: Masgouf, Biryani...">
            </div>
        </div>

        <!-- Modo de Preparo -->
        <div class="form-group">
            <label for="descricao">Modo de Preparo / Detalhes</label>
            <textarea name="descricao" id="descricao" rows="5" required placeholder="Descreva o passo a passo para a execução do prato...">{{ old('descricao') }}</textarea>
        </div>

        <!-- Bloco de Ingredientes Dinâmicos -->
        <div class="secao-ingredientes">
            <div class="secao-topo">
                <span class="secao-titulo">Composição de Ingredientes (Cálculo Nutricional)</span>
                <button type="button" id="btn-add" class="btn-add">+ Adicionar Linha</button>
            </div>

            <!-- Container das Linhas -->
            <div id="container-linhas">
                
                <!-- Linha Inicial Padrão (Índice 0) -->
                <div class="linha-ingrediente item-ingrediente">
                    <div class="col-select">
                        <select name="ingredients[0][id]" required>
                            <option value="">-- Selecione o Alimento (TACO) --</option>
                            @foreach(ingredients as ing)
                                <option value="{{ ing->id "> ing->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-qtd">
                        <input type="number" step="0.01" name="ingredients[0][quantidade]" required placeholder="Qtd">
                    </div>
                    <div class="col-medida">
                        <input type="text" name="ingredients[0][unidade_medida]" required placeholder="Ex: g, ml, xícara">
                    </div>
                    <button type="button" class="btn-remover" disabled style="opacity: 0.3;">🗑️</button>
                </div>

            </div>
        </div>

        <!-- Botão Salvar -->
        <div class="footer-form">
            <button type="submit" class="btn-salvar">Gravar e Salvar Receita</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        let indiceAtual = 1;

        document.getElementById('btn-add').addEventListener('click', function() {
            const container = document.getElementById('container-linhas');
            const novaLinha = document.createElement('div');
            novaLinha.className = 'linha-ingrediente item-ingrediente';

            novaLinha.innerHTML = `
                <div class="col-select">
                    <select name="ingredients[\${indiceAtual}][id]" required>
                        <option value="">-- Selecione o Alimento (TACO) --</option>
                        @foreach($ingredients as $ing)
                            <option value="{{ $ing->id }}">{{ $ing->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-qtd">
                    <input type="number" step="0.01" name="ingredients[\${indiceAtual}][quantidade]" required placeholder="Qtd">
                </div>
                <div class="col-medida">
                    <input type="text" name="ingredients[\${indiceAtual}][unidade_medida]" required placeholder="Ex: g, ml, xícara">
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
