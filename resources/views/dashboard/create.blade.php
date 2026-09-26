<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Nova Receita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 24px;">
                
                <div style="margin-bottom: 20px;">
                    <a href="{{ route('dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">← Voltar para a Lista</a>
                </div>

                <form method="POST" action="{{ route('receitas.store') }}" style="display: flex; flex-direction: column; gap: 15px;">
                    @csrf

                    <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Título da Receita</label>
                        <input type="text" name="titulo" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Origem / País</label>
                            <input type="text" name="pais" placeholder="Ex: Itália" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">URL da Imagem (Opcional)</label>
                            <input type="text" name="imagem" placeholder="https://..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Modo de Preparo</label>
                        <textarea name="modo_preparo" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit; resize: none;"></textarea>
                    </div>

                    <!-- CONTAINER DE INGREDIENTES DINÂMICOS -->
                    <div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label style="font-weight: 700; display: block; margin-bottom: 10px; color: #1e293b; font-size: 14px;">📋 Ingredientes da Receita</label>
                        
                       <!-- CONTAINER DE INGREDIENTES DINÂMICOS -->
<div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
    <label style="font-weight: 700; display: block; margin-bottom: 10px; color: #1e293b;">Ingredientes da Receita</label>
    
    <div id="container-ingredientes" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px;">
        <!-- Linha Inicial (Índice 0) -->
        <div class="linha-ingrediente" style="display: flex; gap: 6px;">
            <select name="ingredients[0][id]" required style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                <option value="">Selecione um Ingrediente (TACO/TBCA)</option>
                @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}">{{ $ingredient->nome }}</option>
                @endforeach
            </select>
            <input type="number" step="0.01" name="ingredients[0][quantidade]" placeholder="Qtd (g ou ml)" required style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <input type="text" name="ingredients[0][unidade_medida]" placeholder="Medida (ex: g, xícara)" required style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
        </div>
    </div>

    <button type="button" id="btn-add-ingrediente" style="background-color: #0f172a; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
        + Adicionar mais um ingrediente
    </button>
</div>


                        <button type="button" id="btn-add-ingrediente" style="background-color: #0f172a; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer;">
                            ➕ Adicionar mais um ingrediente
                        </button>
                    </div>

                    <button type="submit" style="background-color: #16a34a; color: white; border: none; padding: 12px; font-weight: bold; border-radius: 8px; font-size: 15px; cursor: pointer; align-self: flex-start; margin-top: 10px;">
                        💾 Salvar Receita Completa
                    </button>
                </form>

            </div>
        </div>
        <div class="mt-6 space-y-6">
    @forelse($receitasCadastradas as $receita)
        <div style="background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 16px;">
            <!-- Cabeçalho da Receita -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                <div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #0f172a;">{{ $receita->nome }}</h3>
                    <span style="background-color: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                        🏳️ {{ $receita->pais->nome ?? 'País não informado' }}
                    </span>
                </div>
            </div>

            <!-- Descrição / Modo de Preparo -->
            <div class="mt-3">
                <p style="color: #475569; font-size: 14px;"><strong>Modo de Preparo:</strong> {{ $receita->descricao }}</p>
            </div>

            <!-- Grid de Informações: Ingredientes Usados vs Tabela Nutricional Total -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
                
                <!-- Coluna 1: Lista de Ingredientes Digitados -->
                <div style="background-color: #f8fafc; padding: 12px; border-radius: 6px;">
                    <h4 style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Ingredientes Selecionados</h4>
                    <ul style="font-size: 13px; color: #64748b; list-style-type: disc; padding-left: 20px;">
                        @foreach($receita->ingredients as $ingrediente)
                            <li>{{ $ingrediente->nome }} — {{ number_format($ingrediente->pivot->quantidade, 2, ',', '.') }} {{ $ingrediente->pivot->unidade_medida }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Coluna 2: Painel Nutricional Somado pelo Backend -->
                <div style="background-color: #fefce8; padding: 12px; border-radius: 6px; border: 1px solid #fef08a;">
                    <h4 style="font-size: 14px; font-weight: 700; color: #854d0e; margin-bottom: 8px;">📊 Informação Nutricional Total</h4>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 13px; color: #713f12;">
                        <div><strong>Calorias:</strong> {{ $receita->valores_nutricionais['calorias'] }} kcal</div>
                        <div><strong>Carboidratos:</strong> {{ $receita->valores_nutricionais['carboidratos'] }}g</div>
                        <div><strong>Proteínas:</strong> {{ $receita->valores_nutricionais['proteinas'] }}g</div>
                        <div><strong>Gorduras:</strong> {{ $receita->valores_nutricionais['gorduras'] }}g</div>
                        <div style="grid-column: span 2;"><strong>Sódio:</strong> {{ $receita->valores_nutricionais['sodio'] }} mg</div>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <p style="color: #64748b; font-size: 14px; text-align: center; padding: 20px;">
            Nenhuma receita encontrada para o filtro selecionado.
        </p>
    @endforelse
</div>

    </div>

   <script>
    let ingredienteIndex = 1; // Começa em 1 porque o índice 0 já está renderizado no HTML acima

    document.getElementById('btn-add-ingrediente').addEventListener('click', function() {
        const container = document.getElementById('container-ingredientes');
        const novaLinha = document.createElement('div');
        
        novaLinha.className = 'linha-ingrediente';
        novaLinha.style.display = 'flex';
        novaLinha.style.style = 'flex'; // Mantendo sua propriedade original
        novaLinha.style.gap = '6px';

        // Gera o HTML interno injetando o índice atual dinamicamente nas propriedades 'name'
        novaLinha.innerHTML = `
            <select name="ingredients[${ingredienteIndex}][id]" required style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                <option value="">Selecione um Ingrediente (TACO/TBCA)</option>
                @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}">{{ $ingredient->nome }}</option>
                @endforeach
            </select>
            <input type="number" step="0.01" name="ingredients[${ingredienteIndex}][quantidade]" placeholder="Qtd (g ou ml)" required style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <input type="text" name="ingredients[${ingredienteIndex}][unidade_medida]" placeholder="Medida (ex: g, xícara)" required style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
        `;

        container.appendChild(novaLinha);
        ingredienteIndex++; // Incrementa para o próximo botão de clique
    });
</script>

</x-app-layout>
