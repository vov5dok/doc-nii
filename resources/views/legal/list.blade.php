@extends('layouts.app')

@section('content')
    <div class="board">
        <h1 class="page-title">Порядок рассмотрения документов</h1>
        <div class="row">
            <div class="aside">
                <nav class="nav nav-pills">
                    @foreach($legals as $legal)
                        <a href="{{ route('legal-item', $legal) }}" class="nav-link">{{ $legal->name }}</a>
                    @endforeach
                </nav>
            </div>

            <div class="content">
                <p>
                    Деятельность Московского городского независимого этического комитета (МГЭК) определяется положением
                    МГЭК, регламентом МГЭК и стандартными операционными процедурами (СОП) МГЭК. Ведение документации
                    осуществляется с&nbsp;использованием установленных форм, являющихся приложением к&nbsp;соответствующим
                    СОП.
                </p>
                <p>
                    Выберите вид процедуры, чтобы ознакомиться с&nbsp;порядком действий и скачать необходимые шаблоны
                    документов – установленных форм.
                </p>
                <div class="mt-6 text-center">
                    <img src="/assets/img/documents.svg" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
