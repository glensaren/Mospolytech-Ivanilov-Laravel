<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles from database
     */
    public function index()
    {
        // Получаем только опубликованные статьи, отсортированные по дате
        $articles = Article::where('is_published', true)
            ->orderBy('publication_date', 'desc')
            ->paginate(9);
        
        // Получаем статистику
        $stats = [
            'total' => Article::count(),
            'published' => Article::where('is_published', true)->count(),
            'categories' => Article::select('category')->distinct()->get()->pluck('category')->toArray(),
            'total_views' => Article::sum('views_count'),
        ];
        
        return view('articles.index', compact('articles', 'stats'));
    }

    /**
     * Display the specified article
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        
        // Увеличиваем счетчик просмотров
        $article->increment('views_count');
        
        return view('articles.show', compact('article'));
    }
}