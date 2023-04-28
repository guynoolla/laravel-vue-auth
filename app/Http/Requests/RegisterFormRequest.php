<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\DbLog\AuthDbLog;

class RegisterFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'email' => ['required', 'email:rfc,dns,filter', 'unique:users'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'min:6', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute является обязательным.',
            'max' => 'Поле :attribute не должен содержать более 100 символов',
            'email' => 'Не соответствовует формату email адреса.',
            'unique' => 'Пользователь с данным :attribute зарегистрирован.',
            'min' => 'Пароль должен содержать не менее 6 символов.',
            'same' => 'Пароли не совпадают.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        AuthDbLog::authFailed($validator->errors());

        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'errors' => $validator->errors(), 422
            ])
        );
    }
}
