<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ModeratorSeeder extends Seeder
{
    public function run()
    {
        // Создаем модератора
        User::create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
        ]);
    }
}