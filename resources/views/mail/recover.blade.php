@component('mail::message')
    # Восстановление пароля

    # Нажмите на кнопку ниже, чтобы перейти на форму восстановления пароля.

    @component('mail::button', ['url' => route('recovery.perform', ['token' => $user->remember_token])])
        Восстановить аккаунт
    @endcomponent

@endcomponent
