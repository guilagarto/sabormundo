<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    // Lista todos os 48 países no painel administrativo
    public function index()
    {
        $paises = Pais::orderBy('nome', 'asc')->paginate(15);
        return view('adm.paises.index', compact('paises'));
    }

    // Abre o formulário de edição de curiosidades do país escolhido
    public function edit($id)
    {
        $pais = Pais::findOrFail($id);
        return view('adm.paises.edit', compact('pais'));
    }

    // Grava a curiosidade/descrição atualizada no banco sabor_db
    public function update(Request $request, $id)
    {
        $pais = Pais::findOrFail($id);

        $validated = $request->validate([
            'descricao' => 'nullable|string',
        ]);

        $pais->update([
            'descricao' => $validated['descricao']
        ]);

        return redirect()->route('adm.paises.index')->with('success', "Curiosidades de {$pais->nome} atualizadas com sucesso!");
    }
}
