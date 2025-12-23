@extends('layouts.app')

@section('title', 'Новости из базы данных')

@section('content')
<div class="container py-5">
    <!-- Заголовок и кнопка создания -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Новости из базы данных</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Создать статью
        </a>
    </div>
    
    <!-- Статистика -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h4>{{ $stats['total'] }}</h4>
                    <p class="card-text">Всего статей</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h4>{{ $stats['published'] }}</h4>
                    <p class="card-text">Опубликовано</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <h4>{{ count($stats['categories']) }}</h4>
                    <p class="card-text">Категорий</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h4>{{ number_format($stats['total_views']) }}</h4>
                    <p class="card-text">Всего просмотров</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Список статей -->
    @if($articles->count() > 0)
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($article->preview_image)
                <a href="{{ route('articles.show', $article->id) }}">
                    <img src="{{ asset($article->preview_image) }}" 
                         class="card-img-top" 
                         alt="{{ $article->title }}"
                         style="height: 200px; object-fit: cover;">
                </a>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        <span class="badge bg-primary">{{ $article->category }}</span>
                        • {{ $article->formatted_date }}
                    </h6>
                    <p class="card-text">
                        {{ $article->short_description ?? Str::limit($article->content, 150) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Автор: {{ $article->author }}</small>
                        <span class="badge bg-secondary">
                            <i class="bi bi-eye"></i> {{ $article->views_count }}
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> Просмотр
                        </a>
                        <div>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('articles.destroy', $article->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Удалить статью?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if(!$article->is_published)
                    <span class="badge bg-warning float-end mt-2">Черновик</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Пагинация -->
    <div class="mt-4">
        {{ $articles->links() }}
    </div>

    <!-- Таблица статей -->
    <div class="mt-5">
        <h3 class="mb-4">Таблица статей из базы данных</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Категория</th>
                        <th>Автор</th>
                        <th>Дата</th>
                        <th>Просмотры</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td><strong>{{ Str::limit($article->title, 40) }}</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $article->category }}</span>
                        </td>
                        <td>{{ $article->author }}</td>
                        <td>{{ $article->formatted_date }}</td>
                        <td>{{ $article->views_count }}</td>
                        <td>
                            @if($article->is_published)
                            <span class="badge bg-success">Опубликовано</span>
                            @else
                            <span class="badge bg-warning">Черновик</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('articles.show', $article->id) }}" 
                                   class="btn btn-info" title="Просмотр">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('articles.edit', $article->id) }}" 
                                   class="btn btn-warning" title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('articles.destroy', $article->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    @else
    <div class="alert alert-warning">
        <h4 class="alert-heading">Статьи не найдены!</h4>
        <p>В базе данных нет статей. Запустите сидер для заполнения фейковыми данными:</p>
        <code>php artisan db:seed</code>
        <hr>
        <a href="{{ route('articles.create') }}" class="btn btn-success mt-2">
            <i class="bi bi-plus-circle"></i> Создать первую статью
        </a>
    </div>
    @endif
</div>
@endsection