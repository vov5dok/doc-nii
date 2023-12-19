@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="board">
        <h1 class="page-title">Новости</h1>
        <div class="news-list">
            @foreach($news as $post)
                <div class="news__item">
                    <a href="{{route('nii_news.show', $post->id)}}" class="news-card">
                        <div class="card-image">
                            <img src="{{$post->preview_picture_link}}" alt="{{$post->title}}">
                        </div>
                        <div class="card-body">
                            <div class="news-body">
                                <h4 class="card-title">{{$post->title}}</h4>
                                <div class="card-text">{{ Str::limit($post->description) }}</div>
                            </div>
                            <div class="news-footer">
                                <time class="news-date">{{date($post->pub_date)}}</time>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div id="load-more-wrapper">
            <div class="section-button mb-4">
                @if(!$news->onFirstPage())
                    <a class="btn"
                       href="{{$news->previousPageUrl()}}"
                    >
                        Назад
                    </a>
                @endif
                @if($news->hasMorePages())
                    <a class="btn"
                       href="{{$news->nextPageUrl()}}"
                    >
                        Далее
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
