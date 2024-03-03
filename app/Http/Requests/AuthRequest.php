<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'phone.required' => 'Рақам киритиш шарт',
            'phone.unique' => 'Бундай рақам мавжуд',
            'password.required' => 'Парол киритиш шарт',
            'password.string' => 'Парол ҳарфлардан иборат бўлиши шарт',
            'password.min' => 'Парол камида 6 та ҳарфдан иборат бўлиши шарт',
            'password.confirmed' => 'Пароллар мос келмайди',
            'verification_code.required' => 'Тасдиқлаш кодини киритиш шарт'
        ];
    }

    public function rules(): array
    {
        return match ($this->route()->getName()) {
            'login' => [
                'phone' => 'required',
                'password' => 'required'
            ],
            'register' => [
                'phone' => 'required|unique:users',
                'password' => 'required|string|min:6|confirmed'
            ],
            'verify-phone' => [
                'verification_code' => 'required|numeric'
            ],
            default => []
        };
    }
}
