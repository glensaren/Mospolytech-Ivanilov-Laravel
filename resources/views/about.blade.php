@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="py-5">
    <h1 class="mb-4">О нашей компании</h1>
    
    <div class="row">
        <div class="col-lg-6 mb-4">
            <h3>Наша история</h3>
            <p>Мы начали свою деятельность в 2035 году с целью создания современных веб-решений. С тех пор мы успешно реализовали множество проектов различной сложности.</p>
            <p>Наша команда состоит из опытных разработчиков, дизайнеров и менеджеров проектов, которые работают вместе для достижения общих целей.</p>
            <p>А ещё мы иногда готовим шаурму на Пряниках.</p>
        </div>
        
        <div class="col-lg-6 mb-4">
            <h3>Наши ценности</h3>
            <ul class="list-group">
                <li class="list-group-item">Качество превыше всего</li>
                <li class="list-group-item">Инновации в каждом проекте</li>
                <li class="list-group-item">Прозрачность работы</li>
                <li class="list-group-item">Клиентоориентированность</li>
                <li class="list-group-item">Постоянное развитие</li>
            </ul>
        </div>
    </div>
    
    <div class="mt-5">
        <h3>Наши достижения</h3>
        <div class="row mt-3">
            <div class="col-md-4 text-center">
                <div class="p-3 bg-primary text-white rounded-circle d-inline-block">
                    <h2>50+</h2>
                </div>
                <p class="mt-2">Завершенных проектов</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-3 bg-success text-white rounded-circle d-inline-block">
                    <h2>5</h2>
                </div>
                <p class="mt-2">Лет опыта</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-3 bg-warning text-white rounded-circle d-inline-block">
                    <h2>100%</h2>
                </div>
                <p class="mt-2">Довольных клиентов</p>
            </div>
        </div>
    </div>
</div>
@endsection