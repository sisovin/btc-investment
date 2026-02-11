<?php

namespace App\Validation;

class RegisterValidator
{
    /**
     * Validation rules for registration
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50'
        ];
    }
}