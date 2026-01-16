<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Отобразить список комментариев для статьи
     */
    public function index($articleId)
    {
        $article = Article::findOrFail($articleId);
        
        // Проверяем права - аутентифицированный пользователь может просматривать статью
        abort_if(!Auth::check(), 403, 'Доступ запрещен');
        
        $comments = $article->comments()->with('author')->get();
        
        return response()->json($comments);
    }

    /**
     * Добавить новый комментарий к статье
     */
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $article = Article::findOrFail($articleId);
        
        // Проверяем права - аутентифицированный пользователь может создавать комментарии
        abort_if(!Auth::check(), 403, 'Доступ запрещен');

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->article_id = $article->id;
        $comment->author_id = Auth::id();
        $comment->save();

        return response()->json($comment->load('author'), 201);
    }

    /**
     * Обновить комментарий
     */
    public function update(Request $request, $articleId, $commentId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::where('article_id', $articleId)->findOrFail($commentId);

        // Проверяем права - только автор комментария может его редактировать
        $this->authorize('update', $comment);

        $comment->update(['content' => $request->content]);

        return response()->json($comment);
    }

    /**
     * Удалить комментарий
     */
    public function destroy($articleId, $commentId)
    {
        $comment = Comment::where('article_id', $articleId)->findOrFail($commentId);

        // Проверяем права - только автор комментария или модератор может его удалить
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(['message' => 'Комментарий успешно удален']);
    }

    /**
     * Проверить доступ к функциональному интерфейсу
     */
    public function checkFunctionalInterface($articleId, $commentId)
    {
        $comment = Comment::where('article_id', $articleId)->findOrFail($commentId);

        // Проверяем права через шлюз - только автор комментария или модератор
        $this->authorize('functional-interface', $comment);

        return response()->json(['message' => 'Доступ к функциональному интерфейсу разрешен']);
    }
}