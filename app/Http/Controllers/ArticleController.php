<?php

namespace App\Http\Controllers; // Исправлен namespace!

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(9);
    
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
        'Технологии',
        'Наука',
        'Спорт',
        'Политика',
        'Культура',
        'Экономика',
        'Здоровье',
        'Образование',
        'Развлечения',
        'Другое'
    ];
    
    return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'short_description' => 'nullable|string|max:500',
        'publication_date' => 'required|date',
        'category' => 'required|string|max:100',
        'preview_image' => 'nullable|string|max:255',
        'is_published' => 'boolean',
    ]);

    $validated['author'] = auth()->user()->name;
    
    Article::create($validated);

    return redirect()->route('articles.index')
        ->with('success', 'Статья успешно создана!');
}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::with(['comments.user'])->findOrFail($id);
        $article->increment('views_count');
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'publication_date' => 'required|date',
            'category' => 'required|string|max:100',
            'preview_image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Статья успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно удалена!');
    }
}