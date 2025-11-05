<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id'); // route parametresinden user id alıyoruz

        return [
            'name' => 'required|string|max:100|min:3',
            'email' => "required|email|unique:users,email,{$userId}",
            'password' => 'nullable|min:6|max:18|confirmed', // artık opsiyonel
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Adınızı giriniz!",
            'name.max' => "Adınızı maksimum 100 karakter girebilirsiniz!",
            'name.min' => "Adınızı minimum 3 karakter girebilirsiniz!",
            'password.min' => "Şifrenizi minimum 6 karakter girebilirsiniz!",
            'password.max' => "Şifrenizi maksimum 18 karakter girebilirsiniz!",
            'password.confirmed' => 'Şifre tekrarı uyuşmuyor!',
            'email.required' => "E-Postanızı giriniz!",
            'email.email' => "Email türünde giriniz!",
            'email.unique' => "Farklı bir mail adresi giriniz!",
            'profile_image.image' => 'Profil resmi bir resim dosyası olmalıdır!',
            'profile_image.mimes' => 'Profil resmi jpg, jpeg, png veya gif formatında olmalıdır!',
            'profile_image.max' => 'Profil resmi maksimum 2MB olabilir!',
        ];
    }
}

