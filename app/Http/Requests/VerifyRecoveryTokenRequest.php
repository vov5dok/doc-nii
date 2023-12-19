<?php

namespace App\Http\Requests;

use App\Rules\RecoveryTokenIsValid;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRecoveryTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('moonshine')->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'token' => new RecoveryTokenIsValid()
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Пароль должен содержать не менее 8 символов.',
            'password_confirmation.same' => 'Введенные вами пароли не совпадают.',
        ];
    }
}
