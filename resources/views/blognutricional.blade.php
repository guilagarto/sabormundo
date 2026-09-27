@extends('layouts.public')

@section('content')
<style>
    .nutri-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: #1e1e1e;
        color: #f8fafc;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .nutri-title {
        color: #22c55e;
        border-bottom: 2px solid #22c55e;
        padding-bottom: 10px;
        margin-bottom: 25px;
        font-weight: bold;
    }
    .nutri-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        color: #cbd5e1;
    }
    .nutri-input, .nutri-select {
        width: 100%;
        padding: 12px;
        background-color: #2d2d2d;
        border: 1px solid #404040;
        border-radius: 6px;
        color: #ffffff;
        margin-bottom: 20px;
        box-sizing: border-box;
    }
    .nutri-input:focus, .nutri-select:focus {
        border-color: #22c55e;
        outline: none;
    }
    .row-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }
    .btn-submit {
        background-color: #166534;
        color: #ffffff;
        padding: 15px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s;
    }
    .btn-submit:hover {
        background-color: #15803d;
    }
    .text-warning-custom { color: #f59e0b; }
    .text-danger-custom { color: #ef4444; }
</style>

<div class="nutri-container">
    <h2 class="nutri-title">🎯 Avaliação Nutricional Interativa</h2>
    
    <form action="{{ route('nutricao.calcular') }}" method="POST">
        @csrf
        
        <label class="nutri-label">Qual é o seu principal objetivo?</label>
        <select name="objetivo" class="nutri-select" required>
            <option value="equilibrio">Alimentação Equilibrada / Saudável</option>
            <option value="emagrecimento">Emagrecimento</option>
            <option value="ganho_massa">Ganho de Massa Muscular (Hipertrofia)</option>
            <option value="ganho_peso">Ganho de Peso Geral</option>
        </select>

        <div class="row-grid">
            <div>
                <label class="nutri-label">Idade (anos)</label>
                <input type="number" name="idade" value="36" class="nutri-input" required min="1" max="120">
            </div>
            <div>
                <label class="nutri-label">Sexo</label>
                <select name="sexo" class="nutri-select" required>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>
            <div>
                <label class="nutri-label">Altura (cm)</label>
                <input type="number" name="altura" value="179" class="nutri-input" required>
            </div>
            <div>
                <label class="nutri-label">Peso (kg)</label>
                <input type="number" step="0.1" name="peso" value="72" class="nutri-input" required>
            </div>
        </div>

        <div class="row-grid" style="grid-template-columns: 2fr 1fr;">
            <div>
                <label class="nutri-label">Nível de Atividade Física</label>
                <select name="nivel_atividade" class="nutri-select" required>
                    <option value="moderado">Moderado (Exercício moderado 3-5 dias/semana)</option>
                    <option value="sedentario">Sedentário (Pouco ou nenhum exercício)</option>
                    <option value="leve">Leve (Exercício leve 1-3 dias/semana)</option>
                    <option value="intenso">Intenso (Exercício pesado 6-7 dias/semana)</option>
                </select>
            </div>
            <div>
                <label class="nutri-label">Frequência Semanal</label>
                <input type="number" name="frequencia" value="3" class="nutri-input" min="0" max="14" required>
            </div>
        </div>

        <label class="nutri-label text-warning-custom">Alergias / Restrições Alimentares (Opcional - Separe por vírgula)</label>
        <input type="text" name="restricoes" class="nutri-input" placeholder="Ex: leite, camarão, amendoim">

        <label class="nutri-label text-danger-custom">Alimentos que você NÃO gosta (Opcional - Separe por vírgula)</label>
        <input type="text" name="rejeitados" class="nutri-input" placeholder="Ex: jiló, coentro, rabanete">

        <button type="submit" class="btn-submit">Gerar Diagnóstico Nutricional</button>
    </form>
</div>
@endsection
