@extends('layouts.app')

@section('content')
    <div class="board">
        <h1 class="page-title">Часто задаваемые вопросы</h1>
        <div class="accordion" id="faq">
            @foreach($questions as $index => $questionData)

                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#question{{ $index }}" aria-expanded="false">
                            {{ ++$index }}. {{ $questionData->question }}                        </button>
                    </div>
                    <div id="question{{ --$index }}" class="accordion-collapse collapse" data-bs-parent="#faq" style="">
                        <div class="accordion-body">
                            {!! $questionData->answer !!}
                        </div>
                    </div>
                </div>

            @endforeach

        </div>

    </div>

@endsection
