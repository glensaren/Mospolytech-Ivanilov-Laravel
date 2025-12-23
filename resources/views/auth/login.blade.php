@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Вход в систему</h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="example@mail.com"
                                   required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Пароль -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль *</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Введите пароль"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Запомнить меня -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="remember" 
                                       name="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>
                        
                        <!-- Кнопки -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                Войти
                            </button>
                            <a href="{{ route('auth.registerForm') }}" class="btn btn-outline-primary">
                                Нет аккаунта? Зарегистрироваться
                            </a>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-muted">
                    <small>Используется аутентификация через Laravel Sanctum</small>
                </div>
            </div>
            
            <!-- Тестовые данные -->
            <div class="mt-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Тестовые данные для входа:</h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <strong>Email:</strong> test@example.com<br>
                            <strong>Пароль:</strong> password123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection