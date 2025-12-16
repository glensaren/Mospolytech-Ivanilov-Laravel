@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Форма регистрации</h4>
                </div>
                
                <div class="card-body">
                    <!-- Форма регистрации -->
                    <form id="registrationForm" method="POST" action="{{ route('auth.registration') }}">
                        @csrf <!-- CSRF токен -->
                        
                        <!-- Поле: Имя -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Введите ваше имя">
                            <div class="invalid-feedback" id="name-error"></div>
                            <small class="form-text text-muted">Только буквы и пробелы (2-50 символов)</small>
                        </div>
                        
                        <!-- Поле: Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="example@mail.com">
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>
                        
                        <!-- Поле: Пароль -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль *</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Минимум 6 символов">
                            <div class="invalid-feedback" id="password-error"></div>
                        </div>
                        
                        <!-- Поле: Подтверждение пароля -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля *</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Повторите пароль">
                            <div class="invalid-feedback" id="password_confirmation-error"></div>
                        </div>
                        
                        <!-- Чекбокс соглашения -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('agree') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="agree" 
                                       name="agree"
                                       {{ old('agree') ? 'checked' : '' }}>
                                <label class="form-check-label" for="agree">
                                    Я согласен с <a href="#" class="text-decoration-none">условиями использования</a> *
                                </label>
                                <div class="invalid-feedback" id="agree-error"></div>
                            </div>
                        </div>
                        
                        <!-- Кнопка отправки -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <span id="submit-text">Зарегистрироваться</span>
                                <span id="loading-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-muted">
                    <small>* Обязательные для заполнения поля</small>
                    <br>
                    <small>Все поля защищены CSRF-токеном: <code id="csrf-token-short">{{ substr(session()->token(), 0, 10) }}...</code></small>
                </div>
            </div>
            
            <!-- Блок для отображения результата -->
            <div id="result-container" class="mt-4 d-none">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Результат регистрации (JSON ответ)</h5>
                    </div>
                    <div class="card-body">
                        <pre id="json-result" class="bg-light p-3 border rounded" style="max-height: 300px; overflow-y: auto;"></pre>
                    </div>
                </div>
            </div>
            
            <!-- Пример валидных данных -->
            <div class="mt-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Пример данных для тестирования:</h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <strong>Имя:</strong> Иван Иванов<br>
                            <strong>Email:</strong> test@example.com<br>
                            <strong>Пароль:</strong> 123456<br>
                            <strong>Подтверждение:</strong> 123456<br>
                            <strong>Соглашение:</strong> ✓
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection