<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatementRequest extends FormRequest
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
            'name'                 => 'max:255',
            'file'                 => 'required|array',
            'file.*'               => 'required|file|max:10240',
            'current_procedure_id' => 'required|integer|exists:procedures,id',
            'comment'              => 'nullable|string|max:2048',
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
            'name.max'                      => 'Поле "наименование" не должно быть длинее 255 символов',
            'file.required'                 => 'Должен быть прикреплен хотя бы один файл',
            'file.*.max'                    => 'Размер файла не должен превышать 10 МБ.',
            'current_procedure_id.required' => 'Вы забыли указать процедуру',
            'current_procedure_id.exists'   => 'Указанная процедура не существует, обратитесь к администратору для добавления',
            'comment.string'                => 'Поле "комментарий" должно быть строкой',
            'comment.max'                   => 'Поле "комментарий" не должно быть длинее 2048 символов',
        ];
    }
}
