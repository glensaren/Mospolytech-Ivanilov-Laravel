@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Регистрация нового пользователя</h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        
                        <!-- Имя -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Введите ваше имя"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
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
                                   placeholder="Минимум 6 символов"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Подтверждение пароля -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля *</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Повторите пароль"
                                   required>
                        </div>
                        
                        <!-- Соглашение -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('agree') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="agree" 
                                       name="agree"
                                       {{ old('agree') ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="agree">
                                    Я согласен с <a href="#" class="text-decoration-none">условиями использования</a> *
                                </label>
                                @error('agree')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Кнопки -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Зарегистрироваться
                            </button>
                            <a href="{{ route('auth.loginForm') }}" class="btn btn-outline-secondary">
                                Уже есть аккаунт? Войти
                            </a>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-muted">
                    <small>* Обязательные для заполнения поля</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection