@extends('layouts.public')

@section('content')
<style>
    .about-body {
        background-color: #0f172a;
        margin: 0;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f8fafc;
    }
    .about-container {
        max-width: 1000px;
        margin: 0 auto;
        box-sizing: border-box;
    }
    
    /* Seção de Destaque / Contador */
    .hero-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 50px;
        align-items: center;
    }
    @media (max-width: 768px) {
        .hero-section { grid-template-columns: 1fr; }
    }
    .hero-text h1 {
        font-size: 36px;
        color: #22c55e;
        margin-top: 0;
        font-weight: bold;
    }
    .hero-text p {
        font-size: 16px;
        color: #cbd5e1;
        line-height: 1.6;
    }
    
    /* Card do Contador Dinâmico */
    .counter-card {
        background: linear-gradient(135deg, #15803d 0%, #166534 100%);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(22, 101, 52, 0.2);
    }
    .counter-num {
        font-size: 56px;
        font-weight: bold;
        color: #ffffff;
        margin: 0;
        line-height: 1;
    }
    .counter-label {
        font-size: 14px;
        color: #bbf7d0;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        margin-top: 10px;
    }

    /* Como Funciona */
    .steps-section {
        margin-bottom: 50px;
    }
    .section-title {
        font-size: 24px;
        color: #ffffff;
        border-left: 4px solid #22c55e;
        padding-left: 12px;
        margin-bottom: 25px;
        font-weight: bold;
    }
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .step-card {
        background-color: #1e293b;
        border: 1px solid #334155;
        border-radius: 8px;
        padding: 25px;
        transition: transform 0.2s;
    }
    .step-card:hover {
        transform: translateY(-3px);
    }
    .step-icon {
        font-size: 32px;
        margin-bottom: 15px;
    }
    .step-name {
        font-size: 18px;
        font-weight: bold;
        color: #22c55e;
        margin-bottom: 10px;
    }
    .step-desc {
        font-size: 14px;
        color: #94a3b8;
        line-height: 1.5;
        margin: 0;
    }

    /* Formulário da Newsletter */
    .newsletter-box {
        background-color: #1e293b;
        border: 1px solid #22c55e;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .news-title {
        font-size: 28px;
        color: #ffffff;
        margin-top: 0;
        font-weight: bold;
    }
    .news-desc {
        font-size: 15px;
        color: #94a3b8;
        max-width: 600px;
        margin: 10px auto 25px auto;
        line-height: 1.5;
    }
    .news-form {
        display: flex;
        max-width: 550px;
        margin: 0 auto;
        gap: 10px;
    }
    @media (max-width: 576px) {
        .news-form { flex-direction: column; }
    }
    .news-input {
        flex-grow: 1;
        padding: 14px 20px;
        background-color: #0f172a;
        border: 1px solid #334155;
        border-radius: 6px;
        color: #ffffff;
        font-size: 15px;
    }
    .news-input:focus {
        border-color: #22c55e;
        outline: none;
    }
    .news-btn {
        background-color: #22c55e;
        color: #ffffff;
        padding: 14px 30px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .news-btn:hover {
        background-color: #15803d;
    }
</style>
<div class="about-body">
    <div class="about-container">
        
        <!-- Seção Principal e Contador Dinâmico -->
        <section class="hero-section">
            <div class="hero-text">
                <h1>Mundo Sabor & Nutrição</h1>
                <p>O Mundo Sabor nasceu com a missão de unir a riqueza da gastronomia cultural de dezenas de países com a ciência da nutrição moderna. Acreditamos que comer bem não precisa ser sem graça, e que é possível explorar pratos típicos globais mantendo o controle exato dos seus macronutrientes e calorias diárias.</p>
                <p>Nossa plataforma analisa seu perfil biométrico, calcula suas metas energéticas e cruza esses dados com receitas reais de forma inteligente, excluindo alergias e alimentos que você não gosta.</p>
            </div>
            
            <!-- Card com Número Dinâmico de Receitas -->
            <div class="counter-card">
                <div class="step-icon" style="margin-bottom: 5px;">📚</div>
                <div class="counter-num">{{ $totalReceitas ?? 0 }}</div>
                <div class="counter-label">Receitas Globais Cadastradas</div>
            </div>
        </section>

        <!-- Como Funciona o Site -->
        <section class="steps-section">
            <h3 class="section-title">🔍 Como a plataforma funciona?</h3>
            <div class="steps-grid">
                
                <div class="step-card">
                    <div class="step-icon">🎯</div>
                    <div class="step-name">1. Defina seu Objetivo</div>
                    <p class="step-desc">Seja para emagrecimento, ganho de massa muscular ou apenas manter uma alimentação equilibrada, o sistema adapta-se à sua meta calórica.</p>
                </div>
                
                <div class="step-card">
                    <div class="step-icon">📊</div>
                    <div class="step-name">2. Cálculo Biométrico</div>
                    <p class="step-desc">Usamos fórmulas de alta precisão (Harris-Benedict) cruzando sua idade, peso, altura e frequência de treinos para descobrir seu gasto calórico total.</p>
                </div>
                
                <div class="step-card">
                    <div class="step-icon">🧼</div>
                    <div class="step-name">3. Filtro de Restrições</div>
                    <p class="step-desc">Nosso banco varre os ingredientes e oculta pratos inteiros se contiverem alergias informadas ou alimentos que você rejeitou no formulário.</p>
                </div>
                
                <div class="step-card">
                    <div class="step-icon">🥗</div>
                    <div class="step-name">4. Integração com a TACO</div>
                    <p class="step-desc">Todas as sugestões exibem gráficos de macros gerados a partir do peso real dos ingredientes linkados à tabela oficial da TACO.</p>
                </div>

            </div>
        </section>

        <!-- Seção da Newsletter Interativa -->
        <!-- Seção da Newsletter Interativa Atualizada -->
<section class="newsletter-box">
    <h3 class="news-title">📩 Fique por dentro do Mundo Sabor</h3>
    <p class="news-desc">Inscreva-se na nossa newsletter semanal para receber dicas de nutrição, curiosidades sobre a história dos pratos e novas receitas típicas adicionadas ao sistema.</p>
    
    <!-- Mensagem de Sucesso -->
    @if(session('success'))
        <div style="background-color: #15803d; color: #ffffff; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensagem de Erro/Validação -->
    @if($errors->has('email'))
        <div style="background-color: #b91c1c; color: #ffffff; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
            {{ $errors->first('email') }}
        </div>
    @endif
    
    <form action="{{ route('public.newsletter.salvar') }}" method="POST" class="news-form">
        @csrf
        <input type="email" name="email" class="news-input" placeholder="Digite seu melhor e-mail..." required>
        <button type="submit" class="news-btn">Inscrever-se</button>
    </form>
</section>


    </div>
</div>
@endsection
