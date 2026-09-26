<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel do SaborMundo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- SEÇÃO 1: FORMULÁRIO DE CADASTRO -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 24px;">
                <h3 style="font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 15px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
                    📝 Cadastrar Nova Receita
                </h3>

                <form method="POST" action="<?php echo route('receitas.store'); ?>" style="display: flex; flex-direction: column; gap: 15px; max-width: 600px;">
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
                                <?php if (!empty($paises)): ?>
                                    <?php foreach ($paises as $p): ?>
                                        <option value="<?php echo $p->nome; ?>"><?php echo $p->nome; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
            <!-- SEÇÃO 2: LISTAGEM DE RECEITAS COM FILTRO INTEGRADO -->
                        <!-- SEÇÃO 2: LISTAGEM DE RECEITAS COM FILTRO INTEGRADO -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 24px;">
                @include('dashboard.lista')
            </div>

        </div>
    </div>

    <!-- Script Injetor Dinâmico de Linhas de Ingredientes -->
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
