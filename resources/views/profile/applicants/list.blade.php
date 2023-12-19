@extends('layouts.app')

@section('content')

    <!-- Start content page -->
    <div class="board-fluid">
        <h1 class="page-title">Заявители</h1>

        <div class="orders__row">
            <div class="orders__search">
                <div class="orders-search">
                    <form class="input-group" action="{{ route('applicants.list') }}" method="get">
                        @csrf
                        <input name="q" value="{{ request()->query('q') }}" type="text" placeholder="Поиск по заявителям" class="form-control">
                        <button type="submit" class="btn" title="Найти">
                            <svg class="svg-icon">
                                <use xlink:href="/assets/img/sprite.svg#search"></use>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="orders__filter">
                <div class="orders-filter">
                    <form class="orders-filter__item">
                        @csrf
                        <div class="orders-filter-label">Сортировка</div>
                        <div class="orders-filter-input">
                            <select id="select-sort" name="sort" onchange="this.form.submit();" class="selectpicker-sm">
                                <option {{ request()->query('sort') === 'created' ? 'selected' : '' }} value="created">по дате добавления</option>
                                <option {{ request()->query('sort') === 'fio' ? 'selected' : '' }} value="fio">по ФИО</option>
                                <option {{ request()->query('sort') === 'org' ? 'selected' : '' }} value="org">по организации</option>
                                <option {{ request()->query('sort') === 'status' ? 'selected' : '' }} value="status">по статусу</option>
                            </select>
                        </div>
                    </form>

                    <form class="orders-filter__item">
                        @csrf
                        <div class="orders-filter-label">Статус</div>
                        <div class="orders-filter-input">
                            <select name="pick-status[]" onchange="this.form.submit();" class="selectpicker-sm"
                                    title="Все" data-actions-box="true" multiple>
                                <option
                                    {{ in_array(\App\Models\MoonshineUser::STATUS_ID_NEW, request()->query('pick-status')??[]) ? 'selected' : '' }} name="pick-status[]"
                                    value="1">новый
                                </option>
                                <option
                                    {{ in_array(\App\Models\MoonshineUser::STATUS_ID_CONFIRMED, request()->query('pick-status') ?? [])  ? 'selected' : '' }} name="pick-status[]"
                                    value="2">подтвержден
                                </option>
                                <option
                                    {{ in_array(\App\Models\MoonshineUser::STATUS_ID_REFUSED, request()->query('pick-status')?? [])  ? 'selected' : '' }} name="pick-status[]"
                                    value="3">отказано
                                </option>
                                <option
                                    {{ in_array(\App\Models\MoonshineUser::STATUS_ID_DEACTIVATE, request()->query('pick-status')?? [])  ? 'selected' : '' }} name="pick-status[]"
                                    value="4">деактивирован
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="users-table">
                <thead>
                <tr>
                    <th>Добавлен</th>
                    <th>ФИО</th>
                    <th>Организация</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->second_name }} {{ $user->name }} {{ $user->last_name }}</td>

                        @if($user->organization)
                            <td>{{ $user->organization->name }}</td>
                        @else
                            <td>Данные об организации отсутствуют</td>
                        @endif

                        <td>
                            @if($user->active)
                                <span class="user-status text-success">подтверждён</span>
                            @elseif($user->description_rejection)
                                <span class="user-status text-danger">
                                        отказано
                                        <a tabindex="0" class="status-comment" data-bs-toggle="popover"
                                           data-bs-content="{{ $user->description_rejection }}">?</a>
                                    </span>
                            @elseif($user->deactivation_date)
                                <span class="user-status disabled-user">деактивирован</span>
                            @else
                                <span class="user-status new-user">новый</span>
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('applicants.show', $user->id) }}" class="user-action" title="Посмотреть">
                                <svg class="svg-icon">
                                    <use xlink:href="/assets/img/sprite.svg#view"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $users->links('profile.applicants.includes.pagination') }}
        </div>
    </div>

    <!-- End content page -->

@endsection
