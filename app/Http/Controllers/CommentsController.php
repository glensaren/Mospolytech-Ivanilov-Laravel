<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

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
        try {
            $this->authorize('update', $comment);
        } catch (AuthorizationException $e) {
            abort(403, 'У вас нет прав для редактирования этого комментария.');
        }

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
        try {
            $this->authorize('delete', $comment);
        } catch (AuthorizationException $e) {
            abort(403, 'У вас нет прав для удаления этого комментария.');
        }

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
        try {
            $this->authorize('functional-interface', $comment);
        } catch (AuthorizationException $e) {
            abort(403, 'У вас нет прав для доступа к функциональному интерфейсу.');
        }

        return response()->json(['message' => 'Доступ к функциональному интерфейсу разрешен']);
    }
}