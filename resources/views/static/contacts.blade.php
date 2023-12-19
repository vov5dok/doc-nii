@extends('layouts.app')

@section('content')
    <div class="board">
        <h1 class="page-title">Контакты</h1>
        <p class="h4 mb-3">+7 (495) 417-12-14</p>
        <p><a href="mailto:ec@zdrav.mos.ru">ec@zdrav.mos.ru</a></p>
        <p>121096, г. Москва, ул. Минская, д. 12, корп. 2</p>

        <div class="contacts__map">
            <iframe
                src="https://yandex.ru/map-widget/v1/?lang=ru_RU&amp;scroll=true&amp;um=constructor%3Aad547eb006e488455ee0bb31b1d84fd2e294892acae77a080cd7b343dfd54f9a"
                frameborder="0" allowfullscreen="true" width="100%" height="440px" style="display: block;"></iframe>
        </div>
    </div>

@endsection
