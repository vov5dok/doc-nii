@extends('layouts.app')

@section('content')

    <article class="board">
        <nav class="nav-back">
            <a href="{{ route('news.index') }}">&lt;&ensp;Назад к списку новостей</a>
        </nav>

        <header class="news__item">
            <div class="news-card">
                <div class="card-image">
                    <img src="/storage/{{ $post->image }}"
                         alt="{{ $post->name }}">
                </div>
                <div class="card-body">
                    <div class="news-body">
                        <h1 class="card-title">{{ $post->name }}</h1>
                    </div>
                    <div class="news-footer">
                        <time class="news-date">{{ $post->added_at }}</time>
                        <div class="news-views">{{ (int)$post->counter }}</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="news__detail">
            {!! $post->detail_text !!}
        </div>

        <div class="share">
            <div class="me-3">Поделиться:</div>
            <div class="ya-share2" data-curtain data-size="l" data-shape="round" data-color-scheme="whiteblack"
                 data-services="vkontakte,odnoklassniki,telegram"></div>
        </div>
        <script src="https://yastatic.net/share2/share.js"></script>
    </article>

@endsection
