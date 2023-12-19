@php use App\Models\StatementFileType; @endphp
@extends('layouts.app')

@section('content')
    <div class="board">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('statements.list') }}">&larr; Назад к списку</a>
            </li>
        </ol>

{{--        <x-statement-history-list :statement="$statement"/>--}}

        <div class="application">
            <div class="application__header">
                <h1 class="application-title">{{ $statement->statementStatus->full_name }}</h1>
                @can('update', $statement)
                    <a href="{{ route('statements.edit', $statement) }}" class="btn btn-edit">
                        <svg class="svg-icon">
                            <use xlink:href="/assets/img/sprite.svg#pen"></use>
                        </svg>
                        <span>Изменить заявление</span>
                    </a>
                @endcan
            </div>

            <div class="application-data">

                @if($statement->hasAnyStatus(['priniato-k-svedeniiu', 'priniato-resenie', 'zaverseno']))
                    @if(auth('moonshine')->user()->hasAnyRole(['employee', 'applicant']))
                        @isset($statement->registration_number)
                            <div class="application-data__item">
                                <p><b>Регистрационный номер:</b> {{ $statement->registration_number }}</p>
                            </div>
                        @endisset
                        @isset($statement->registration_date)
                            <div class="application-data__item">
                                <p><b>Дата регистрации:</b> {{ $statement->registration_date }}</p>
                            </div>
                        @endisset
                        @isset($statement->session_date)
                            @if(!$statement->hasAnyStatus(['priniato-k-svedeniiu']) && !auth('moonshine')->user()->hasAnyRole(['employee']))
                                <div class="application-data__item">
                                    <p><b>Дата заседания:</b> {{ $statement->session_date }}</p>
                                </div>
                            @endif
                        @endisset
                    @endif
                @endif

                @if($statement->hasAnyStatus(['priniato-k-svedeniiu', 'na-rassmotrenii', 'priniato-resenie', 'zaverseno']))
                    @if(auth('moonshine')->user()->hasAnyRole(['employee', 'applicant', 'participant']))
                        <div class="application-data__item">
                            <p><b>Заявление зарегистрировано</b></p>
                            <ul class="application-files">
                                @foreach($statement->files->where('type.code', StatementFileType::REGISTER) as $file)
                                    <li>
                                        <a href="{{ Storage::url($file->file) }}" target="blank" title="Скачать">
                                            {{ $file->name }} <br>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif

                @if($statement->hasAnyStatus(['priniato-resenie', 'zaverseno']))
                    @if(auth('moonshine')->user()->hasAnyRole(['employee', 'applicant', 'participant']))
                        <div class="application-data__item">
                            <p><b>Решение МГЭК</b></p>
                            <ul class="application-files">
                                @foreach($statement->files->where('type.code', StatementFileType::DECIDE) as $file)
                                    <li>
                                        <a href="{{ Storage::url($file->file) }}" target="blank" title="Скачать">
                                            {{ $file->name }} <br>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                     @endif
                @endif

                <div class="application-data__item">
                    <p><b>Наименование:</b> {{ $statement->name }}</p>
                </div>
                <div class="application-data__item">
                    <p><b>Тип процедуры:</b> {{ $statement->currentProcedure->name }}</p>
                </div>
                <div class="application-data__item">
                    <p><b>Документы Заявителя:</b></p>
                    <ul class="application-files">
                        @foreach($statement->files->where('type.code', StatementFileType::DEFAULT) as $file)
                            <li>
                                <a href="{{ Storage::url($file->file) }}" target="blank" title="Скачать">
                                    {{ $file->name }} <br>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($statement->hasAnyStatus(['na-rassmotrenii', 'priniato-resenie', 'zaverseno']))
                    @if(auth('moonshine')->user()->hasAnyRole(['participant', 'employee']))
                        <p><b>Решения экспертов:</b></p>
                        @foreach($statement->expertOpinions as $expertOpinion)
                            <div class="application-data__item">
                                <ul>
                                    <p><b>Решение: {{$expertOpinion->text}}</b></p>
                                    <p><b>Файлы:</b></p>
                                    <ul class="application-files">
                                        @foreach($statement->files->where('type.code', StatementFileType::DECIDE_EXPERT) as $file)
                                            <li>
                                                <a href="{{ Storage::url($file->file) }}" target="blank" title="Скачать">
                                                    {{ $file->name }} <br>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>

            @if($statement->hasAnyStatus(['novoe', 'izmeneno-zaiavitelem', 'izmeneno-sotrudnikom']) && auth('moonshine')->user()->hasAnyRole(['employee']))
                <x-statement-order-registration :statement="$statement"/>
            @endif

            @if($statement->hasAnyStatus(['priniato-resenie', 'priniato-k-svedeniiu']) && auth('moonshine')->user()->hasAnyRole(['employee']))
                <div class="application__submit">
                    <a href="{{ route('statements.complete', $statement) }}" type="button" class="btn btn-submit">Завершить</a>
                </div>
            @endif

            @if($statement->hasAnyStatus(['na-rassmotrenii']) && auth('moonshine')->user()->hasAnyRole(['employee']))
                <x-statement-order-decide :statement="$statement"/>
            @endif

            @if($statement->hasAnyStatus(['na-rassmotrenii']) && auth('moonshine')->user()->hasAnyRole(['participant']))
                <x-statement-order-expert-decision :statement="$statement"/>
            @endif

            <x-statement-messages :statement="$statement"/>

        </div>
    </div>

@endsection
