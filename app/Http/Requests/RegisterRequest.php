<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'                      => 'bail|required|email:rfc,dns|unique:moonshine_users,email',
            'password'                   => 'bail|required|min:8',
            'second_name'                => 'bail|required',
            'name'                       => 'bail|required',
            'last_name'                  => 'bail|required',
            'organization'               => 'bail|required',
            'data_processing_permission' => 'bail|required',
            'password_confirmation'      => 'bail|required|same:password',
            'position'                   => 'bail|required',
            'phone'                      => 'bail|required_without:phone_additional',
            'phone_additional'           => 'bail|required_without:phone',
            'captcha'                    => 'bail|required|captcha',
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
            'email.unique'                        => 'Пользователь с такой электронной почтой уже существует.',
            'data_processing_permission.required' => 'Вы должны согласиться с условиями обработки персональных данных.',
            'captcha'                             => 'Вы ввели неверный код с картинки.',
            'email.email'                         => 'Вы ввели некорректный email.',
            'password.min'                        => 'Пароль должен содержать не менее 8 символов.',
            'password_confirmation.same'          => 'Введённые вами пароли не совпадают.',
            'phone.required_without'              => 'Должен быть заполнен номер телефона.',
            'phone_additional.required_without'   => 'Должен быть заполнен номер телефона.',
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
