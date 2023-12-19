@extends('layouts.app')

@section('content')
    <section class="about">
        <div class="about__row">
            <div class="about__col">
                <h1 class="section-title">
                    Московский городской независимый этический комитет (МГЭК)
                </h1>
                Московский городской независимый этический комитет (МГЭК) создан в&nbsp;соответствии с&nbsp;приказом
                Департамента здравоохранения города Москвы от&nbsp;25.11.2016&nbsp;г. №&nbsp;948 «О&nbsp;Московском
                городском независимом
                этическом комитете» на&nbsp;базе Государственного бюджетного учреждения города Москвы
                «Научно-исследовательский
                институт организации здравоохранения и медицинского менеджмента Департамента здравоохранения города
                Москвы» (ГБУ «НИИОЗММ ДЗМ»).
            </div>

            <div class="about__col">
                <img src="/assets/img/doctors.svg" alt="" class="about-image">
            </div>
        </div>
    </section>

    <section class="goals">
        <h2 class="section-title">Цели МГЭК</h2>
        <div class="goals__body">
            <div class="goals__item">
                <div class="goal-card">
                    <div class="goal-text">
                        Защита прав и интересов всех лиц, вовлеченных в&nbsp;исследование
                    </div>
                    <img src="/assets/img/goal1.svg" alt="" class="goal-picture">
                </div>
            </div>

            <div class="goals__item">
                <div class="goal-card">
                    <div class="goal-text">
                        Обеспечение безопасности и охрана здоровья всех участников исследований
                    </div>
                    <img src="/assets/img/goal2.svg" alt="" class="goal-picture">
                </div>
            </div>
        </div>

        <div class="info-alert">
            <div class="alert-title">ВАЖНО!</div>
            <p>
                <b>МГЭК является полностью независимым органом, в частности:</b>
            </p>
            <ul class="divided">
                <li>Извлечение прибыли и ее распределение не являются целями деятельности МГЭК.</li>
                <li>МГЭК не имеет заинтересованности в конкретном исследовании независимо от исследователя, заказчика,
                    спонсора или учредителя.
                </li>
            </ul>
        </div>
    </section>

    <section class="normative">
        <h2 class="section-title">Законодательная база</h2>
        <div class="accordion">
            <div class="accordion-item">
                <div class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#legalBase">
                        Документы и законы, которыми руководствуется МГЭК в своей деятельности
                    </button>
                </div>
                <div id="legalBase" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <ol class="divided">
                            @foreach($pageInfo['documents']['info'] as $documentInfo)
                                <li>{{ $documentInfo->name }}</li>
                            @endforeach
                        </ol>
                        <p>
                            Все документы можно изучить по <a href="{{ route('actions') }}">этой ссылке</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-text">
            <p>
                По существующему законодательству МГЭК должен регулярно (не реже 1 раза в год) получать извещение о
                ходе
                проведения исследования, а по окончании работы главный исследователь должен отчитываться на
                заседании
                МГЭК ЭК о проведенном протоколе.
            </p>
            <p>
                В обязательном порядке МГЭК должен получать извещение обо всех нежелательных явлениях: серьезных
                (СНЯ) и
                несерьезных (НЯ).
            </p>
            <p>
                МГЭК должен получать извещения обо всех поправках к основным документам исследования, например,
                таким,
                как протокол исследования и брошюра исследователя.
            </p>
        </div>
    </section>


    <section class="logistics">
        <h2 class="section-title">Материально-техническое обеспечение</h2>
        <p>
            Материально-техническое обеспечение деятельности МГЭК осуществляется Государственным бюджетным учреждением
            города Москвы «Научно-исследовательский институт организации здравоохранения и медицинского менеджмента
            Департамента здравоохранения города Москвы»
        </p>
    </section>
    @if($newsInfo->isNotEmpty())
        <section class="information">
            <h2 class="section-title">Новости</h2>
            <div class="news__item">
                <a href="{{ route('nii_news.show', $newsInfo->get('last_post')->id) }}" class="news-card">
                    <div class="card-image">
                        <img src="{{ $newsInfo->get('last_post')->preview_picture_link }}"
                             alt="{{ $newsInfo->get('last_post')->name }}">
                    </div>
                    <div class="card-body">
                        <div class="news-body">
                            <h4 class="card-title">{{ $newsInfo->get('last_post')->name }}</h4>
                            <div class="card-text">{!! $newsInfo->get('last_post')->description !!}</div>
                        </div>
                        <div class="news-footer">
                            <time class="news-date">{{ date($newsInfo->get('last_post')->pub_date) }}</time>
{{--                            TODO : SEO счетчик --}}
{{--                            <div class="news-views">{{ $pageInfo['post']['info']->counter }}</div>--}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="section-button">
                <a href="{{ route('nii_news.index') }}" class="btn">Все новости</a>
            </div>
        </section>
    @endif
@endsection
