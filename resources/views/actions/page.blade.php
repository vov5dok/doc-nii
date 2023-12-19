@extends('layouts.app')

@section('content')

    <div class="board">
        <h1 class="page-title">Деятельность</h1>

        <div class="info-alert mb-6">
            <div class="alert-title">ВАЖНО!</div>
            <p>
                Приём документов на рассмотрение на ближайшем заседании завершается за 5 рабочих дней до даты заседания.
                Документы, поданные позднее, будут рассмотрены на следующем заседании согласно графику заседаний.
            </p>
        </div>

        <div class="nav-overflow">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#schedule" class="nav-link active" data-bs-toggle="tab" role="tab" aria-selected="true">Режим
                        работы</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#procedures" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false"
                       tabindex="-1">Стандартные операционные процедуры</a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active" id="schedule" role="tabpanel">
                <div class="row">
                    @if($meetings['current_year'])
                        <div class="col-lg-6">
                            <h4>График заседаний {{ $meetings['current_year']->year }} года</h4>
                            <ul class="list-schedule">
                                @foreach($meetings['current_year']->meetings()->get() as $index => $meetingInfo)
                                    <li><span>Заседание №{{ ++$index }}</span>
                                        @if($meetingInfo->meeting_date_correct)
                                            <del>{{ \Carbon\Carbon::parse($meetingInfo->meeting_date)->translatedFormat('j F Y') }}г.</del>
                                            {{ \Carbon\Carbon::parse($meetingInfo->meeting_date_correct)->translatedFormat('j F Y') }} г.
                                        @else
                                            {{ \Carbon\Carbon::parse($meetingInfo->meeting_date)->translatedFormat('j F Y') }} г.
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="col-lg-6">
                        <div class="warning mt-3 mb-6">
                            С целью обеспечения эпидемиологической безопасности Московский городской независимый
                            этический комитет временно принимает и выдает все виды документов посредством электронной
                            почты
                        </div>

                        <div class="accordion" id="scheduleArchive">
                            @foreach($meetings['past_years'] as $pastYearInfo)
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#schedule{{$pastYearInfo->year}}">
                                            График заседаний {{$pastYearInfo->year}} года
                                        </button>
                                    </div>
                                    <div id="schedule{{$pastYearInfo->year}}" class="accordion-collapse collapse"
                                         data-bs-parent="#scheduleArchive">
                                        <div class="accordion-body">
                                            <ul class="list-schedule">
                                                @foreach($pastYearInfo->meetings()->get() as $index => $meetingInfo)
                                                    <li><span>Заседание №{{ ++$index }}</span>
                                                        @if($meetingInfo->meeting_date_correct)
                                                            <del>{{ \Carbon\Carbon::parse($meetingInfo->meeting_date)->translatedFormat('j F Y') }}г.</del>
                                                            {{ \Carbon\Carbon::parse($meetingInfo->meeting_date_correct)->translatedFormat('j F Y') }} г.
                                                        @else
                                                            {{ \Carbon\Carbon::parse($meetingInfo->meeting_date)->translatedFormat('j F Y') }} г.
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            @endforeach


                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="procedures" role="tabpanel">
                <p class="section-text mb-5">В своей работе МГЭК руководствуется следующими стандартными операционными
                    процедурами (СОП):</p>
                <ul class="list-procedure">
                    <li>
                        <span>СОП_МГЭК_0</span> «Регламенты деятельности и документация Московского городского
                        независимого этического комитета»
                    </li>
                    <li>
                        <span>СОП_МГЭК_01</span> «Утверждение состава МГЭК»
                    </li>
                    <li>
                        <span>СОП_МГЭК_02</span> «Порядок организации заседаний»
                    </li>
                    <li>
                        <span>СОП_МГЭК_03</span> «Первичная этическая экспертиза»
                    </li>
                    <li>
                        <span>СОП_МГЭК_04</span> «Повторная этическая экспертиза»
                    </li>
                    <li>
                        <span>СОП_МГЭК_05</span> «Ускоренная этическая экспертиза»
                    </li>
                    <li>
                        <span>СОП_МГЭК_06</span> «Рассмотрение уведомлений»
                    </li>
                    <li>
                        <span>СОП_МГЭК_07</span> «Периодическая этическая экспертиза»
                    </li>
                    <li>
                        <span>СОП_МГЭК_08</span> «Рассмотрение отчетности о безопасности»
                    </li>
                    <li>
                        <span>СОП_МГЭК_09</span> «Рассмотрение итогового отчета»
                    </li>
                    <li>
                        <span>СОП_МГЭК_10</span> «Требования к информационному листку пациента»
                    </li>
                </ul>
                <p class="mb-1">
                    СОП МГЭК могут получить по&nbsp;электронной почте заинтересованные лица:
                </p>
                <ul class="mb-1">
                    <li>Главный исследователь;</li>
                    <li>Контрактно-исследовательская организация;</li>
                    <li>Разработчик лекарственного препарата,</li>
                </ul>
                <p>после направления запроса на электронную почту МГЭК (<a
                        href="mailto:ec@zdrav.mos.ru">ec@zdrav.mos.ru</a>).</p>

            </div>
        </div>


    </div>
    <div class="page-content">
        <h3>Регламентирующие документы</h3>
        <ul class="documents">
            @foreach($documents as $item)
                <li><a href="storage/{{ $item->document }}" target="_blank">{{ $item->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
