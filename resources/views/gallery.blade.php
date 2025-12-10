@extends('layouts.app')

@section('title', 'Галерея')

@section('content')
<div class="py-5">
    <h1 class="mb-4">Галерея статей</h1>
    
    @if(isset($article))
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ $article['name'] }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset($article['full_image']) }}" 
                         class="img-fluid rounded mb-3" 
                         alt="Full Image"
                         style="max-height: 400px;"
                         data-bs-toggle="modal" 
                         data-bs-target="#fullImageModal"
                         style="cursor: pointer;">
                    
                    <div class="mt-4">
                        <h5>Описание:</h5>
                        <p>{{ $article['desc'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('gallery') }}" class="btn btn-secondary">Вернуться ко всем статьям</a>
            <a href="{{ route('home') }}" class="btn btn-primary">На главную</a>
        </div>
    </div>
    
    @elseif(isset($articles) && count($articles) > 0)
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ $article['name'] }}</h5>
                    <small class="text-muted">{{ $article['date'] }}</small>
                </div>
                <div class="card-body">
                    
                    <div class="text-center mb-3">
                        <img src="{{ asset($article['full_image']) }}" 
                             class="img-fluid rounded" 
                             alt="Full Image"
                             style="height: 200px; width: 100%; object-fit: cover;">
                    </div>
                    
                    <p class="card-text">
                        <strong>Краткое описание:</strong><br>
                        {{ $article['shortDesc'] ?? substr($article['desc'], 0, 100) . '...' }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('gallery.show', $article['id']) }}" 
                       class="btn btn-sm btn-primary">
                        Читать статью
                    </a>
                    <span class="badge bg-secondary float-end">ID: {{ $article['id'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @endif
</div>

<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Превью изображение</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPreviewImage" src="" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fullImageModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalFullImage" src="" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</div>
@endsection