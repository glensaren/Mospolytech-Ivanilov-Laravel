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

Route::get('/signin', [AuthController::class, 'registerForm'])->name('auth.registerForm');
Route::post('/signin', [AuthController::class, 'register'])->name('auth.register');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); 
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); 
Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Маршруты для комментариев
Route::middleware(['auth'])->group(function () {
    Route::get('/articles/{articleId}/comments', [CommentsController::class, 'index'])->name('comments.index');
    Route::post('/articles/{articleId}/comments', [CommentsController::class, 'store'])->name('comments.store');
    Route::put('/articles/{articleId}/comments/{commentId}', [CommentsController::class, 'update'])->name('comments.update');
    Route::delete('/articles/{articleId}/comments/{commentId}', [CommentsController::class, 'destroy'])->name('comments.destroy');
    Route::get('/articles/{articleId}/comments/{commentId}/functional', [CommentsController::class, 'checkFunctionalInterface'])->name('comments.functional');
});