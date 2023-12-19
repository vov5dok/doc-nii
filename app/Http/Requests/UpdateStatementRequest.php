<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth('moonshine')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'                 => 'min:0|max:255',
            'current_procedure_id' => 'required|string|exists:procedures,id',
            'file'                 => 'nullable|array',
            'file.*'               => 'file',
        ];
    }

    public function messages(): array
    {
        return [
            'name.min'                      => 'Название должно содержать хотя бы один символ',
            'name.max'                      => 'Название не должно быть длиннее 255 символов',
            'current_procedure_id.required' => 'Вы забыли указать процедуру',
            'current_procedure_id.exists'   => 'Указанная процедура не существует, обратитесь к администратору для добавления',
            'file.required'                 => 'Должен быть прикреплен хотя бы один файл',
            'file.*.max'                    => 'Размер файла не должен превышать 10 МБ.',
        ];
    }
}
