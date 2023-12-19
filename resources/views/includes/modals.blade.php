<!-- Авторизация -->
<div class="modal fade" id="authorization" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body login">
                <h3 class="modal-title">Авторизация</h3>

                <form id="authorization-form" method="post" action="{{ route('login.perform') }}">
                    @csrf
                    <div class="alert alert-success d-none">
                    </div>
                    <div class="alert alert-danger d-none">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail">
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Пароль">
                    </div>

                    <div class="form-group-flex">
                        <div class="login-checkbox">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Запомнить</label>
                        </div>
                        <a class="link-small" href="#recoverpass" data-bs-toggle="modal" data-bs-dismiss="modal">Забыли
                            пароль?</a>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn">Войти</button>
                    </div>
                </form>

                <a href="#registration" data-bs-toggle="modal" data-bs-dismiss="modal"
                   class="link-small">Регистрация</a>
            </div>
        </div>
    </div>
</div>
    <script>

        function get_message(data) {
            if (data.responseJSON.errors) {
                let first_error_key = Object.keys(data.responseJSON.errors)[0]
                return data.responseJSON.errors[first_error_key].toString();
            } else {
                return data.responseJSON.message.toString();
            }
        }

        function get_capthca() {
            let captcha = $('img.captcha-img');
            let config = captcha.data('refresh-config');
            $.ajax({
                method: 'GET',
                url: '/get_captcha/' + config,
            }).done(function (response) {
                captcha.prop('src', response);
            });
        }

        $(document).ready(function () {
            $('#authorization-form').on('submit', function (e) {
                $('#authorization-form div.alert-success').addClass('d-none');
                $('#authorization-form div.alert-danger').addClass('d-none');
                $('#authorization-form div.alert-success').empty();
                $('#authorization-form div.alert-danger').empty();
                $('#authorization-form button').attr('disabled', true);
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('login.perform') }}',
                    data: $('#authorization-form').serialize(),
                    headers: {
                        'Accept': 'application/json, text-plain, */*'
                    },
                    success: function () {
                        window.location.replace('/profile/statements');
                    },
                    error: function (data) {
                        $('#authorization-form button').attr('disabled', false);
                        let message = get_message(data);
                        $('#authorization-form div.alert-danger').append(message);
                        $('#authorization-form div.alert-danger').removeClass('d-none');
                        $('#authorization-form').scrollTop(0);
                    }
                });
            });
        });


    </script>



