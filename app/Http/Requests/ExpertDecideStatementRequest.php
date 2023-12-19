<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpertDecideStatementRequest extends FormRequest
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
            'text'           => 'required|string|min:0|max:255',
            'file'           => 'required|array',
            'file.*'         => 'required|file',
            'delete_files'   => 'nullable|array',
            'delete_files.*' => 'nullable|integer|exists:statement_files,id',
        ];
    }
}
