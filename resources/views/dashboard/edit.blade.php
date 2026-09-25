<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Receita: ') }} {{ \$receita->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 24px;">
                
                <div style="margin-bottom: 20px;">
                    <a href="{{ route('dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">← Voltar para a Lista</a>
                </div>

                <form method="POST" action="{{ route('receitas.update', \$receita->id) }}" style="display: flex; flex-direction: column; gap: 15px;">
                    @csrf
                    @method('PUT') <!-- Diretiva crucial do Laravel para aceitar rotas PUT -->

                    <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Título da Receita</label>
                        <input type="text" name="titulo" value="{{ \$receita->titulo }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Origem / País</label>
                            <input type="text" name="pais" value="{{ \$receita->pais }}" placeholder="Ex: Itália" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">URL da Imagem (Opcional)</label>
                            <input type="text" name="imagem" value="{{ \$receita->imagem }}" placeholder="https://..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600; display: block; margin-bottom: 5px; color: #4b5563; font-size: 14px;">Modo de Preparo</label>
                        <textarea name="modo_preparo" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit; resize: none;">{{ \$receita->modo_preparo }}</textarea>
                    </div>

                    <!-- CONTAINER DE INGREDIENTES EXISTENTES E DINÂMICOS -->
                    <div style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label style="font-weight: 700; display: block; margin-bottom: 10px; color: #1e293b; font-size: 14px;">📋 Editar Ingredientes</label>
                        
                        <div id="container-ingredientes" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px;">
                            <!-- Lista e preenche os ingredientes atuais vindo do banco de dados -->
                            @forelse(receita->ingredientes as ingrediente)
                                <div class="linha-ingrediente" style="display: flex; gap: 6px; align-items: center;">
                                    <input type="text" name="ingredientes_nome[]" value="{{ \$ingrediente->nome }}" required style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                                    <input type="text" name="ingredientes_qtd[]" value="{{ \$ingrediente->quantidade }}" required style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; text-align: center;">
                                    <input type="text" name="ingredientes_unidade[]" value="{{ \$ingrediente->unidade_medida }}" required style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; font-size: 16px; cursor: pointer; padding: 0 4px;">❌</button>
                                </div>
                            @empty
                                <!-- Caso a receita não tenha nenhum ingrediente lançado por erro anterior -->
                                <div class="linha-ingrediente" style="display: flex; gap: 6px;">
                                    <input type="text" name="ingredientes_nome[]" placeholder="Ingrediente" style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                                    <input type="text" name="ingredientes_qtd[]" placeholder="Qtd" style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; text-align: center;">
                                    <input type="text" name="ingredientes_unidade[]" placeholder="Medida" style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                                </div>
                            @endforelse
                        </div>

                        <button type="button" id="btn-add-ingrediente" style="background-color: #0f172a; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer;">
                            ➕ Adicionar novo campo de ingrediente
                        </button>
                    </div>

                    <button type="submit" style="background-color: #2563eb; color: white; border: none; padding: 12px; font-weight: bold; border-radius: 8px; font-size: 15px; cursor: pointer; align-self: flex-start; margin-top: 10px; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);">
                        💾 Salvar Alterações
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Script clonador adaptado para a tela de edição -->
    <script>
        document.getElementById('btn-add-ingrediente').addEventListener('click', function() {
            const container = document.getElementById('container-ingredientes');
            const novaLinha = document.createElement('div');
            novaLinha.className = 'linha-ingrediente';
            novaLinha.style.display = 'flex';
            novaLinha.style.gap = '6px';
            novaLinha.style.alignItems = 'center';
            
            novaLinha.innerHTML = `
                <input type="text" name="ingredientes_nome[]" placeholder="Ingrediente" style="flex: 2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                <input type="text" name="ingredientes_qtd[]" placeholder="Qtd" style="flex: 0.8; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; text-align: center;">
                <input type="text" name="ingredientes_unidade[]" placeholder="Medida" style="flex: 1.2; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; font-size: 16px; cursor: pointer; padding: 0 4px;">❌</button>
            `;
            container.appendChild(novaLinha);
        });
    </script>
</x-app-layout>
