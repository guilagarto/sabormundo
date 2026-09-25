<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançar Receita - Sabormundo</title>
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lançar Nova Receita</h2>
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
        </div>

        <!-- Exibe mensagens de erro de validação caso falte algum campo obrigatório -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Formulário apontando para a nossa rota de salvar via método POST -->
                <form action="{{ route('dashboard.store') }}" method="POST">
                    <!-- Diretiva obrigatória do Laravel para proteção contra ataques maliciosos (CSRF) -->
                    @csrf

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título da Receita</label>
                        <input type="text" class="form-id" name="titulo" id="titulo" class="form-control" required placeholder="Ex: Feijoada Brasileira">
                    </div>

                    <div class="mb-3">
                        <label for="pais_id" class="form-label">Código do País (ID)</label>
                        <input type="number" name="pais_id" id="pais_id" class="form-control" required placeholder="Ex: 1">
                    </div>

                    <div class="mb-3">
                        <label for="imagem" class="form-label">URL da Imagem</label>
                        <input type="text" name="imagem" id="imagem" class="form-control" placeholder="Ex: https://site.com">
                    </div>

                    <div class="mb-3">
                        <label for="ingredientes" class="form-label">Ingredientes</label>
                        <textarea name="ingredientes" id="ingredientes" rows="4" class="form-control" required placeholder="Digite os ingredientes..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="modo_preparo" class="form-label">Modo de Preparo</label>
                        <textarea name="modo_preparo" id="modo_preparo" rows="5" class="form-control" required placeholder="Descreva o passo a passo..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Gravar e Lançar Receita</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
