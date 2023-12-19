@extends('layouts.app')

@section('content')

    <!-- Start content page -->
    <div class="board">
        <h1 class="page-title">Профиль пользователя</h1>

        <div class="profile__form">
            <h2 class="profile__form-title">Фото профиля</h2>

            <form id="change-avatar" class="profile__form-avatar" enctype="multipart/form-data">
                @csrf
                <div class="avatar-image">
                    <div class="profile-photo">
                        <img src="storage/{{ auth('moonshine')->user()->avatar }}">
                    </div>
                </div>

                <div class="avatar-input">
                    <label class="input-file">
                        <input type="file" name="avatar">
                        <span class="btn">Загрузить фото</span>
                    </label>
                </div>
            </form>
        </div>

        <div class="profile__form">
            <h2 class="profile__form-title">Личные данные</h2>
            <form method="post" id="change-profile">
                <div class="profile__form-alert">
                    <div class="alert d-none">

                    </div>
                </div>
                @csrf
                <div class="row-form-group">
                    <label class="col-form-label">Фамилия *</label>
                    <div class="col-form-input">
                        <input type="text" name="second_name" class="form-control"
                               value="{{ auth('moonshine')->user()->second_name }}"
                               required>
                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">Имя *</label>
                    <div class="col-form-input">
                        <input type="text" name="name" class="form-control"
                               value="{{ auth('moonshine')->user()->name }}" required>
                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">Отчество *</label>
                    <div class="col-form-input">
                        <input type="text" name="last_name" class="form-control"
                               value="{{ auth('moonshine')->user()->last_name }}"
                               required>
                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">E-mail *</label>
                    <div class="col-form-input">
                        <input name="email" type="email" class="form-control"
                               value="{{ auth('moonshine')->user()->email }}"
                        >
                    </div>
                </div>


                {{--                <div class="row-form-group">--}}
                {{--                    <label class="col-form-label">Телефон</label>--}}
                {{--                    <div class="col-form-input">--}}
                {{--                        <input type="text" class="form-control js-phonemask">--}}
                {{--                    </div>--}}
                {{--                </div>--}}


                <div class="row-form-group">
                    <label class="col-form-label">Организация *</label>
                    <div class="col-form-input">
                        <select name="organization" class="selectpicker" data-live-search="true" title="выберите"
                                required
                                @if(auth('moonshine')->user()->hasAnyRole(['participant', 'employee']))
                                    disabled
                            @endif
                        >
                            @foreach($organizations as $organization)
                                <option
                                    value="{{$organization->id}}"
                                    @if($organization->id == $user_organization_id)
                                        selected
                                    @endif
                                >
                                    {{ $organization->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">Должность *</label>
                    <div class="col-form-input">
                        <input name="position" type="text" class="form-control"
                               value="{{ auth('moonshine')->user()->position }}"
                               required
                               @if(auth('moonshine')->user()->hasAnyRole(['participant', 'employee']))
                                   disabled
                            @endif
                        >
                    </div>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn">Сохранить изменения</button>
                </div>
            </form>
        </div>

        <div class="profile__form">
            <h2 class="profile__form-title">Изменение пароля</h2>

            <form method="post" id="change-password">
                <div class="profile__form-alert">
                    <div class="alert d-none">

                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">Текущий пароль *</label>
                    <div class="col-form-input">
                        <input name="current_password" type="password" class="form-control" autocomplete="new-password"
                               required>
                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">Новый пароль *</label>
                    <div class="col-form-input">
                        <input name="new_password" type="password" class="form-control" autocomplete="new-password"
                               required>
                    </div>
                </div>

                <div class="row-form-group">
                    <label class="col-form-label">Повторите новый пароль *</label>
                    <div class="col-form-input">
                        <input name="new_password_repeat" type="password" class="form-control"
                               autocomplete="new-password" required>
                    </div>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn">Сменить пароль</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End content page -->

@endsection

@push('scripts')
    <script>
        $('#change-password').on('submit', function (e) {
            e.preventDefault();

            const alert = $('#change-password .profile__form-alert .alert'); // получаем элемент alert

            // Сначала скрываем сообщение и удаляем классы alert-danger и alert-success
            alert.addClass('d-none').removeClass('alert-success alert-danger');

            $.ajax({
                url: '{{ route('profile.change.password') }}', // замените на URL-адрес маршрута обработки пароля
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'current_password': $('input[name="current_password"]').val(),
                    'new_password': $('input[name="new_password"]').val(),
                    'new_password_repeat': $('input[name="new_password_repeat"]').val(),
                },
                success: function (response) {
                    // Удаляем класс d-none, добавляем класс alert-success и показываем сообщение об успехе
                    alert.removeClass('d-none').addClass('alert-success').html('Пароль успешно изменен');
                },
                error: function (response) {
                    // Удаляем класс d-none, добавляем класс alert-danger и показываем сообщение об ошибке
                    alert.removeClass('d-none').addClass('alert-danger').html(response.responseJSON.message);
                }
            });
        });

        $('#change-profile').on('submit', function (e) {
            e.preventDefault();

            const $alert = $('#change-profile .profile__form-alert .alert'); // получаем элемент alert

            // Сначала скрываем сообщение и удаляем классы alert-danger и alert-success
            $alert.addClass('d-none').removeClass('alert-success alert-danger');

            $.ajax({
                url: '{{ route('profile.change') }}', // замените на URL-адрес маршрута обработки профиля
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}', // добавьте токен CSRF
                    'second_name': $('input[name="second_name"]').val(),
                    'name': $('input[name="name"]').val(),
                    'last_name': $('input[name="last_name"]').val(),
                    'email': $('input[name="email"]').val(),
                    'organization': $('select[name="organization"]').val(),
                    'position': $('input[name="position"]').val(),
                },
                success: function (response) {
                    // Удаляем класс d-none, добавляем класс alert-success и показываем сообщение об успехе
                    $alert.removeClass('d-none').addClass('alert-success').html('Изменения успешно сохранены');
                },
                error: function (response) {
                    // Удаляем класс d-none, добавляем класс alert-danger и показываем сообщение об ошибке
                    $alert.removeClass('d-none').addClass('alert-danger').html(response.responseJSON.message);
                }
            });
        });

        $(document).ready(function () {
            $('#change-avatar input[type=file]').on('change', function (event) {
                let form = $('#change-avatar');
                let formData = new FormData(form[0]);

                formData.append('_token', $('input[name="_token"]').val());

                $.ajax({
                    url: '{{ route('profile.change.avatar') }}',  // замените на ваш URL-адрес для загрузки файла
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.path) {
                            $('.profile-photo img').attr('src', 'storage/' + data.path);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                    }
                });

                event.preventDefault();
            });
        });

    </script>
@endpush
