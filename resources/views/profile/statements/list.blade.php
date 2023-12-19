@extends('layouts.app')

@section('content')

    <!-- Start content page -->
    <div class="board-fluid">
        <div class="orders-header">
            <h1 class="orders-title">Заявления</h1>
            @if(auth('moonshine')->user()->hasAnyRole(['admin', 'applicant']))
                <a href="{{ route('statements.create') }}" class="btn">
                    <svg class="svg-icon">
                        <use xlink:href="/assets/img/sprite.svg#plus"></use>
                    </svg>
                    <span>Добавить заявление</span>
                </a>
            @endif
        </div>

        <div class="orders-filter">
            <form method="GET" action="{{ route('statements.list') }}" class="orders-filter__item">
                <div class="orders-filter-label">Сортировка</div>
                <div class="orders-filter-input">
                    <select onchange="this.form.submit();" name="sort" class="selectpicker-sm">
                        <option
                            {{ $filters['sort'] === 'created_date' ? 'selected' : '' }} value="created_date">по
                            дате добавления
                        </option>
                        <option {{ $filters['sort'] === 'name' ? 'selected' : '' }} value="name">по
                            наименованию
                        </option>
                        <option {{ $filters['sort'] === 'status' ? 'selected' : '' }} value="status">по
                            статусу
                        </option>
                        <option
                            {{ $filters['sort'] === 'changed_date' ? 'selected' : '' }} value="changed_date">по
                            дате изменения
                        </option>
                        <option
                            {{ $filters['sort'] === 'permission_date' ? 'selected' : '' }} value="permission_date">
                            по дате принятия решения
                        </option>
                    </select>
                </div>
            </form>

            <form class="orders-filter__item" method="GET" action="{{ route('statements.list') }}">
                <div class="orders-filter-label">Статус</div>
                <div class="orders-filter-input">
                    <select name="pick-status[]" onchange="this.form.submit();" class="selectpicker-sm" title="Все"
                            data-actions-box="true" multiple>
                        @foreach($statuses as $status)
                            <option
                                value="{{ $status->code }}"
                                {{ in_array($status->code, $filters['pick-status'] ?? [])  ? 'selected' : '' }}
                            >
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                <tr>
                    <th>Добавлено</th>
                    <th>Наименование</th>
                    @if(auth('moonshine')->user()->hasAnyRole(['admin', 'employee']))
                        <th>Заявитель</th>
                        <th>Организация</th>
                    @endif
                    <th>Статус</th>
                    <th>Изменено</th>
                    <th>Решение принято</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statements as $statement)
                    <tr>
                        <td>{{ $statement->created_at }}</td>
                        <td>{{ $statement->name }}</td>
                        @if(auth('moonshine')->user()->hasAnyRole(['admin', 'employee']))
                            <td>{{ $statement->moonshineUser->name ?? '' }}</td>
                            <td>{{ $statement->moonshineUser->orgranization->name ?? 'отсутствует' }}</td>
                        @endif

                        <td>
                            <span class="order-status
                            @if(in_array($statement->statementStatus->code, ['izmeneno-zaiavitelem', 'izmeneno-sotrudnikom']))
                                edit-order
                            @endif
                            @if($statement->statementStatus->code === 'novoe')
                                new-order
                            @endif
                            ">
                                {{ $statement->statementStatus->name }}

                            </span>
                        </td>
                        <td>{{ $statement->updated_at }}</td>
                        <td>{{ $statement->completed_at }}</td>
                        <td>
                            @can('update', $statement)
                                <a href="{{ route('statements.edit', $statement) }}" class="order-action"
                                   title="Изменить">
                                    <svg class="svg-icon">
                                        <use xlink:href="/assets/img/sprite.svg#pen"></use>
                                    </svg>
                                </a>
                            @endcan
{{--                            @if(!auth('moonshine')->user()->hasAnyRole(['participant']) && (!auth('moonshine')->user()->hasAnyRole(['applicant']) && $statement->hasAnyStatus(['novoe', 'izmeneno-zaiavitelem', 'izmeneno-sotrudnikom'])) || auth('moonshine')->user()->hasAnyRole(['admin', 'employee']))--}}
{{--                            @endif--}}
                            <a href="{{ route('statements.show', $statement) }}" class="order-action"
                               title="Посмотреть">
                                <svg class="svg-icon">
                                    <use xlink:href="/assets/img/sprite.svg#view"></use>
                                </svg>
                            </a>
                            @if(auth('moonshine')->user()->hasAnyRole(['admin', 'applicant', 'employee']) && $statement->hasAnyStatus(['novoe', 'izmeneno-zaiavitelem', 'izmeneno-sotrudnikom']))
                                <a href="{{ route('statements.delete', $statement) }}" class="order-action text-danger"
                                   title="Удалить">
                                    <svg class="svg-icon">
                                        <use xlink:href="/assets/img/sprite.svg#trash"></use>
                                    </svg>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            {{ $statements->links('profile.statements.includes.pagination') }}
        </div>
    </div>

@endsection
