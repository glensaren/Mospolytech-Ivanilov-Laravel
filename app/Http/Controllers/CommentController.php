<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Сохранить новый комментарий
     */
    public function store(Request $request, Article $article)
    {
        // Валидация данных
        $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        // Создаем комментарий
        $comment = $article->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Редирект обратно к статье с сообщением об успехе
        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Комментарий успешно добавлен');
    }

    /**
     * Показать форму редактирования комментария
     */
    public function edit(Article $article, Comment $comment)
    {
        // Проверяем, что комментарий принадлежит статье
        if ($comment->article_id !== $article->id) {
            abort(404, 'Комментарий не найден для данной статьи');
        }

        // Проверяем права пользователя
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого комментария');
        }

        return view('comments.edit', compact('article', 'comment'));
    }

    /**
     * Обновить комментарий
     */
    public function update(Request $request, Article $article, Comment $comment)
    {
        // Проверяем, что комментарий принадлежит статье
        if ($comment->article_id !== $article->id) {
            abort(404, 'Комментарий не найден для данной статьи');
        }

        // Проверяем права пользователя
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого комментария');
        }

        // Валидация данных
        $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        // Обновляем комментарий
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Комментарий успешно обновлен');
    }

    /**
     * Удалить комментарий
     */
    public function destroy(Article $article, Comment $comment)
    {
        // Проверяем, что комментарий принадлежит статье
        if ($comment->article_id !== $article->id) {
            abort(404, 'Комментарий не найден для данной статьи');
        }

        // Проверяем права пользователя (автор комментария или автор статьи)
        $isArticleAuthor = $article->user_id === Auth::id(); // если есть связь с автором статьи
        $isCommentAuthor = $comment->user_id === Auth::id();
        
        if (!$isCommentAuthor && !$isArticleAuthor) {
            abort(403, 'У вас нет прав для удаления этого комментария');
        }

        // Удаляем комментарий
        $comment->delete();

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Комментарий успешно удален');
    }
}