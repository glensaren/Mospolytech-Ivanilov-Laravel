<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        \App\Models\Article::truncate();
        
        $this->call([
            RoleSeeder::class,
            ArticleSeeder::class,
            UserSeeder::class,
            ModeratorSeeder::class,
        ]);
    }
}