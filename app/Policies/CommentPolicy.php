<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Определить права пользователя на просмотр комментария
     */
    public function view(User $user, Comment $comment)
    {
        // Любой аутентифицированный пользователь может просматривать комментарий
        return true;
    }

    /**
     * Определить права пользователя на создание комментариев
     */
    public function create(User $user)
    {
        // Любой аутентифицированный пользователь может создавать комментарии
        return true;
    }

    /**
     * Определить права пользователя на обновление комментария
     */
    public function update(User $user, Comment $comment)
    {
        // Только автор комментария может его редактировать
        return $user->id === $comment->author_id;
    }

    /**
     * Определить права пользователя на удаление комментария
     */
    public function delete(User $user, Comment $comment)
    {
        // Только автор комментария или модератор может его удалить
        return $user->id === $comment->author_id || $user->role === 'moderator';
    }

    /**
     * Права на функциональный интерфейс - только автор комментария и модератор
     */
    public function functionalInterface(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id || $user->role === 'moderator';
    }
}