@extends('layouts.app')


@section('content')
    <div class="board">
        <h1 class="page-title">{{ $legal->name }}</h1>
        <div class="row">
            <div class="aside">
                <nav class="nav nav-pills">
                    @foreach($menu as $menuItem)
                        <a href="{{ route('legal-item', $menuItem) }}"
                           class="nav-link @if($menuItem->name === $legal->name) active @endif">{{ $menuItem->name }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="content">
                {!! $legal->content !!}
            </div>
        </div>

    </div>
    <div class="page-content">
        <h4 id="documents">Файлы для скачивания</h4>
        <ul class="documents">
            @foreach($legal->files()->get() as $fileInfo)
                <li><a href="/storage/{{ $fileInfo->file }}" target="_blank">{{ $fileInfo->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
