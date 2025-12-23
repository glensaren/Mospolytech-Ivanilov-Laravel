<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RitenRid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">RitenRid</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Главная</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('contacts') ? 'active' : '' }}" href="/contacts">Контакты</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('articles*') ? 'active' : '' }}" href="{{ route('articles.index') }}">
                                    Новости (БД)
                                </a>
                            </li>

                            <!-- АУТЕНТИФИКАЦИЯ: ЭТОТ БЛОК ЗАМЕНИТЬ -->
                            @auth
                            <!-- Для авторизованных пользователей -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('articles.create') }}">Создать статью</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Выйти</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <!-- Для неавторизованных пользователей -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('auth.loginForm') }}">
                                    Вход
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('register', 'signin') ? 'active' : '' }}" href="{{ route('auth.registerForm') }}">
                                    Регистрация
                                </a>
                            </li>
                            @endauth
                            <!-- КОНЕЦ БЛОКА АУТЕНТИФИКАЦИИ -->
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <footer class="bg-light text-dark mt-5 py-3 border-top">
        <div class="container text-center">
            <p class="mb-0">
                Иванилов Алексей Тимофеевич , группа 241-321
            </p>
            <small>© {{ date('Y') }} Все права защищены</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>