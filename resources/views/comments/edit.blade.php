@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактирование комментария</h1>
    
    <form action="{{ route('comments.update', ['article' => $article->id, 'comment' => $comment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="content">Комментарий:</label>
            <textarea class="form-control @error('content') is-invalid @enderror" 
                     id="content" 
                     name="content" 
                     rows="4" 
                     required>{{ old('content', $comment->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Обновить комментарий</button>
        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection