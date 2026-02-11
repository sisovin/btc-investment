<?php

namespace App\Core;

use Exception;

class Router
{
    private static $routes = [];
    private static $middlewares = [];
    private static $currentRoute = null;

    /**
     * Add a route
     */
    public static function add($method, $path, $handler, $middleware = [])
    {
        $pattern = self::convertToRegex($path);
        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => $middleware,
            'params' => self::extractParams($path)
        ];
    }

    /**
     * Add GET route
     */
    public static function get($path, $handler, $middleware = [])
    {
        self::add('GET', $path, $handler, $middleware);
    }

    /**
     * Add POST route
     */
    public static function post($path, $handler, $middleware = [])
    {
        self::add('POST', $path, $handler, $middleware);
    }

    /**
     * Add PUT route
     */
    public static function put($path, $handler, $middleware = [])
    {
        self::add('PUT', $path, $handler, $middleware);
    }

    /**
     * Add DELETE route
     */
    public static function delete($path, $handler, $middleware = [])
    {
        self::add('DELETE', $path, $handler, $middleware);
    }

    /**
     * Add PATCH route
     */
    public static function patch($path, $handler, $middleware = [])
    {
        self::add('PATCH', $path, $handler, $middleware);
    }

    /**
     * Add resource routes
     */
    public static function resource($path, $controller, $middleware = [])
    {
        $routes = [
            ['GET', $path, $controller . '@index'],
            ['GET', $path . '/create', $controller . '@create'],
            ['POST', $path, $controller . '@store'],
            ['GET', $path . '/{id}', $controller . '@show'],
            ['GET', $path . '/{id}/edit', $controller . '@edit'],
            ['PUT', $path . '/{id}', $controller . '@update'],
            ['DELETE', $path . '/{id}', $controller . '@destroy']
        ];

        foreach ($routes as $route) {
            self::add($route[0], $route[1], $route[2], $middleware);
        }
    }

    /**
     * Add route group
     */
    public static function group($attributes, $callback)
    {
        $previousRoutes = self::$routes;
        $prefix = $attributes['prefix'] ?? '';
        $middleware = $attributes['middleware'] ?? [];

        call_user_func($callback);

        // Apply prefix and middleware to new routes
        $newRoutes = array_slice(self::$routes, count($previousRoutes));
        foreach ($newRoutes as &$route) {
            if ($prefix) {
                $route['path'] = $prefix . $route['path'];
                $route['pattern'] = self::convertToRegex($route['path']);
                $route['params'] = self::extractParams($route['path']);
            }
            if ($middleware) {
                $route['middleware'] = array_merge($route['middleware'], $middleware);
            }
        }

        self::$routes = array_merge($previousRoutes, $newRoutes);
    }

    /**
     * Dispatch the request
     */
    public static function dispatch($request = null, $response = null)
    {
        $method = is_object($request) ? $request->method() : ($request ?: $_SERVER['REQUEST_METHOD']);
        $uri = is_object($request) ? $request->path() : ($request ?: parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        // Remove query string
        $uri = strtok($uri, '?');

        // Remove trailing slash except for root
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        foreach (self::$routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                self::$currentRoute = $route;

                // Extract parameters
                $params = [];
                foreach ($route['params'] as $param) {
                    $params[$param] = $matches[$param] ?? null;
                }

                // Run middleware
                if (!self::runMiddleware($route['middleware'])) {
                    return;
                }

                // Call handler
                return self::callHandler($route['handler'], $params);
            }
        }

        // No route found
        self::handleNotFound();
    }

    /**
     * Convert route path to regex pattern
     */
    private static function convertToRegex($path)
    {
        // Escape slashes
        $pattern = preg_quote($path, '/');

        // Convert parameters
        $pattern = preg_replace('/\\\{([^}]+)\\\}/', '(?P<$1>[^/]+)', $pattern);

        // Add start and end anchors
        return '/^' . $pattern . '$/';
    }

    /**
     * Extract parameter names from path
     */
    private static function extractParams($path)
    {
        preg_match_all('/\{([^}]+)\}/', $path, $matches);
        return $matches[1];
    }

    /**
     * Run middleware
     */
    private static function runMiddleware($middlewares)
    {
        foreach ($middlewares as $middleware) {
            if (is_callable($middleware)) {
                if (!$middleware()) {
                    return false;
                }
            } elseif (is_string($middleware)) {
                $middlewareClass = 'App\\Middleware\\' . $middleware;
                if (class_exists($middlewareClass)) {
                    $instance = new $middlewareClass();
                    if (method_exists($instance, 'handle') && !$instance->handle()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Call route handler
     */
    private static function callHandler($handler, $params = [])
    {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }

        if (is_string($handler)) {
            list($controller, $method) = explode('@', $handler);
            $controllerClass = 'App\\Controllers\\' . $controller;

            if (!class_exists($controllerClass)) {
                throw new Exception("Controller {$controllerClass} not found");
            }

            $instance = new $controllerClass();

            if (!method_exists($instance, $method)) {
                throw new Exception("Method {$method} not found in controller {$controllerClass}");
            }

            return call_user_func_array([$instance, $method], $params);
        }

        throw new Exception("Invalid handler: {$handler}");
    }

    /**
     * Handle 404 not found
     */
    private static function handleNotFound()
    {
        http_response_code(404);

        if (self::isApiRequest()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Route not found']);
        } else {
            echo '404 - Page not found';
        }
    }

    /**
     * Check if request is API request
     */
    private static function isApiRequest()
    {
        $headers = getallheaders();
        return isset($headers['Accept']) && strpos($headers['Accept'], 'application/json') !== false;
    }

    /**
     * Get current route
     */
    public static function currentRoute()
    {
        return self::$currentRoute;
    }

    /**
     * Generate URL for named route
     */
    public static function url($name, $params = [])
    {
        // This would require named routes implementation
        // For now, return empty string
        return '';
    }

    /**
     * Get all routes
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Clear all routes
     */
    public static function clear()
    {
        self::$routes = [];
        self::$middlewares = [];
        self::$currentRoute = null;
    }

    /**
     * Add middleware to all routes
     */
    public static function middleware($middleware)
    {
        self::$middlewares[] = $middleware;
    }

    /**
     * Get route parameters
     */
    public static function getParams()
    {
        if (!self::$currentRoute) return [];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');

        preg_match(self::$currentRoute['pattern'], $uri, $matches);

        $params = [];
        foreach (self::$currentRoute['params'] as $param) {
            $params[$param] = $matches[$param] ?? null;
        }

        return $params;
    }
}