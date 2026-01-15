<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();
        
        foreach ($articles as $article) {
            Comment::factory(rand(2, 5))->create([
                'article_id' => $article->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}