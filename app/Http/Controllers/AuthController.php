<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // ... валидация как раньше ...
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Sanctum: создаем токен при регистрации (опционально)
        // $token = $user->createToken('auth-token')->plainTextToken;
        // $request->session()->put('sanctum_token', $token);

        return redirect()->route('auth.loginForm')
            ->with('success', 'Регистрация успешно завершена!');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ... валидация ...
        
        if (Auth::attempt($credentials, $remember)) {
            // Sanctum: создаем токен
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;
            
            // Сохраняем токен в сессии
            $request->session()->put('sanctum_token', $token);
            
            $request->session()->regenerate();
            
            return redirect()->route('home')
                ->with('success', 'Вы успешно вошли в систему!')
                ->withCookie(cookie('sanctum_token', $token, 60 * 24 * 30)); // Кука на 30 дней
        }

        return back()->withErrors(['email' => 'Неверный email или пароль']);
    }

    public function logout(Request $request)
    {
        // Sanctum: удаляем все токены пользователя
        if (Auth::check()) {
            $request->user()->tokens()->delete();
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Удаляем куку с токеном
        $cookie = cookie()->forget('sanctum_token');
        
        return redirect()->route('home')
            ->with('success', 'Вы успешно вышли из системы.')
            ->withCookie($cookie);
    }
    
    // Для совместимости
    public function create() { return $this->registerForm(); }
    public function registration(Request $request) { return $this->register($request); }
}