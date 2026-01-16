<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Проверить, может ли пользователь просматривать список статей
     */
    public function viewAny(User $user)
    {
        return true; // Любой пользователь может просматривать список статей
    }

    /**
     * Проверить, может ли пользователь просматривать конкретную статью
     */
    public function view(User $user, Article $article)
    {
        return true; // Любой пользователь может просматривать конкретную статью
    }

    /**
     * Проверить, может ли пользователь создавать статьи
     */
    public function create(User $user)
    {
        return $user->role === 'moderator';
    }

    /**
     * Проверить, может ли пользователь обновлять статью
     */
    public function update(User $user, Article $article)
    {
        return $user->role === 'moderator';
    }

    /**
     * Проверить, может ли пользователь удалять статью
     */
    public function delete(User $user, Article $article)
    {
        return $user->role === 'moderator';
    }

    /**
     * Проверить, может ли пользователь восстанавливать статью
     */
    public function restore(User $user, Article $article)
    {
        return $user->role === 'moderator';
    }

    /**
     * Проверить, может ли пользователь перманентно удалять статью
     */
    public function forceDelete(User $user, Article $article)
    {
        return $user->role === 'moderator';
    }
}