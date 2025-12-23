<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    /**
     * Показывает форму регистрации
     */
    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Обрабатывает регистрацию пользователя
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:50|regex:/^[а-яА-ЯёЁa-zA-Z\s]+$/u',
            'email' => 'required|email|max:100|unique:users',
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
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',
            
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
            'password.max' => 'Пароль должен содержать максимум 50 символов',
            'password.confirmed' => 'Пароли не совпадают',
            
            'password_confirmation.required' => 'Повторите пароль',
            
            'agree.required' => 'Вы должны принять условия соглашения',
            'agree.accepted' => 'Вы должны принять условия соглашения'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Создаем пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('auth.loginForm')
            ->with('success', 'Регистрация успешно завершена! Теперь вы можете войти в систему.');
    }

    /**
     * Показывает форму авторизации
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Обрабатывает авторизацию пользователя
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable|boolean'
        ], [
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Попытка аутентификации
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Создаем токен Sanctum
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;
            
            // Сохраняем токен в сессии
            $request->session()->put('auth_token', $token);
            
            // Редирект на главную с сообщением
            return redirect()->route('home')
                ->with('success', 'Вы успешно вошли в систему!')
                ->withCookie(cookie('sanctum_token', $token, 60 * 24 * 30)); // Кука на 30 дней
        }

        return redirect()->back()
            ->withErrors(['email' => 'Неверный email или пароль'])
            ->withInput();
    }

    /**
     * Выход пользователя из системы
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            // Удаляем все токены текущего пользователя
            $request->user()->tokens()->delete();
            
            // Выход из системы
            Auth::logout();
            
            // Очищаем сессию
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Удаляем куку
            $cookie = cookie()->forget('sanctum_token');
            
            return redirect()->route('home')
                ->with('success', 'Вы успешно вышли из системы.')
                ->withCookie($cookie);
        }
        
        return redirect()->route('home');
    }
}