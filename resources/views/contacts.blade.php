@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="py-5">
    <h1 class="mb-4">Наши контакты</h1>
    
    <div class="row">
        <div class="col-lg-6 mb-4">
            <h3>Контактная информация</h3>
            <div class="list-group">
                @foreach($contacts as $contact)
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $contact['title'] }}</h5>
                        <small>{{ $contact['type'] }}</small>
                    </div>
                    <p class="mb-1">{{ $contact['value'] }}</p>
                    @if(isset($contact['description']))
                    <small>{{ $contact['description'] }}</small>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <h3>Свяжитесь с нами</h3>
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Ваше имя</label>
                            <input type="text" class="form-control" id="name" placeholder="Иван Иванов">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Сообщение</label>
                            <textarea class="form-control" id="message" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5">
        <h3>Наш офис</h3>
        <div class="card">
            <div class="card-body">
                <p><strong>Адрес:</strong> г. Москва, ул. Примерная, д. 123</p>
                <p><strong>Режим работы:</strong> Пн-Пт: 9:00-18:00</p>
                <div class="mt-3">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.373789379241!2d37.61763331593063!3d55.75582600000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a5a738fa419%3A0x7c347d506b52311f!2sRed%20Square!5e0!3m2!1sen!2sru!4v1647851611847!5m2!1sen!2sru" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection