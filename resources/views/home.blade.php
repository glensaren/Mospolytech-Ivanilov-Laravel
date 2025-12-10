@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4">Добро пожаловать!</h1>
    <p class="lead">Это главная страница нашего сайта. Статьи загружаются из JSON файла.</p>
    
    @if(empty($articles))
    <div class="alert alert-warning mt-4">
        <p>Статьи не найдены. Проверьте наличие файла articles.json</p>
    </div>
    @else
    <div class="mt-5">
        <div class="row">
            @foreach($articles as $article)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    @if($article['preview_image'])
                    <a href="{{ route('gallery.show', $article['id']) }}">
                        <img src="{{ asset($article['preview_image']) }}" 
                             class="card-img-top" 
                             alt="{{ $article['name'] }}"
                             style="height: 200px; object-fit: cover;">
                    </a>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $article['name'] }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $article['date'] }}
                        </h6>
                        <p class="card-text">
                            {{ $article['shortDesc'] ?? substr($article['desc'], 0, 150) . '...' }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Статья #{{ $article['id'] }}</small>
                            <a href="{{ route('gallery.show', $article['id']) }}" class="btn btn-sm btn-primary">
                                Читать далее
                            </a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Дата: {{ $article['date'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        
    </div>
    
    <div class="row mt-5">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h4>{{ count($articles) }}</h4>
                    <p class="card-text">Всего статей</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    @php
                        // Подсчет уникальных месяцев
                        $months = [];
                        foreach ($articles as $article) {
                            $date = DateTime::createFromFormat('d.m.Y', $article['date']);
                            if ($date) {
                                $months[] = $date->format('m.Y');
                            }
                        }
                        $uniqueMonths = count(array_unique($months));
                    @endphp
                    <h4>{{ $uniqueMonths }}</h4>
                    <p class="card-text">Месяцев публикаций</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    @php
                        // Подсчет общего количества символов
                        $totalChars = 0;
                        foreach ($articles as $article) {
                            $totalChars += strlen($article['desc'] ?? '');
                        }
                    @endphp
                    <h4>{{ number_format($totalChars) }}</h4>
                    <p class="card-text">Символов текста</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    @php
                        // Самая длинная и короткая статья
                        $longest = 0;
                        $shortest = PHP_INT_MAX;
                        foreach ($articles as $article) {
                            $length = strlen($article['desc'] ?? '');
                            if ($length > $longest) $longest = $length;
                            if ($length < $shortest) $shortest = $length;
                        }
                    @endphp
                    <h6>{{ number_format($longest) }}</h6>
                    <p class="card-text">Символов в самой длинной</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection