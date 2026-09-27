<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PostAdmController extends Controller
{
    public function create()
    {
        return view('adm.posts.create');

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Altere de 'max=255' para 'max:255'
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string',
            'conteudo' => 'required|string',
            'slug' => 'nullable|string|unique:posts,slug',
        ]);
        // Se o usuário não digitou o slug, o Laravel gera a partir do título automaticamente
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['titulo']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Garante que o slug permaneça único no banco
        $checkSlug = Post::where('slug', $data['slug'])->exists();
        if ($checkSlug) {
            return redirect()->back()->withInput()->withErrors(['slug' => 'Este título ou slug já está sendo usado por outra notícia!']);
        }

        Post::create($data);

        return redirect()->route('public.guianutricional')->with('success', 'Nova notícia publicada com sucesso!');
    }
}
