<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'reader',
            'description' => 'Читатель - может просматривать новости и добавлять комментарии'
        ]);

        Role::create([
            'name' => 'moderator',
            'description' => 'Модератор - может выполнять все действия'
        ]);
    }
}