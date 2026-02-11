<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;
use App\Validation\LoginValidator;
use App\Validation\RegisterValidator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirect('/dashboard');
        }

        \App\Core\View::layout(null);
        return $this->view('user.auth.login', [
            'title' => 'Login - BTC Investment'
        ]);
    }

    /**
     * Process login
     */
    public function login()
    {
        $validator = new LoginValidator();
        $data = $this->request->validate($validator->rules());

        if ($data === false) {
            return $this->redirect('/login')->with('errors', $this->request->errors());
        }

        if (Auth::attempt($data['email'], $data['password'])) {
            return $this->redirect('/dashboard');
        }

        return $this->redirect('/login')->with('error', 'Invalid credentials');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirect('/dashboard');
        }

        \App\Core\View::layout(null);
        return $this->view('user.auth.register', [
            'title' => 'Register - BTC Investment'
        ]);
    }

    /**
     * Process registration
     */
    public function register()
    {
        $validator = new RegisterValidator();
        $data = $this->request->validate($validator->rules());

        if ($data === false) {
            return $this->redirect('/register')->with('errors', $this->request->errors());
        }

        // Check if user already exists
        if (User::where('email', $data['email'])->exists()) {
            return $this->redirect('/register')->with('error', 'Email already exists');
        }

        // Create user
        $user = User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_ARGON2ID),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'status' => 'active',
            'email_verified_at' => null
        ]);

        // Log the user in
        Auth::login($user);

        return $this->redirect('/dashboard')->with('success', 'Registration successful!');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        return $this->redirect('/')->with('success', 'Logged out successfully');
    }
}