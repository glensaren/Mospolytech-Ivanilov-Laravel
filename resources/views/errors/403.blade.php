@extends('layouts.app')

@section('title', 'Доступ запрещен')

@section('content')
<div class="container py-5 text-center">
    <h1 class="display-1 text-danger">403</h1>
    <h2 class="mb-4">Доступ запрещен</h2>
    <p class="lead mb-4">У вас нет прав для доступа к этой странице.</p>
    
    @auth
    <div class="alert alert-info">
        <p>Вы вошли как: <strong>{{ Auth::user()->name }}</strong></p>
    </div>
    @endauth
    
    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-primary">На главную</a>
        @guest
        <a href="{{ route('auth.loginForm') }}" class="btn btn-success">Войти в систему</a>
        @endguest
    </div>
</div>
@endsection