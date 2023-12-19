<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeAvatarRequest extends FormRequest
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
            'avatar' => 'bail|required|file|mimes:jpg,jpeg,png,gif',
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
            'avatar.required' => 'Фото не было загружено',
            'avatar.file' => 'Фото должно быть файлом.',
            'avatar.mimes' => 'Фото должно быть изображением формата: jpg, jpeg, png, gif.',
        ];
    }
}
