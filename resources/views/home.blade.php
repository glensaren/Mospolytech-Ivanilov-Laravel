@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4">Добро пожаловать!</h1>
    <p class="lead">Это главная страница нашего сайта</p>
    <div class="mt-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Новость 1</h5>
                        <p class="card-text">Здесь будет первая новость сайта. В будущем новости будут загружаться из базы данных.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Новость 2</h5>
                        <p class="card-text">Здесь будет вторая новость. Мы используем Laravel Blade для шаблонов.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Новость 3</h5>
                        <p class="card-text">Здесь будет третья новость. Маршрутизация настроена в routes/web.php</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection