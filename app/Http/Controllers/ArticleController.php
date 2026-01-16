<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('publication_date', 'desc')
            ->paginate(9);
        
        $stats = [
            'total' => Article::count(),
            'published' => Article::where('is_published', true)->count(),
            'categories' => Article::select('category')->distinct()->get()->pluck('category')->toArray(),
            'total_views' => Article::sum('views_count'),
        ];
        
        return view('articles.index', compact('articles', 'stats'));
    }

    public function create()
    {
        // Проверяем права пользователя на создание статьи
        $this->authorize('create', Article::class);
        
        $categories = ['Технологии', 'Наука', 'Образование', 'Культура', 'Спорт', 'Политика', 'Экономика', 'Здоровье'];
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Проверяем права пользователя на создание статьи
        $this->authorize('create', Article::class);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'short_description' => 'nullable|max:500',
            'author' => 'required|min:2|max:100',
            'publication_date' => 'required|date',
            'category' => 'required|string|max:50',
            'preview_image' => 'nullable|string|max:255',
            'is_published' => 'boolean'
        ], [
            'title.required' => 'Заголовок обязателен для заполнения',
            'title.min' => 'Заголовок должен содержать минимум 3 символа',
            'title.max' => 'Заголовок должен содержать максимум 255 символов',
            'content.required' => 'Содержание статьи обязательно',
            'content.min' => 'Содержание должно содержать минимум 10 символов',
            'author.required' => 'Имя автора обязательно',
            'author.min' => 'Имя автора должно содержать минимум 2 символа',
            'publication_date.required' => 'Дата публикации обязательна',
            'publication_date.date' => 'Укажите корректную дату',
            'category.required' => 'Выберите категорию'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'short_description' => $request->short_description ?? Str::limit($request->content, 150),
            'author' => $request->author,
            'publication_date' => $request->publication_date,
            'category' => $request->category,
            'preview_image' => $request->preview_image ?? 'preview.jpg',
            'is_published' => $request->has('is_published'),
            'views_count' => 0
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Статья успешно создана!');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('views_count');
        
        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        
        // Проверяем права пользователя на редактирование статьи
        $this->authorize('update', $article);
        
        $categories = ['Технологии', 'Наука', 'Образование', 'Культура', 'Спорт', 'Политика', 'Экономика', 'Здоровье'];
        
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        
        // Проверяем права пользователя на обновление статьи
        $this->authorize('update', $article);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'short_description' => 'nullable|max:500',
            'author' => 'required|min:2|max:100',
            'publication_date' => 'required|date',
            'category' => 'required|string|max:50',
            'preview_image' => 'nullable|string|max:255',
            'is_published' => 'boolean'
        ], [
            'title.required' => 'Заголовок обязателен для заполнения',
            'title.min' => 'Заголовок должен содержать минимум 3 символа',
            'content.required' => 'Содержание статьи обязательно',
            'content.min' => 'Содержание должно содержать минимум 10 символов',
            'author.required' => 'Имя автора обязательно',
            'publication_date.required' => 'Дата публикации обязательна'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'short_description' => $request->short_description ?? Str::limit($request->content, 150),
            'author' => $request->author,
            'publication_date' => $request->publication_date,
            'category' => $request->category,
            'preview_image' => $request->preview_image ?? $article->preview_image,
            'is_published' => $request->has('is_published')
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Статья успешно обновлена!');
    }
    
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        // Проверяем права пользователя на удаление статьи
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно удалена!');
    }
}