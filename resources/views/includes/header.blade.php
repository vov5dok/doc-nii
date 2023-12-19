<header class="header">
    <nav class="navbar">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="/assets/img/mgek-logo.svg" alt="МГЭК">
            <div class="brand-name">
                Московский городской независимый этический комитет
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @if(auth('moonshine')->check())
            <div class="navbar-account">
                <button class="btn btn-account" data-bs-toggle="dropdown">
                    <svg class="svg-icon">
                        <use xlink:href="/assets/img/sprite.svg#account"></use>
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('statements.list') }}" {{ Route::is('statements.list') ? 'active': null }}>Заявления</a>
                    </li>
                    @if(!auth('moonshine')->user()->hasAnyRole(['applicant', 'participant']))
                        <li>
                            <a class="dropdown-item {{ Route::is('applicants.list') ? 'active': null }}"
                               href="{{ route('applicants.list') }}">Заявители</a>
                        </li>
                    @endif
                    <li>
                        <a class="dropdown-item {{ Route::is('profile') ? 'active' : null }}"
                           href="{{ route('profile') }}">Мой профиль</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">Выход</a>
                    </li>
                </ul>
            </div>
        @else
            <div class="navbar-account">
                <button class="btn btn-account" data-bs-target="#authorization" data-bs-toggle="modal" title="Войти">
                    <svg class="svg-icon">
                        <use xlink:href="/assets/img/sprite.svg#account"></use>
                    </svg>
                </button>
            </div>
        @endif

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('committee') ? 'active' : null }}"
                       href="{{ route('committee') }}">
                        Состав комитета
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('legal') ? 'active' : null }}" href="{{ route('legal') }}">
                        Порядок рассмотрения документов
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('actions') ? 'active' : null }}" href="{{ route('actions') }}">
                        Деятельность
                    </a>
                </li>
{{--                TODO : старые посты, которые были до внедрения nii_news--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link {{ Route::is('news.index') ? 'active' : null }}" href="{{ route('news.index') }}">Новости</a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('nii_news.index') ? 'active' : null }}" href="{{ route('nii_news.index') }}">Новости</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('contacts') ? 'active' : null }}" href="{{ route('contacts') }}">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('faq') ? 'active' : null }}" href="{{ route('faq') }}">Часто
                        задаваемые вопросы</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
