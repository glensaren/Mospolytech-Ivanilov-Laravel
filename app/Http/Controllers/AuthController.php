<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function create()
    {
        return view('auth.signin');
    }


    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:50|regex:/^[а-яА-ЯёЁa-zA-Z\s]+$/u',
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required',
            'agree' => 'required|accepted'
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'name.min' => 'Имя должно содержать минимум 2 символа',
            'name.max' => 'Имя должно содержать максимум 50 символов',
            'name.regex' => 'Имя может содержать только буквы и пробелы',
            
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'email.max' => 'Email должен содержать максимум 100 символов',
            
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
            'password.max' => 'Пароль должен содержать максимум 50 символов',
            'password.confirmed' => 'Пароли не совпадают',
            
            'password_confirmation.required' => 'Повторите пароль',
            
            'agree.required' => 'Вы должны принять условия соглашения',
            'agree.accepted' => 'Вы должны принять условия соглашения'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
                'data' => null
            ], 422);
        }

        $userData = [
            'id' => rand(1000, 9999),
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // В реальном приложении нужно хешировать!
            'registered_at' => date('d.m.Y H:i:s'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent')
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Регистрация успешно завершена!',
            'data' => $userData,
            'csrf_token' => $request->session()->token(), // Возвращаем новый CSRF токен
            'redirect_url' => route('home')
        ], 200);
    }
}