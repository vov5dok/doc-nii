@extends('layouts.app')

@section('content')

    <article class="board">
        <nav class="nav-back">
            <a href="{{ route('nii_news.index') }}">&lt;&ensp;Назад к списку новостей</a>
        </nav>

        <header class="news__item">
            <div class="news-card">
                <div class="card-image">
                    <img src="{{$news->preview_picture_link}}"
                         alt="{{ $news->title }}">
                </div>
                <div class="card-body">
                    <div class="news-body">
                        <h1 class="card-title">{{ $news->title }}</h1>
                        <div class="card-text">{{ Str::limit($news->description) }}</div>
                    </div>
                    <div class="news-footer">
                        <time class="news-date">{{ $news->pub_date }}</time>
                    </div>
                </div>
            </div>
        </header>

        <div class="news__detail">
            {!! $news->detail_text !!}
        </div>

        <div class="share">
            <div class="me-3">Поделиться:</div>
            <div class="ya-share2" data-curtain data-size="l" data-shape="round" data-color-scheme="whiteblack"
                 data-services="vkontakte,odnoklassniki,telegram"></div>
        </div>
        <script src="https://yastatic.net/share2/share.js"></script>
    </article>

@endsection
