@extends('layouts.public')

@section('title', 'Calculadora Culinária Avançada')

@section('styles')
    <style>
        .calc-header { text-align: center; margin: 30px 0; border-bottom: 1px solid #334155; padding-bottom: 20px; }
        .calc-header h1 { font-size: 32px; font-weight: 800; margin: 0; color: #ffffff; }
        .calc-header p { margin: 5px 0 0 0; color: #94a3b8; font-size: 15px; }

        .section-box { background-color: #1e293b; border: 1px solid #334155; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .section-title { font-size: 20px; font-weight: 700; color: #4ade80; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #334155; padding-bottom: 10px; display: flex; align-items: center; gap: 10px; }

        label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #cbd5e1; }
        input[type="text"], input[type="number"], select { width: 100%; box-sizing: border-box; padding: 10px 12px; border: 1px solid #334155; border-radius: 8px; font-size: 14px; background-color: #0f172a; color: #ffffff; }
        
        .ing-row { display: flex; gap: 12px; margin-bottom: 12px; align-items: center; }
        .btn-blue { background-color: #2563eb; color: white; border: none; padding: 10px 16px; font-size: 14px; font-weight: 600; border-radius: 6px; cursor: pointer; }
        .btn-green { background-color: #166534; color: white; border: none; padding: 12px 24px; font-size: 15px; font-weight: 700; border-radius: 6px; cursor: pointer; width: 100%; margin-top: 15px; }
        .btn-danger { background-color: #dc2626; color: white; border: none; padding: 10px; font-size: 14px; border-radius: 6px; cursor: pointer; }

        .rotulo-anvisa { background-color: #ffffff; color: #000000; padding: 20px; border: 2px solid #000000; max-width: 450px; margin: 25px auto 0 auto; font-family: 'Arial', sans-serif; }
        .rotulo-title { font-size: 20px; font-weight: 900; text-align: center; text-transform: uppercase; margin-bottom: 2px; border-bottom: 4px solid #000000; padding-bottom: 4px; }
        .rotulo-sub { font-size: 12px; border-bottom: 1px solid #000000; padding-bottom: 4px; margin-bottom: 6px; }
        .rotulo-line { display: flex; justify-content: space-between; border-bottom: 1px solid #000000; padding: 5px 0; font-size: 13px; }
        .rotulo-line.bold { font-weight: bold; border-bottom-width: 2px; }

        .grid-checkboxes { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 10px; max-height: 250px; overflow-y: auto; background-color: #0f172a; padding: 15px; border-radius: 8px; border: 1px solid #334155; }
        .check-item { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #cbd5e1; cursor: pointer; }
        .check-item input { cursor: pointer; width: 16px; height: 16px; }
        
        .results-container { display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 20px; }
        @media(min-width: 768px) { .results-container { grid-template-columns: 1fr 1fr; } }
        .result-panel { background-color: #0f172a; border: 1px solid #334155; padding: 15px; border-radius: 8px; }
        .result-panel h4 { margin-top: 0; margin-bottom: 12px; font-size: 15px; text-transform: uppercase; color: #94a3b8; border-bottom: 1px solid #334155; padding-bottom: 6px; }
        
        .match-card { background-color: #1e293b; padding: 12px 15px; border-radius: 6px; border-left: 4px solid #10b981; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .match-card.warning { border-left-color: #f59e0b; flex-direction: column; align-items: flex-start; gap: 6px; }
        .match-link { color: #38bdf8; text-decoration: none; font-weight: 700; font-size: 15px; }
        .match-link:hover { text-decoration: underline; }
        .badge-missing { font-size: 12px; background-color: #451a03; color: #f59e0b; padding: 2px 8px; border-radius: 4px; font-weight: 600; }
    </style>
@endsection
@section('content')
    <div class="calc-header">
        <h1>🧮 Central Nutricional Interativa</h1>
        <p>Monte receitas personalizadas ou descubra quais pratos tradicionais da Copa você pode cozinhar com o que tem em casa.</p>
    </div>

    <!-- BLOCO 1: GERADOR DE RÓTULO OFICIAL -->
    <div class="section-box">
        <h2 class="section-title">📝 1. Calculadora de Receitas & Rótulo Oficial</h2>
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label for="rec-nome">Nome da Receita / Prato:</label>
                <input type="text" id="rec-nome" placeholder="Ex: Meu Prato Saudável">
            </div>
            <div>
                <label for="rec-referencia">Porção de Referência (g):</label>
                <input type="number" id="rec-referencia" value="100">
            </div>
        </div>

        <label style="margin-bottom: 10px; display: block;">Ingredientes do Prato:</label>
        <div id="wrapper-linhas-calc">
            <!-- Linha Padrão Blindada com Elementos Visíveis -->
            <div class="ing-row item-calculadora">
                <select class="calc-select-alimento" style="flex: 2;">
                    <option value="">-- Selecione um Alimento (TACO) --</option>
                    @foreach($ingredients as $ing)
                                                <option value="{{ $ing->id }}" 
                                data-calorias="{{ $ing->calorias }}"
                                data-carboidratos="{{ $ing->carboidratos }}"
                                data-proteinas="{{ $ing->proteinas }}"
                                data-gorduras="{{ $ing->gorduras }}"
                                data-sodio="{{ $ing->sodio }}">
                            {{ $ing->nome }}
                        </option>

                    @endforeach
                </select>
                <input type="number" class="calc-peso-input" placeholder="Peso (g)" style="flex: 1;" value="100">
                <button type="button" class="btn-danger" onclick="if(document.querySelectorAll('.item-calculadora').length > 1) { this.closest('.ing-row').remove(); } else { alert('A receita precisa de ao menos um ingrediente!'); }">🗑️</button>
            </div>
        </div>

        <button type="button" class="btn-blue" id="btn-add-linha-calc" style="margin-top: 10px;">+ Adicionar Ingrediente</button>
        <button type="button" class="btn-green" id="btn-gerar-rotulo">Calcular Valores Nutricionais</button>

        <div id="container-rotulo-anvisa" style="display: none;"></div>
    </div>
    <!-- BLOCO 2: O QUE TEM NA GELADEIRA -->
    <div class="section-box" style="border-color: #166534;">
        <h2 class="section-title" style="color: #4ade80; border-bottom-color: #14532d;">🏳️ 2. O que consigo cozinhar com o que tenho?</h2>
        <p style="font-size: 14px; color: #94a3b8; margin: -10px 0 20px 0;">Marque os ingredientes que você tem em casa. O sistema buscará na hora os pratos correspondentes cadastrados!</p>

        <div class="grid-checkboxes">
            @foreach($ingredients as $ing)
                <label class="check-item">
                    <input type="checkbox" class="check-ingrediente" value="{{ $ing->id }}" onchange="cruzarIngredientesComReceitas()">
                    <span>{{ $ing->nome }}</span>
                </label>
            @endforeach
        </div>

        <div class="results-container">
            <div class="result-panel">
                <h4>🍽️ Pratos Prontos para Fazer</h4>
                <div id="lista-pratos-completos" style="color: #94a3b8; font-size: 14px;">Marque os ingredientes acima para calcular as combinações.</div>
            </div>

            <div class="result-panel">
                <h4>⚠️ Falta Pouco (Quase lá)</h4>
                <div id="lista-pratos-quase-la" style="color: #94a3b8; font-size: 14px;">Marque os ingredientes acima para ver o que falta.</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnAdd = document.getElementById('btn-add-linha-calc');
            const btnGerar = document.getElementById('btn-gerar-rotulo');
            const containerLinhas = document.getElementById('wrapper-linhas-calc');

            if (btnAdd) {
                btnAdd.addEventListener('click', function(e) {
                    e.preventDefault();
                    const primeiraLinha = containerLinhas.querySelector('.item-calculadora');
                    if (!primeiraLinha) return;

                    const novaLinha = primeiraLinha.cloneNode(true);
                    novaLinha.querySelector('.calc-peso-input').value = 100;
                    novaLinha.querySelector('.calc-select-alimento').selectedIndex = 0;
                    containerLinhas.appendChild(novaLinha);
                });
            }

            if (btnGerar) {
                btnGerar.addEventListener('click', function(e) {
                    e.preventDefault();
                    const porcaoRef = parseFloat(document.getElementById('rec-referencia').value) || 100;
                    let totais = { kcal: 0, carb: 0, prot: 0, gord: 0, sodi: 0, pesoTotal: 0 };
                    
                    const linhas = document.querySelectorAll('.item-calculadora');
                    linhas.forEach(linha => {
                        const select = linha.querySelector('.calc-select-alimento');
                        const peso = parseFloat(linha.querySelector('.calc-peso-input').value) || 0;
                        
                        if (select && select.value && peso > 0) {
                            const opcao = select.options[select.selectedIndex];
                            totais.pesoTotal += peso;
                            totais.kcal += (parseFloat(opcao.getAttribute('data-calorias')) / 100) * peso;
                            totais.carb += (parseFloat(opcao.getAttribute('data-carboidratos')) / 100) * peso;
                            totais.prot += (parseFloat(opcao.getAttribute('data-proteinas')) / 100) * peso;
                            totais.gord += (parseFloat(opcao.getAttribute('data-gorduras')) / 100) * peso;
                            totais.sodi += (parseFloat(opcao.getAttribute('data-sodio')) / 100) * peso;
                        }
                    });

                    if (totais.pesoTotal === 0) {
                        alert('Por favor, selecione ao menos um alimento e informe o peso!');
                        return;
                    }

                    const fator = porcaoRef / totais.pesoTotal;
                    const containerRotulo = document.getElementById('container-rotulo-anvisa');
                    
                    if (containerRotulo) {
                        containerRotulo.innerHTML = 
                            '<div class="rotulo-anvisa">' +
                                '<div class="rotulo-title">Informação Nutricional</div>' +
                                '<div class="rotulo-sub">Porções por embalagem: 1 porção<br>Porção: ' + porcaoRef + 'g (Peso total da receita: ' + totais.pesoTotal + 'g)</div>' +
                                '<div class="rotulo-line bold" style="background-color: #f1f5f9; padding: 5px;">' +
                                    '<span>NUTRIENTES</span>' +
                                    '<span>QUANTIDADE POR PORÇÃO</span>' +
                                '</div>' +
                                '<div class="rotulo-line bold">' +
                                    '<span>Valor energético (kcal)</span>' +
                                    '<span>' + (totais.kcal * fator).toFixed(1).replace('.', ',') + ' kcal</span>' +
                                '</div>' +
                                '<div class="rotulo-line">' +
                                    '<span>Carboidratos (g)</span>' +
                                    '<span>' + (totais.carb * fator).toFixed(1).replace('.', ',') + ' g</span>' +
                                '</div>' +
                                '<div class="rotulo-line">' +
                                    '<span>Proteínas (g)</span>' +
                                    '<span>' + (totais.prot * fator).toFixed(1).replace('.', ',') + ' g</span>' +
                                '</div>' +
                                '<div class="rotulo-line">' +
                                    '<span>Gorduras Totais (g)</span>' +
                                    '<span>' + (totais.gord * fator).toFixed(1).replace('.', ',') + ' g</span>' +
                                '</div>' +
                                '<div class="rotulo-line" style="border-bottom: none;">' +
                                    '<span>Sódio (mg)</span>' +
                                    '<span>' + (totais.sodi * fator).toFixed(1).replace('.', ',') + ' mg</span>' +
                                '</div>' +
                            '</div>';
                        containerRotulo.style.display = 'block';
                    }
                });
            }
        });

        function cruzarIngredientesComReceitas() {
            const checkboxes = document.querySelectorAll('.check-ingrediente:checked');
            const idsSelecionados = Array.from(checkboxes).map(cb => cb.value);

            const painelCompleto = document.getElementById('lista-pratos-completos');
            const painelQuaseLa = document.getElementById('lista-pratos-quase-la');

            if (idsSelecionados.length === 0) {
                painelCompleto.innerHTML = 'Marque os ingredientes acima para calcular as combinações.';
                painelQuaseLa.innerHTML = 'Marque os ingredientes acima para ver o que falta.';
                return;
            }

            fetch("{{ route('public.calculadora.buscar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ingredients: idsSelecionados })
            })
            .then(response => response.json())
            .then(data => {
                if (data.receitas_completas.length === 0) {
                    painelCompleto.innerHTML = '<span style="color: #64748b;">Nenhuma receita completa encontrada com essa exata combinação.</span>';
                } else {
                    painelCompleto.innerHTML = '';
                    data.receitas_completas.forEach(rec => {
                        painelCompleto.innerHTML += 
                            '<div class="match-card">' +
                                '<div>' +
                                    '<span style="font-size: 18px; margin-right: 4px;">' + rec.bandeira + '</span>' +
                                    '<span style="font-weight: 500; color: #94a3b8;">' + rec.pais + ':</span>' +
                                '</div>' +
                                '<a href="/receita/' + rec.slug + '" class="match-link" target="_blank">' + rec.nome + ' →</a>' +
                            '</div>';
                    });
                }

                if (data.receitas_quase_la.length === 0) {
                    painelQuaseLa.innerHTML = '<span style="color: #64748b;">Nenhuma receita próxima encontrada.</span>';
                } else {
                    painelQuaseLa.innerHTML = '';
                    data.receitas_quase_la.forEach(rec => {
                        painelQuaseLa.innerHTML += 
                            '<div class="match-card warning">' +
                                '<div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">' +
                                    '<div>' +
                                        '<span style="font-size: 18px; margin-right: 4px;">' + rec.bandeira + '</span>' +
                                        '<a href="/receita/' + rec.slug + '" class="match-link" target="_blank" style="color: #f59e0b;">' + rec.nome + '</a>' +
                                    '</div>' +
                                    '<span style="font-size: 13px; color: #94a3b8;">(' + rec.pais + ')</span>' +
                                '</div>' +
                                '<div style="font-size: 13px; color: #cbd5e1; margin-top: 4px;">' +
                                    '⚠️ Falta apenas: <span class="badge-missing">' + rec.faltando.join(', ') + '</span>' +
                                '</div>' +
                            '</div>';
                    });
                }
            })
            .catch(error => {
                console.error("Erro na busca inteligente:", error);
            });
        }
    </script>
@endsection

