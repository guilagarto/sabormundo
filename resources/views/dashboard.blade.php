<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do SaborMundo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- SEÇÃO 1: FORMULÁRIO DE CADASTRO -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 24px;">
                <h3 style="font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 15px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
                    📝 Cadastrar Nova Receita
                </h3>

                <form method="POST" action="{{ route('receitas.store') }}" style="display: flex; flex-direction: column; gap: 15px; max-width: 600px;">
                    @csrf

                    <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Título da Receita</label>
                        <input type="text" name="titulo" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                       <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Origem / País</label>
                        <select name="pais" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; background-color: white;">
                            <option value="">-- Selecione o País da Copa --</option>
                            @foreach($paises as $p)
                                <option value="{{ $p->nome }}">{{ $p->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                        <div>
                            <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">URL da Imagem (Opcional)</label>
                            <input type="text" name="imagem" placeholder="https://..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Modo de Preparo</label>
                        <textarea name="modo_preparo" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit; resize: none;"></textarea>
                    </div>

                    <div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label style="font-weight: 700; display: block; margin-bottom: 10px; color: #1e293b; font-size: 14px;">📋 Ingredientes</label>
                        
                        <div id="container-ingredientes" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px;">
                            <div class="linha-ingrediente" style="display: flex; gap: 6px;">
                                <input type="text" name="ingredientes_nome[]" placeholder="Ingrediente (ex: Farinha)" required style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                                <input type="text" name="ingredientes_qtd[]" placeholder="Qtd" required style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; text-align: center;">
                                <input type="text" name="ingredientes_unidade[]" placeholder="Medida (g, xícara)" required style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                            </div>
                        </div>

                        <button type="button" id="btn-add-ingrediente" style="background-color: #0f172a; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer;">
                            ➕ Adicionar mais um ingrediente
                        </button>
                    </div>

                    <button type="submit" style="background-color: #16a34a; color: white; border: none; padding: 12px; font-weight: bold; border-radius: 8px; font-size: 15px; cursor: pointer; align-self: flex-start;">
                        💾 Salvar Receita Completa
                    </button>
                </form>
            </div>

            <!-- SEÇÃO 2: LISTAGEM DE RECEITAS COM BOTÕES GERENCIAIS -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 24px;">
                <h3 style="font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 20px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
                    🍽️ Minhas Receitas Cadastradas
                </h3>

               <div style="display: flex; flex-direction: column; gap: 20px;">
    <?php if(count($receitas) > 0): ?>
        <?php foreach($receitas as $receita): ?>
            <div style="border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; background-color: #f9fafb;">
                <h4 style="font-size: 18px; font-weight: bold; color: #111827;">
                    <?php echo $receita->titulo; ?> 
                    <span style="font-weight: normal; font-size: 13px; color: #6b7280; background-color: #e5e7eb; padding: 3px 8px; border-radius: 4px; margin-left: 6px;">
                        <?php echo $receita->pais ?? 'Origem Geral'; ?>
                    </span>
                </h4>

                <!-- BOTÕES DE CONTROLE: EDITAR E EXCLUIR -->
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <a href="<?php echo route('receitas.edit', $receita->id); ?>" style="font-size: 12px; background-color: #ffffff; color: #1f2937; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        ✏️ Editar Receita
                    </a>

                    <form method="POST" action="<?php echo route('receitas.destroy', $receita->id); ?>" onsubmit="return confirm('Tem certeza que deseja apagar essa receita para sempre?')">
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
                        <?php if($receita->ingredientes): ?>
                            <?php foreach($receita->ingredientes as $ingrediente): ?>
                                <li><strong><?php echo $ingrediente->nome; ?></strong> — <?php echo $ingrediente->quantidade; ?> <?php echo $ingrediente->unidade_medida; ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <p style="font-size: 14px; color: #374151; line-height: 1.5; white-space: pre-line;"><strong>📖 Modo de Preparo:</strong><br><?php echo $receita->modo_preparo; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #6b7280; font-size: 14px; text-align: center; padding: 20px 0;">Você ainda não possui nenhuma receita guardada no sistema.</p>
    <?php endif; ?>
</div>


        </div>
    </div>

    <!-- Script Clonador Dinâmico -->
    <script>
        document.getElementById('btn-add-ingrediente').addEventListener('click', function() {
            const container = document.getElementById('container-ingredientes');
            const novaLinha = document.createElement('div');
            novaLinha.className = 'linha-ingrediente';
            novaLinha.style.display = 'flex';
            novaLinha.style.gap = '6px';
            
            novaLinha.innerHTML = `
                <input type="text" name="ingredientes_nome[]" placeholder="Ingrediente" style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                <input type="text" name="ingredientes_qtd[]" placeholder="Qtd" style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; text-align: center;">
                <input type="text" name="ingredientes_unidade[]" placeholder="Medida" style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
            `;
            container.appendChild(novaLinha);
        });
    </script>
</x-app-layout>
