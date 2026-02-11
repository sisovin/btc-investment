<?php

namespace App\Validation;

class LoginValidator
{
    /**
     * Validation rules for login
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }
}