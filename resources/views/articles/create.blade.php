@extends('layouts.app')

@section('title', 'Создание новой статьи')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Создание новой статьи</h1>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Новости (БД)</a></li>
            <li class="breadcrumb-item active">Создание статьи</li>
        </ol>
    </nav>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Форма создания статьи</h5>
        </div>
        
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <h5>Ошибки валидации:</h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('articles.store') }}">
                @csrf
                
                <div class="row">
                    <!-- Заголовок -->
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Заголовок *</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               placeholder="Введите заголовок статьи"
                               required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Краткое описание -->
                    <div class="col-md-12 mb-3">
                        <label for="short_description" class="form-label">Краткое описание</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" 
                                  name="short_description" 
                                  rows="2"
                                  placeholder="Краткое описание статьи (до 500 символов)">{{ old('short_description') }}</textarea>
                        <div class="form-text">Необязательное поле. Если оставить пустым, будет сгенерировано автоматически.</div>
                        @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Содержание -->
                    <div class="col-md-12 mb-3">
                        <label for="content" class="form-label">Содержание статьи *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="8"
                                  placeholder="Основное содержание статьи"
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Автор -->
                    <div class="col-md-6 mb-3">
                        <label for="author" class="form-label">Автор *</label>
                        <input type="text" 
                               class="form-control @error('author') is-invalid @enderror" 
                               id="author" 
                               name="author" 
                               value="{{ old('author') }}"
                               placeholder="Имя автора"
                               required>
                        @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Дата публикации -->
                    <div class="col-md-6 mb-3">
                        <label for="publication_date" class="form-label">Дата публикации *</label>
                        <input type="date" 
                               class="form-control @error('publication_date') is-invalid @enderror" 
                               id="publication_date" 
                               name="publication_date" 
                               value="{{ old('publication_date', date('Y-m-d')) }}"
                               required>
                        @error('publication_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Категория -->
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Категория *</label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" 
                                name="category"
                                required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Изображение -->
                    <div class="col-md-6 mb-3">
                        <label for="preview_image" class="form-label">Изображение превью</label>
                        <select class="form-select @error('preview_image') is-invalid @enderror" 
                                id="preview_image" 
                                name="preview_image">
                            <option value="">Выберите изображение</option>
                            <option value="preview.jpg" {{ old('preview_image') == 'preview.jpg' ? 'selected' : '' }}>Изображение 1 (preview.jpg)</option>
                            <option value="preview_2.jpg" {{ old('preview_image') == 'preview_2.jpg' ? 'selected' : '' }}>Изображение 2 (preview_2.jpg)</option>
                        </select>
                        <div class="form-text">Необязательное поле. Если не выбрать, будет использовано изображение по умолчанию.</div>
                        @error('preview_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Статус публикации -->
                    <div class="col-md-12 mb-4">
                        <div class="form-check">
                            <input class="form-check-input @error('is_published') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1" 
                                   {{ old('is_published') ? 'checked' : 'checked' }}>
                            <label class="form-check-label" for="is_published">
                                Опубликовать статью сразу
                            </label>
                            @error('is_published')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Кнопки -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад к списку
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Создать статью
                    </button>
                </div>
            </form>
        </div>
        
        <div class="card-footer text-muted">
            <small>* Поля, обязательные для заполнения</small>
        </div>
    </div>
    
    <!-- Примеры данных для тестирования -->
    <div class="mt-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">Пример данных для тестирования:</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Для быстрого тестирования можно скопировать:</strong></p>
                        <ul>
                            <li><strong>Заголовок:</strong> Тестовая статья</li>
                            <li><strong>Содержание:</strong> Это тестовое содержание статьи для проверки работы системы.</li>
                            <li><strong>Автор:</strong> Тест Автор</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Проверка валидации:</strong></p>
                        <ul>
                            <li>Попробуйте оставить поле пустым</li>
                            <li>Введите менее 3 символов в заголовок</li>
                            <li>Введите менее 10 символов в содержание</li>
                            <li>Не выберите категорию</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection