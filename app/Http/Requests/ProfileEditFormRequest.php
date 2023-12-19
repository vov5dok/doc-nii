<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileEditFormRequest extends FormRequest
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
            'email' => [
                'bail',
                'email:rfc,dns',
                Rule::unique('moonshine_users')->ignore($this->user('moonshine')->id),
            ],
            'second_name' => 'bail|required',
            'name' => 'bail|required',
            'last_name' => 'bail|required',
        ];
    }
}
