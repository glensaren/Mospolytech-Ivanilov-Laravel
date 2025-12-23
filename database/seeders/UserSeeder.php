<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем тестового пользователя
        User::create([
            'name' => 'Тестовый Пользователь',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);
        
        // Создаем еще нескольких пользователей
        User::factory()->count(5)->create();
        
        $this->command->info('Создано 6 пользователей!');
    }
}