@extends('layouts.app')

@section('content')
    <div class="profile__form">
        <h2 class="profile__form-title">Изменение пароля</h2>

        <form method="post" action="{{ route('recovery.change') }}">
            @csrf

            <div class="profile__form-alert">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($success)
                <div class="alert alert-success">
                    {{ $success }}
                </div>
                @endif

            </div>

            <div class="row-form-group hidden">
                <div class="col-form-input">
                    <input name="token" hidden type="text" class="form-control" value="{{ $token }}" required>
                </div>
            </div>

            <div class="row-form-group">
                <label class="col-form-label">Новый пароль *</label>
                <div class="col-form-input">
                    <input name="password" type="password" class="form-control" autocomplete="new-password" required>
                </div>
            </div>

            <div class="row-form-group">
                <label class="col-form-label">Повторите новый пароль *</label>
                <div class="col-form-input">
                    <input name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required>
                </div>
            </div>

            <div class="form-submit">
                <button type="submit" class="btn">Сменить пароль</button>
            </div>
        </form>
    </div>
@endsection
