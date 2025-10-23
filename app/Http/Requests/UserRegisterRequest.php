<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:18|confirmed',
            'channel_name' => 'required|string|max:100|min:3|unique:channels,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Adınızı giriniz!",
            'name.max' => "Adınızı maksimum 100 karakter girebilirsiniz!",
            'name.min' => "Adınızı minimum 3 karakter girebilirsiniz!",
            'password.required' => "Şifrenizi giriniz!",
            'password.min' => "Şifrenizi minimum 6 karakter girebilirsiniz!",
            'password.max' => "Şifrenizi maksimum 18 karakter girebilirsiniz!",
            'password.confirmed' => 'Şifre tekrarı uyuşmuyor!',
            'email.required' => "E-Postanızı giriniz!",
            'email.email' => "Email türünde giriniz!",
            'email.unique' => "Farklı bir mail adresi giriniz!",
            'channel_name.required' => "Adınızı giriniz!",
            'channel_name.max' => "Adınızı maksimum 100 karakter girebilirsiniz!",
            'channel_name.min' => "Adınızı minimum 3 karakter girebilirsiniz!",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors'  => $validator->errors(),
        ], 422));
    }
}
