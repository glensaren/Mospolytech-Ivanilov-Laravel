<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/gallery/{id}', [HomeController::class, 'gallery'])->name('gallery.show');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    $contacts = [
        [
            'title' => 'Телефон',
            'value' => '+7 (999) 123-45-67',
            'type' => 'Основной',
            'description' => 'Звонки принимаются с 9:00 до 18:00'
        ],
        [
            'title' => 'Email',
            'value' => 'info@example.com',
            'type' => 'Для общих вопросов',
            'description' => 'Отвечаем в течение 24 часов'
        ],
        [
            'title' => 'Техническая поддержка',
            'value' => 'support@example.com',
            'type' => 'Технические вопросы',
            'description' => 'Круглосуточно'
        ],
        [
            'title' => 'Адрес офиса',
            'value' => 'г. Москва, ул. Примерная, д. 123',
            'type' => 'Физический адрес',
            'description' => 'Пн-Пт: 9:00-18:00'
        ],
        [
            'title' => 'VK',
            'value' => 'vk.com/ourcompany',
            'type' => 'Социальная сеть',
            'description' => 'Новости и анонсы'
        ],
        [
            'title' => 'Telegram',
            'value' => '@ourcompany',
            'type' => 'Мессенджер',
            'description' => 'Быстрая связь'
        ]
    ];
    
    return view('contacts', ['contacts' => $contacts]);
})->name('contacts');

Route::get('/signin', [AuthController::class, 'create'])->name('auth.create');
Route::post('/signin', [AuthController::class, 'registration'])->name('auth.registration');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); 
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); 
Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');