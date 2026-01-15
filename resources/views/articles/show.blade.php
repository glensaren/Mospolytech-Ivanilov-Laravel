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
     
            @if($article->preview_image)
            <div class="text-center mb-4">
                <img src="{{ asset($article->preview_image) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $article->title }}"
                     style="max-height: 400px;">
            </div>
            @endif
            
            @if($article->short_description)
            <div class="alert alert-info">
                <h5>Краткое описание:</h5>
                <p class="mb-0">{{ $article->short_description }}</p>
            </div>
            @endif

            <div class="article-content mt-4">
                <h4>Содержание:</h4>
                <div class="content-box p-3 border rounded bg-light">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
            
                        <div class="comments-section mt-5 pt-4 border-top">
                <h3 class="mb-4">
                    <i class="bi bi-chat-left-text"></i> Комментарии 
                    <span class="badge bg-primary">{{ $article->comments->count() }}</span>
                </h3>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Форма добавления комментария -->
                @auth
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Добавить комментарий</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('comments.store', $article->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Ваш комментарий:</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                         name="content" 
                                         id="content"
                                         rows="4" 
                                         placeholder="Напишите ваш комментарий здесь..."
                                         required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Отправить комментарий
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    <a href="{{ route('auth.loginForm') }}" class="alert-link">Войдите</a> или 
                    <a href="{{ route('auth.registerForm') }}" class="alert-link">зарегистрируйтесь</a>, 
                    чтобы оставлять комментарии
                </div>
                @endauth
                
                <!-- Список комментариев -->
                @if($article->comments->count() > 0)
                    @foreach($article->comments as $comment)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex">
                                <!-- Аватар пользователя -->
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                {{ $comment->user->name ?? 'Пользователь' }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i> 
                                                {{ $comment->created_at->format('d.m.Y H:i') }}
                                            </small>
                                        </div>
                                        
                                        @if(Auth::check() && Auth::id() == $comment->user_id)
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('comments.edit', ['article' => $article->id, 'comment' => $comment->id]) }}" 
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            <form action="{{ route('comments.destroy', ['article' => $article->id, 'comment' => $comment->id]) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Удалить этот комментарий?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <p class="mb-0">{{ $comment->content }}</p>
                                    
                                    <!-- Кнопка "Ответить" (опционально) -->
                                    <!-- <button class="btn btn-link btn-sm p-0 mt-2">Ответить</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="text-center py-4">
                    <i class="bi bi-chat-left" style="font-size: 3rem; color: #dee2e6;"></i>
                    <p class="text-muted mt-2">Комментариев пока нет. Будьте первым!</p>
                </div>
                @endif
            </div>

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