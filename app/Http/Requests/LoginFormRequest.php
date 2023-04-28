<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\DbLog\AuthDbLog;

class LoginFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns,filter'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute является обязательным.',
            'email' => 'Не соответствовует формату email адреса.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        AuthDbLog::authFailed($validator->errors());

        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'errors' => $validator->errors(), 400
            ])
        );
    }
}
