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
    
    <!-- Пагинация -->
@if($articles->hasPages())
<div class="mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Предыдущая страница --}}
            @if($articles->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Назад</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $articles->previousPageUrl() }}" rel="prev">&laquo; Назад</a>
                </li>
            @endif

            {{-- Номера страниц --}}
            @foreach(range(1, $articles->lastPage()) as $page)
                @if($page == $articles->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $articles->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Следующая страница --}}
            @if($articles->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $articles->nextPageUrl() }}" rel="next">Вперед &raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Вперед &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
    
    <div class="text-center text-muted mt-2">
        Страница {{ $articles->currentPage() }} из {{ $articles->lastPage() }}
        (Показано {{ $articles->count() }} из {{ $articles->total() }} статей)
    </div>
</div>
@endif

    @else
    <div class="alert alert-warning">
        <h4 class="alert-heading">Статьи не найдены!</h4>
        <p>В базе данных нет статей.</p>
        <hr>
        <a href="{{ route('articles.create') }}" class="btn btn-success mt-2">
            <i class="bi bi-plus-circle"></i> Создать первую статью
        </a>
    </div>

    @endif
</div>
@endsection