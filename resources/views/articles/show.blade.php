@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Новости (БД)</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 30) }}</li>
        </ol>
    </nav>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">{{ $article->title }}</h1>
                <span class="badge bg-light text-dark">
                    <i class="bi bi-eye"></i> {{ $article->views_count }} просмотров
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Мета-информация -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Автор:</strong> {{ $article->author }}</p>
                    <p><strong>Дата публикации:</strong> {{ $article->formatted_date }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Категория:</strong> <span class="badge bg-primary">{{ $article->category }}</span></p>
                    <p><strong>Статус:</strong> 
                        @if($article->is_published)
                        <span class="badge bg-success">Опубликовано</span>
                        @else
                        <span class="badge bg-warning">Черновик</span>
                        @endif
                    </p>
                </div>
            </div>
            
            <!-- Изображение -->
            @if($article->preview_image)
            <div class="text-center mb-4">
                <img src="{{ asset($article->preview_image) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $article->title }}"
                     style="max-height: 400px;">
            </div>
            @endif
            
            <!-- Краткое описание -->
            @if($article->short_description)
            <div class="alert alert-info">
                <h5>Краткое описание:</h5>
                <p class="mb-0">{{ $article->short_description }}</p>
            </div>
            @endif
            
            <!-- Полное содержание -->
            <div class="article-content mt-4">
                <h4>Содержание:</h4>
                <div class="content-box p-3 border rounded bg-light">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
            
            <!-- Дополнительная информация -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Информация о статье</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>ID:</strong> {{ $article->id }}</p>
                            <p><strong>Создана:</strong> {{ $article->created_at->format('d.m.Y H:i') }}</p>
                            <p><strong>Обновлена:</strong> {{ $article->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Действия</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Назад к списку
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="bi bi-house"></i> На главную (JSON)
                                </a>
                                <button class="btn btn-info" onclick="alert('Функция редактирования в разработке')">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-muted">
            <small>Данные загружены из базы данных MySQL</small>
        </div>
    </div>
</div>
@endsection