<!-- Регистрация -->
<div class="modal fade" id="registration" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body login">
                <h3 class="modal-title">Регистрация</h3>

                <form id="registration-form" method="post" action="{{ route('register.perform') }}">
                    @csrf
                    <div class="alert alert-success d-none">
                    </div>
                    <div class="alert alert-danger d-none">
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">E-mail</label>
                        <div class="col-form-input">
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Фамилия</label>
                        <div class="col-form-input">
                            <input type="text" name="second_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Имя</label>
                        <div class="col-form-input">
                            <input name="name" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Отчество</label>
                        <div class="col-form-input">
                            <input name="last_name" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Организация</label>
                        <div class="col-form-input">
                            <select name="organization" class="js-selectpicker" data-live-search="true" title="выберите"
                                    required>
                                <option value="0">Моей организации нет в списке</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization['id'] }}">{{ $organization['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Должность</label>
                        <div class="col-form-input">
                            <input name="position" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Телефон</label>
                        <div class="col-form-input">
                            <input name="phone" type="tel" class="form-control">
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Дополнительный телефон</label>
                        <div class="col-form-input">
                            <input name="phone_additional" type="tel" class="form-control">
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Пароль</label>
                        <div class="col-form-input">
                            <input name="password" type="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="row-form-group">
                        <label class="col-form-label">Снова пароль</label>
                        <div class="col-form-input">
                            <input name="password_confirmation" type="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Введите код с картинки</label>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ captcha_src() }}" class="captcha-img" data-refresh-config="default">
                                <a id="refresh"><img src="/files/img/refresh.png" alt="обновить"></a>
                            </div>
                            <input name="captcha" type="text" class="form-control" required>
                        </div>

                    </div>

                    <div class="login-checkbox my-5">
                        <input type="checkbox" name="data_processing_permission" class="form-check-input"
                               id="data_processing_permission" value="1" checked required>
                        <label class="form-check-label" for="data_processing_permission">Я ознакомлен(а) с <a href="/files/Политика_обработки_ПД.pdf"
                                                                                                              target="_blank">политикой
                                обработки и защиты персональных данных</a>, принимаю её и даю своё согласие на сбор,
                            обработку и хранение моих персональных данных</label>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn">Зарегистрироваться</button>
                    </div>
                </form>

                <a href="#authorization" data-bs-toggle="modal" data-bs-dismiss="modal"
                   class="link-small">Авторизация</a>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {

            $('#refresh').on('click', function () {
                get_capthca();
            });

            $('#registration-form').on('submit', function (e) {
                $('#registration-form div.alert-success').addClass('d-none');
                $('#registration-form div.alert-danger').addClass('d-none');
                $('#registration-form div.alert-success').empty();
                $('#registration-form div.alert-danger').empty();
                $('#registration-form button').attr('disabled', true);
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('register.perform') }}',
                    data: $('#registration-form').serialize(),
                    headers: {
                        'Accept': 'application/json, text-plain, */*'
                    },
                    success: function (data) {
                        let message = data.success;
                        $('#registration-form div.alert-success').append(message);
                        $('#registration-form div.alert-success').removeClass('d-none');
                        $('#registration-form div.row-form-group').addClass('d-none');
                        $('#registration-form div.form-group').addClass('d-none');
                        $('#registration-form div.login-checkbox').addClass('d-none');
                        $('#registration-form div.form-submit').addClass('d-none');
                    },
                    error: function (data) {
                        let message = get_message(data);
                        get_capthca();
                        $('#registration-form button').attr('disabled', false);
                        $('#registration-form div.alert-danger').append(message);
                        $('#registration-form div.alert-danger').removeClass('d-none');
                        $('#registration').scrollTop(0);
                    }
                });
            });
        });
    </script>



<!-- Восстановить пароль -->
<div class="modal fade" id="recoverpass" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body login">
                <h3 class="modal-title">Восстановить пароль</h3>

                <form id="recovery" method="post">
                    @csrf
                    <div class="alert alert-success d-none">
                    </div>
                    <div class="alert alert-danger d-none">
                    </div>

                    <div class="form-group">
                        <input name="email" type="email" class="form-control" placeholder="E-mail" autocomplete="off">
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn">Отправить</button>
                    </div>
                </form>

                <a href="#authorization" data-bs-toggle="modal" data-bs-dismiss="modal"
                   class="link-small">Авторизация</a>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {
            $('#recovery').on('submit', function (e) {
                $('#recovery div.alert-success').addClass('d-none');
                $('#recovery div.alert-danger').addClass('d-none');
                $('#recovery div.alert-success').empty();
                $('#recovery div.alert-danger').empty();
                $('#recovery button').attr('disabled', true);

                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('recovery.create') }}',
                    data: $('#recovery').serialize(),
                    headers: {
                        'Accept': 'application/json, text-plain, */*'
                    },
                    success: function (data) {
                        let message = data.success;
                        $('#recovery div.alert-success').append(message);
                        $('#recovery div.alert-success').removeClass('d-none');
                    },
                    error: function (data) {
                        $('#recovery button').attr('disabled', false);
                        let message = get_message(data);
                        $('#recovery div.alert-danger').append(message);
                        $('#recovery div.alert-danger').removeClass('d-none');
                        $('#recovery').scrollTop(0);
                    }
                });
            });
        });
    </script>
