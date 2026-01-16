<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\Article;
use App\Policies\CommentPolicy;
use App\Policies\ArticlePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Comment::class => CommentPolicy::class,
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Глобальный шлюз для модератора - проверяется первым
        Gate::before(function ($user, $ability) {
            if ($user->role === 'moderator') {
                return true;
            }
        });

        // Регистрация шлюза для функционального интерфейса
        Gate::define('functional-interface', function ($user, $comment) {
            return $user->id === $comment->author_id || $user->role === 'moderator';
        });
    }
}