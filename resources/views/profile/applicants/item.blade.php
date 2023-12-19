@extends('layouts.app')

@section('content')
    <div class="board">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('applicants.list') }}">&larr; Назад к списку</a>
            </li>
        </ol>
        <div class="application">
            <h1 class="application-title">Сведения о заявителе</h1>

            <div class="application-data">
                <div class="application-data__item">
                    <b>Дата заявки на регистрацию:</b> {{ $user->created_at }}
                </div>
                <div class="application-data__item">
                    <b>Статус:</b>
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
                </div>
                <div class="application-data__item">
                    <b>ФИО:</b> {{ $user->second_name }} {{ $user->name }} {{ $user->last_name }}
                </div>
                <div class="application-data__item">
                    <b>E-mail:</b> {{ $user->email }}
                </div>
                <div class="application-data__item">
                    <b>Телефон:</b> {{ $user->phone }}
                </div>
                @if($user->phone_additional)
                    <div class="application-data__item">
                        <b>Дополнительный телефон:</b> {{ $user->phone_additional }}
                    </div>
                @endif
                <div class="application-data__item">
                    <b>Организация:</b> {{ $user->organization->name ?? 'Сведения об организации отсутствуют.' }}
                </div>
                <div class="application-data__item">
                    <b>Должность:</b> {{ $user->position }}
                </div>
            </div>

            <div class="users__footer">
                @if($user->description_rejection || $user->active || $user->deactivation_date)
                    <a id="renew-user" href="{{ route('user.renew', $user->id) }}" class="btn btn-primary">Восстановить
                        *</a>
                    @if(!$user->deactivation_date)
                        <a href="{{ route('user.deactivate', $user->id) }}" class="btn btn-outline-secondary">Деактивировать</a>
                    @endif
                    <div class="note">* Вернуть заявление в статус "новый"</div>
                @else
                    <a href="{{ route('user.activate', $user->id) }}" class="btn btn-primary">Подтвердить
                        регистрацию</a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#comment">Отказать в регистрации
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="comment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" {{ route('user.reject') }} id="reject-user" class="modal-content users__modal">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Укажите причину отказа в регистрации</label>
                    <textarea name="reject-text" class="form-control"></textarea>
                </div>
                <input name="user_id" type="text" value="{{ $user->id }}" class="form-control d-none" required>

                <div class="modal-footer">
                    <button type="button" class="btn btn-reset" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-submit">Отправить</button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#reject-user').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.reject') }}',
                    data: $('#reject-user').serialize(),
                    headers: {
                        'Accept': 'application/json, text-plain, */*'
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            });
        </script>
    @endpush
@endsection
