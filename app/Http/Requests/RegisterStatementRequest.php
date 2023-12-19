<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStatementRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'statement_status_id' => 'required|integer|exists:statement_statuses,id',
            'registration_number' => 'required|string|min:0|max:255',
            'registration_date'   => 'required|date',
            'session_date'        => 'nullable|date',
            'file'                => 'required|array',
            'file.*'              => 'required|file',
            'statement_experts'   => 'nullable|array',
            'statement_experts.*' => 'nullable|integer|exists:moonshine_users,id'
        ];
    }

    public function messages(): array
    {
        return [
            'statement_status_id.required' => 'Статус должен быть указан',
            'statement_status_id.integer'  => 'Статус должен быть числом',
            'statement_status_id.exists'   => 'Указанный статус не существует, обратитесь к администратору',
            'registration_number.required' => 'Номер регистрации должен быть указан',
            'registration_number.string'   => 'Номер регистрации должен быть строкой',
            'registration_number.min'      => 'Номер регистрации должен содержать больше одного символа',
            'registration_number.max'      => 'Номер регистрации не должен содержать больше 255 символов',
        ];
    }
}
