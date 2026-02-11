<?php

namespace App\Core;

class Response
{
    private $headers = [];
    private $statusCode = 200;
    private $content = '';

    /**
     * Set HTTP status code
     */
    public function status($code)
    {
        $this->statusCode = $code;
        http_response_code($code);
        return $this;
    }

    /**
     * Set header
     */
    public function header($key, $value)
    {
        $this->headers[$key] = $value;
        header("{$key}: {$value}");
        return $this;
    }

    /**
     * Set content type
     */
    public function type($type)
    {
        return $this->header('Content-Type', $type);
    }

    /**
     * Set JSON content type
     */
    public function asJson()
    {
        return $this->type('application/json');
    }

    /**
     * Set HTML content type
     */
    public function asHtml()
    {
        return $this->type('text/html');
    }

    /**
     * Set plain text content type
     */
    public function asText()
    {
        return $this->type('text/plain');
    }

    /**
     * Set content
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Send response
     */
    public function send($content = null)
    {
        if ($content !== null) {
            $this->content = $content;
        }

        // Send headers
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        // Set status code
        http_response_code($this->statusCode);

        // Send content
        echo $this->content;
        exit;
    }

    /**
     * Send JSON response
     */
    public function json($data, $statusCode = 200)
    {
        $this->status($statusCode)->asJson();
        return $this->send(json_encode($data));
    }

    /**
     * Send HTML response
     */
    public function html($content, $statusCode = 200)
    {
        $this->status($statusCode)->asHtml();
        return $this->send($content);
    }

    /**
     * Send plain text response
     */
    public function text($content, $statusCode = 200)
    {
        $this->status($statusCode)->asText();
        return $this->send($content);
    }

    /**
     * Redirect to URL
     */
    public function redirect($url, $statusCode = 302)
    {
        $this->status($statusCode)->header('Location', $url);
        exit;
    }

    /**
     * Redirect back to previous page
     */
    public function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        return $this->redirect($referer);
    }

    /**
     * Render view
     */
    public function view($view, $data = [])
    {
        $content = View::render($view, $data);
        return $this->html($content);
    }

    /**
     * Download file
     */
    public function download($filePath, $fileName = null)
    {
        if (!file_exists($filePath)) {
            return $this->status(404)->text('File not found');
        }

        $fileName = $fileName ?: basename($filePath);

        $this->header('Content-Type', 'application/octet-stream');
        $this->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $this->header('Content-Length', filesize($filePath));

        readfile($filePath);
        exit;
    }

    /**
     * Set cookie
     */
    public function cookie($name, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        return $this;
    }

    /**
     * Clear cookie
     */
    public function clearCookie($name, $path = '/')
    {
        return $this->cookie($name, '', time() - 3600, $path);
    }

    /**
     * Set cache headers
     */
    public function cache($seconds)
    {
        $this->header('Cache-Control', 'max-age=' . $seconds);
        $this->header('Expires', gmdate('D, d M Y H:i:s', time() + $seconds) . ' GMT');
        return $this;
    }

    /**
     * Set no-cache headers
     */
    public function noCache()
    {
        $this->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->header('Pragma', 'no-cache');
        $this->header('Expires', '0');
        return $this;
    }

    /**
     * Set CORS headers
     */
    public function cors($origin = '*', $methods = 'GET, POST, PUT, DELETE, OPTIONS', $headers = 'Content-Type, Authorization')
    {
        $this->header('Access-Control-Allow-Origin', $origin);
        $this->header('Access-Control-Allow-Methods', $methods);
        $this->header('Access-Control-Allow-Headers', $headers);
        return $this;
    }

    /**
     * Handle preflight OPTIONS request
     */
    public function handleOptions()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->status(200)->cors()->send('');
        }
    }

    /**
     * Send success response
     */
    public function success($message = 'Success', $data = [], $statusCode = 200)
    {
        return $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send error response
     */
    public function error($message = 'Error', $errors = [], $statusCode = 400)
    {
        return $this->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Send validation error response
     */
    public function validationError($errors, $message = 'Validation failed')
    {
        return $this->error($message, $errors, 422);
    }

    /**
     * Send unauthorized response
     */
    public function unauthorized($message = 'Unauthorized')
    {
        return $this->error($message, [], 401);
    }

    /**
     * Send forbidden response
     */
    public function forbidden($message = 'Forbidden')
    {
        return $this->error($message, [], 403);
    }

    /**
     * Send not found response
     */
    public function notFound($message = 'Not found')
    {
        return $this->error($message, [], 404);
    }

    /**
     * Send server error response
     */
    public function serverError($message = 'Internal server error')
    {
        return $this->error($message, [], 500);
    }

    /**
     * Get response content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}