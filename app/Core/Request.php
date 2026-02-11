<?php

namespace App\Core;

class Request
{
    private static $instance = null;
    private $data = [];
    private $errors = [];
    private $files = [];

    /**
     * Set the global instance
     */
    public static function setInstance(Request $instance)
    {
        self::$instance = $instance;
    }

    /**
     * Get the global instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parseRequest();
    }

    /**
     * Parse request data
     */
    private function parseRequest()
    {
        // GET parameters
        $this->data = array_merge($this->data, $_GET);

        // POST parameters
        if ($this->isPost()) {
            $this->data = array_merge($this->data, $_POST);
        }

        // PUT/PATCH/DELETE parameters
        if (in_array($this->method(), ['PUT', 'PATCH', 'DELETE'])) {
            parse_str(file_get_contents('php://input'), $putData);
            $this->data = array_merge($this->data, $putData);
        }

        // JSON data
        if ($this->isJson()) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            if ($jsonData) {
                $this->data = array_merge($this->data, $jsonData);
            }
        }

        // Files
        $this->files = $_FILES;
    }

    /**
     * Get request data
     */
    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }

        return $this->data[$key] ?? $default;
    }

    /**
     * Get all request data
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Check if key exists
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Get request method
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Check if POST request
     */
    public function isPost()
    {
        return $this->method() === 'POST';
    }

    /**
     * Check if GET request
     */
    public function isGet()
    {
        return $this->method() === 'GET';
    }

    /**
     * Get request URI
     */
    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get request path
     */
    public function path()
    {
        return parse_url($this->uri(), PHP_URL_PATH);
    }

    /**
     * Get query string
     */
    public function queryString()
    {
        return $_SERVER['QUERY_STRING'] ?? '';
    }

    /**
     * Get client IP
     */
    public function ip()
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR'] ??
               $_SERVER['HTTP_CLIENT_IP'] ??
               $_SERVER['REMOTE_ADDR'] ??
               '127.0.0.1';
    }

    /**
     * Get user agent
     */
    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * Check if HTTPS
     */
    public function isSecure()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               $_SERVER['SERVER_PORT'] == 443;
    }

    /**
     * Check if AJAX request
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Check if API request
     */
    public function isApi()
    {
        $headers = getallheaders();
        return isset($headers['Accept']) &&
               strpos($headers['Accept'], 'application/json') !== false;
    }

    /**
     * Check if JSON request
     */
    public function isJson()
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        return strpos($contentType, 'application/json') !== false;
    }

    /**
     * Check if the current URI matches the given pattern
     */
    public function is($pattern)
    {
        $uri = $this->uri();
        
        // Simple pattern matching (can be enhanced with regex)
        if ($pattern === '/') {
            return $uri === '/';
        }
        
        // Remove trailing slashes for comparison
        $pattern = rtrim($pattern, '/');
        $uri = rtrim($uri, '/');
        
        return $uri === $pattern || strpos($uri, $pattern) === 0;
    }

    /**
     * Get specific header
     */
    public function header($key, $default = null)
    {
        $headers = $this->headers();
        return $headers[$key] ?? $default;
    }

    /**
     * Get authorization header
     */
    public function bearerToken()
    {
        $authHeader = $this->header('Authorization');
        if ($authHeader && preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Get uploaded files
     */
    public function files($key = null)
    {
        if ($key === null) {
            return $this->files;
        }

        return $this->files[$key] ?? null;
    }

    /**
     * Check if file uploaded
     */
    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] !== UPLOAD_ERR_NO_FILE;
    }

    /**
     * Validate request data
     */
    public function validate(array $rules, array $messages = [])
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $this->get($field);

            if (is_string($fieldRules)) {
                $fieldRules = explode('|', $fieldRules);
            }

            foreach ($fieldRules as $rule) {
                if (!$this->validateRule($field, $value, $rule)) {
                    $message = $messages["{$field}.{$rule}"] ??
                              $messages[$field] ??
                              $this->getDefaultMessage($field, $rule);
                    $this->errors[$field][] = $message;
                    break; // Stop at first error for this field
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Validate single rule
     */
    private function validateRule($field, $value, $rule)
    {
        list($ruleName, $parameter) = array_pad(explode(':', $rule, 2), 2, null);

        switch ($ruleName) {
            case 'required':
                return !empty($value) || $value === '0' || $value === 0;

            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;

            case 'numeric':
                return is_numeric($value);

            case 'integer':
                return filter_var($value, FILTER_VALIDATE_INT) !== false;

            case 'float':
                return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;

            case 'string':
                return is_string($value);

            case 'min':
                if (is_numeric($value)) {
                    return $value >= $parameter;
                }
                return strlen($value) >= $parameter;

            case 'max':
                if (is_numeric($value)) {
                    return $value <= $parameter;
                }
                return strlen($value) <= $parameter;

            case 'between':
                list($min, $max) = explode(',', $parameter);
                if (is_numeric($value)) {
                    return $value >= $min && $value <= $max;
                }
                $length = strlen($value);
                return $length >= $min && $length <= $max;

            case 'in':
                $options = explode(',', $parameter);
                return in_array($value, $options);

            case 'confirmed':
                $confirmField = $field . '_confirmation';
                return $value === $this->get($confirmField);

            case 'unique':
                // Basic unique validation (would need table and column)
                return true; // Placeholder

            default:
                return true;
        }
    }

    /**
     * Get default validation message
     */
    private function getDefaultMessage($field, $rule)
    {
        $messages = [
            'required' => "The {$field} field is required.",
            'email' => "The {$field} must be a valid email address.",
            'numeric' => "The {$field} must be a number.",
            'integer' => "The {$field} must be an integer.",
            'float' => "The {$field} must be a decimal number.",
            'string' => "The {$field} must be a string.",
            'min' => "The {$field} must be at least :parameter.",
            'max' => "The {$field} may not be greater than :parameter.",
            'between' => "The {$field} must be between :min and :max.",
            'in' => "The selected {$field} is invalid.",
            'confirmed' => "The {$field} confirmation does not match.",
            'unique' => "The {$field} has already been taken."
        ];

        return $messages[$rule] ?? "The {$field} is invalid.";
    }

    /**
     * Check if validation failed
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Get validation errors
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Get first error for field
     */
    public function firstError($field)
    {
        return $this->errors[$field][0] ?? null;
    }

    /**
     * Get all errors as string
     */
    public function errorsString()
    {
        $messages = [];
        foreach ($this->errors as $field => $fieldErrors) {
            $messages = array_merge($messages, $fieldErrors);
        }
        return implode(' ', $messages);
    }
}