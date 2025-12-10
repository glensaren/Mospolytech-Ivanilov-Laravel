<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

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