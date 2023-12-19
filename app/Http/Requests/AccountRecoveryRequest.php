<?php

namespace App\Http\Requests;

use App\Rules\UserIsActive;
use Illuminate\Foundation\Http\FormRequest;

class AccountRecoveryRequest extends FormRequest
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
            'email' => [
                'bail',
                'exists:moonshine_users',
                new UserIsActive()
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Пользователь с такой электронной почтой не существует.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => (string)str(request('email'))
                ->lower()
                ->trim(),
        ]);
    }
}
