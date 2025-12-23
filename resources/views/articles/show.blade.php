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
                            <p><strong>URL изображения:</strong> {{ $article->preview_image }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Управление статьей</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Редактировать статью
                                </a>
                                
                                <form action="{{ route('articles.destroy', $article->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Удалить статью
                                    </button>
                                </form>
                                
                                <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Назад к списку
                                </a>
                                <a href="{{ route('articles.create') }}" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i> Создать новую статью
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-house"></i> На главную (JSON)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-muted">
            <small>Данные загружены из базы данных SQLite | 
                   <a href="{{ route('articles.edit', $article->id) }}" class="text-decoration-none">Редактировать</a> | 
                   <a href="{{ route('articles.index') }}" class="text-decoration-none">Все статьи</a>
            </small>
        </div>
    </div>
</div>
@endsection