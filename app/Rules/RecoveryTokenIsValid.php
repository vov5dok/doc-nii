<?php

namespace App\Rules;

use App\Models\MoonshineUser;
use Illuminate\Contracts\Validation\Rule;

class RecoveryTokenIsValid implements Rule
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
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = MoonshineUser::where('remember_token', $value)->firstOrFail();
        return $user->remember_token === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ваш код восстановления недействителен, пожалуйста повторите попытку.';
    }
}
