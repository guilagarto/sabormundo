<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receita - Sabormundo</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background-color: #f4f6f9; color: #333; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h2 { margin-bottom: 20px; font-size: 1.4rem; color: #1a1a1a; border-bottom: 2px solid #ff6b6b; padding-bottom: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 0.9rem; font-weight: bold; margin-bottom: 5px; color: #555; }
        input[type="text"], input[type="number"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem; outline: none; }
        textarea { resize: vertical; }
        .btn-box { display: flex; gap: 10px; margin-top: 20px; }
        .btn { flex: 1; padding: 12px; border: none; border-radius: 4px; font-size: 0.95rem; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; }
        .btn-save { background-color: #ff6b6b; color: #fff; }
        .btn-cancel { background-color: #6c757d; color: #fff; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Editar: {{ $receita->titulo }}</h2>

        <form action="{{ route('dashboard.update', $receita->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titulo">Título da Receita</label>
                <input type="text" name="titulo" id="titulo" value="{{ $receita->titulo }}" required>
            </div>

            <div class="form-group">
                <label for="pais_id">País de Origem</label>
                <select name="pais_id" id="pais_id" required>
                    @foreach($paises as $p)
                        <option value="{{ $p->id }}" {{ $receita->pais_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="imagem">URL da Imagem</label>
                <input type="text" name="imagem" id="imagem" value="{{ $receita->imagem }}">
            </div>

            <div class="form-group">
                <label for="ingredientes">Ingredientes</label>
                <textarea name="ingredientes" id="ingredientes" rows="5" required>{{ $receita->ingredientes }}</textarea>
            </div>

            <div class="form-group">
                <label for="modo_preparo">Modo de Preparo</label>
                <textarea name="modo_preparo" id="modo_preparo" rows="6" required>{{ $receita->modo_preparo }}</textarea>
            </div>

            <div class="btn-box">
                <a href="{{ route('dashboard') }}" class="btn btn-cancel">Cancelar</a>
                <button type="submit" class="btn btn-save">Salvar Alterações</button>
            </div>
        </form>
    </div>

</body>
</html>
