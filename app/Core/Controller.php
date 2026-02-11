<?php

namespace App\Core;

use App\Models\User;
use App\Models\Admin;

abstract class Controller
{
    protected $user;
    protected $admin;
    protected $request;
    protected $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->admin = Auth::admin();
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * Get authenticated user
     */
    protected function user()
    {
        return $this->user;
    }

    /**
     * Get authenticated admin
     */
    protected function admin()
    {
        return $this->admin;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated()
    {
        return Auth::check();
    }

    /**
     * Check if admin is authenticated
     */
    protected function isAdmin()
    {
        return Auth::checkAdmin();
    }

    /**
     * Require authentication
     */
    protected function requireAuth()
    {
        Auth::requireAuth();
    }

    /**
     * Require admin authentication
     */
    protected function requireAdmin()
    {
        Auth::requireAdmin();
    }

    /**
     * Get request data
     */
    protected function request($key = null, $default = null)
    {
        return $this->request->get($key, $default);
    }

    /**
     * Get all request data
     */
    protected function all()
    {
        return $this->request->all();
    }

    /**
     * Validate request data
     */
    protected function validate(array $rules, array $messages = [])
    {
        return $this->request->validate($rules, $messages);
    }

    /**
     * Check if request has validation errors
     */
    protected function hasErrors()
    {
        return $this->request->hasErrors();
    }

    /**
     * Get validation errors
     */
    protected function errors()
    {
        return $this->request->errors();
    }

    /**
     * Redirect to URL
     */
    protected function redirect($url, $statusCode = 302)
    {
        return $this->response->redirect($url, $statusCode);
    }

    /**
     * Redirect back
     */
    protected function back()
    {
        return $this->response->back();
    }

    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200)
    {
        return $this->response->json($data, $statusCode);
    }

    /**
     * Return view
     */
    protected function view($view, $data = [], $status = 200)
    {
        return $this->response->status($status)->view($view, $data);
    }

    /**
     * Return success response
     */
    protected function success($message = 'Success', $data = [])
    {
        return $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Return error response
     */
    protected function error($message = 'Error', $errors = [], $statusCode = 400)
    {
        return $this->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Set flash message
     */
    protected function flash($key, $value)
    {
        Session::flash($key, $value);
    }

    /**
     * Get flash message
     */
    protected function getFlash($key)
    {
        return Session::getFlash($key);
    }

    /**
     * Check if request is AJAX
     */
    protected function isAjax()
    {
        return $this->request->isAjax();
    }

    /**
     * Check if request is API request
     */
    protected function isApi()
    {
        return $this->request->isApi();
    }

    /**
     * Get request method
     */
    protected function method()
    {
        return $this->request->method();
    }

    /**
     * Get request URI
     */
    protected function uri()
    {
        return $this->request->uri();
    }

    /**
     * Get client IP
     */
    protected function ip()
    {
        return $this->request->ip();
    }

    /**
     * Get user agent
     */
    protected function userAgent()
    {
        return $this->request->userAgent();
    }

    /**
     * Log activity
     */
    protected function logActivity($action, $description = '')
    {
        // Implement activity logging
        // Could log to database or file
    }

    /**
     * Check permission
     */
    protected function can($permission)
    {
        return Auth::hasPermission($permission);
    }

    /**
     * Check if user owns resource
     */
    protected function owns($resource)
    {
        return Auth::owns($resource, $resource->id ?? null);
    }

    /**
     * Paginate results
     */
    protected function paginate($query, $perPage = 15, $page = null)
    {
        $page = $page ?: ($this->request('page', 1));
        $offset = ($page - 1) * $perPage;

        // This is a basic implementation
        // In a real application, you'd use a more sophisticated pagination class
        $total = count($query); // This is inefficient for large datasets
        $items = array_slice($query, $offset, $perPage);

        return [
            'data' => $items,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total)
        ];
    }
}