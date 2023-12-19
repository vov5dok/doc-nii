<?php

namespace App\Rules;

use App\Models\MoonshineUser;
use Illuminate\Contracts\Validation\Rule;

class UserIsActive implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Проверка на активность, чтобы неактивный пользователь не смог получить доступ в лк.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $user = MoonshineUser::where('email', $value)->firstOrFail();
        return MoonshineUser::IS_ACTIVE === $user->active;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Пользователь неактивен. Обратитесь в службу поддержки.';
    }
}
