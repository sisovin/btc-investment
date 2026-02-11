<?php

/**
 * Application Routes
 *
 * Define all application routes here.
 * Routes are grouped by functionality for better organization.
 */

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Core\Auth;

// Public routes
App\Core\Router::get('/', 'HomeController@index');
App\Core\Router::get('/about', 'HomeController@about');
App\Core\Router::get('/contact', 'HomeController@contact');
App\Core\Router::get('/plans', 'HomeController@plans');
App\Core\Router::get('/faqs', 'HomeController@faqs');
App\Core\Router::get('/services', 'HomeController@services');

// Authentication routes
App\Core\Router::get('/login', 'AuthController@showLogin');
App\Core\Router::post('/login', 'AuthController@login');
App\Core\Router::get('/register', 'AuthController@showRegister');
App\Core\Router::post('/register', 'AuthController@register');
App\Core\Router::post('/logout', 'AuthController@logout');

// Protected user routes
App\Core\Router::group(['middleware' => ['auth']], function() {
    App\Core\Router::get('/dashboard', 'DashboardController@index');
    App\Core\Router::get('/profile', 'DashboardController@profile');
    App\Core\Router::post('/profile', 'DashboardController@updateProfile');
    App\Core\Router::get('/transactions', 'DashboardController@transactions');
    App\Core\Router::get('/investments', 'DashboardController@investments');
    App\Core\Router::post('/invest', 'DashboardController@invest');
    App\Core\Router::post('/withdraw', 'DashboardController@withdraw');
});

// Admin routes
App\Core\Router::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function() {
    App\Core\Router::get('/', 'AdminController@index');
    App\Core\Router::get('/users', 'AdminController@users');
    App\Core\Router::get('/transactions', 'AdminController@transactions');
    App\Core\Router::get('/investments', 'AdminController@investments');
    App\Core\Router::get('/settings', 'AdminController@settings');
    App\Core\Router::post('/settings', 'AdminController@updateSettings');
    App\Core\Router::post('/user/{id}/status', 'AdminController@updateUserStatus');
});

// API routes
App\Core\Router::group(['prefix' => 'api'], function() {
    App\Core\Router::get('/plans', 'ApiController@plans');
    App\Core\Router::get('/rates', 'ApiController@rates');

    // Protected API routes
    App\Core\Router::group(['middleware' => ['auth']], function() {
        App\Core\Router::get('/user/balance', 'ApiController@userBalance');
        App\Core\Router::get('/user/transactions', 'ApiController@userTransactions');
        App\Core\Router::post('/user/invest', 'ApiController@invest');
        App\Core\Router::post('/user/withdraw', 'ApiController@withdraw');
    });
});