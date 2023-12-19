<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('moonshine')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password' => 'bail|required|current_password:moonshine',
            'new_password' => 'bail|required',
            'new_password_repeat' =>'bail|required|same:new_password',
        ];
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Вы должны указать текущий пароль.',
            'current_password.current_password' => 'Введенный вами текущий пароль неверен.',
            'new_password.required' => 'Вы должны указать новый пароль.',
            'new_password_repeat.required' => 'Вы должны указать новый пароль два раза.',
            'new_password_repeat.same' => 'Введенные пароли не совпадают.',
        ];
    }
}
