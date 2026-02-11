<?php

namespace App\Core;

use Exception;

class View
{
    private static $data = [];
    private static $layout = 'layouts/app';
    private static $sections = [];
    private static $currentSection = null;

    /**
     * Render a view
     */
    public static function render($view, $data = [])
    {
        self::$data = array_merge(self::$data, $data);

        // Extract data to variables
        extract(self::$data);

        // Start output buffering
        ob_start();

        try {
            $viewFile = self::getViewFile($view);

            if (!file_exists($viewFile)) {
                throw new Exception("View file not found: {$viewFile}");
            }

            // Compile template
            $compiledContent = self::compile(file_get_contents($viewFile));
            
            // Write to temporary file and include
            $tempFile = __DIR__ . '/../../debug_compiled.php';
            file_put_contents($tempFile, $compiledContent);
            
            // Helper functions are defined globally in helpers.php
            
            include $tempFile;
            
            $content = ob_get_clean();

            // Render layout if set
            if (self::$layout) {
                $content = self::renderLayout($content, $data);
            }

            return $content;

        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }
    }

    /**
     * Get view file path
     */
    private static function getViewFile($view)
    {
        $view = str_replace('.', '/', $view);
        return __DIR__ . "/../Views/{$view}.php";
    }

    /**
     * Compile template
     */
    private static function compile($content)
    {
        // Convert @extends to View::extends
        $content = preg_replace('/@extends\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', '<?php \App\Core\View::extends(\'$1\'); ?>', $content);

        // Convert @section to View::section
        $content = preg_replace('/@section\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', '<?php \App\Core\View::section(\'$1\'); ?>', $content);

        // Convert @endsection to View::endsection
        $content = preg_replace('/@endsection/', '<?php \App\Core\View::endsection(); ?>', $content);

        // Convert @yield to View::yield
        $content = preg_replace('/@yield\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', '<?php echo \App\Core\View::yield(\'$1\'); ?>', $content);

        // Convert @include to View::include
        $content = preg_replace('/@include\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', '<?php \App\Core\View::include(\'$1\'); ?>', $content);

        // Convert {{ }} to <?php echo
        $content = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?php echo htmlspecialchars($1, ENT_QUOTES, \'UTF-8\'); ?>', $content);

        // Convert {!! !!} to <?php echo (without escaping)
        $content = preg_replace('/\{\!\!\s*(.+?)\s*\!\!\}/', '<?php echo $1; ?>', $content);

        // Convert @if to <?php if (handles nested parentheses)
        while (preg_match('/@if\s*\(/', $content, $matches, PREG_OFFSET_CAPTURE)) {
            $pos = $matches[0][1];
            $start = $pos + strlen($matches[0][0]);
            $level = 1;
            $condition = '';
            
            while ($start < strlen($content) && $level > 0) {
                $char = $content[$start];
                if ($char === '(') $level++;
                elseif ($char === ')') $level--;
                
                if ($level > 0) $condition .= $char;
                $start++;
            }
            
            $fullMatch = substr($content, $pos, $start - $pos);
            $replacement = "<?php if({$condition}): ?>";
            $content = substr_replace($content, $replacement, $pos, strlen($fullMatch));
        }

        // Convert @else to <?php else
        $content = preg_replace('/@else/', '<?php else: ?>', $content);

        // Convert @elseif to <?php elseif
        $content = preg_replace('/@elseif\s*\(([^)]+)\)/', '<?php elseif($1): ?>', $content);

        // Convert @endif to <?php endif
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);

        // Convert @foreach to <?php foreach
        $content = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach($1): ?>', $content);

        // Convert @endforeach to <?php endforeach
        $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);

        // Convert @for to <?php for
        $content = preg_replace('/@for\s*\(([^)]+)\)/', '<?php for($1): ?>', $content);

        // Convert @endfor to <?php endfor
        $content = preg_replace('/@endfor/', '<?php endfor; ?>', $content);

        return $content;
    }

    /**
     * Render layout
     */
    private static function renderLayout($content, $data = [])
    {
        self::$data['content'] = $content;
        extract(self::$data);

        ob_start();

        try {
            $layoutFile = self::getViewFile(self::$layout);

            if (!file_exists($layoutFile)) {
                throw new Exception("Layout file not found: {$layoutFile}");
            }

            // Helper functions are defined globally in helpers.php

            include $layoutFile;
            return ob_get_clean();

        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }
    }

    /**
     * Set layout
     */
    public static function layout($layout)
    {
        self::$layout = $layout;
    }

    /**
     * Extend layout
     */
    public static function extends($layout)
    {
        self::$layout = $layout;
    }

    /**
     * Start section
     */
    public static function section($name)
    {
        self::$currentSection = $name;
        ob_start();
    }

    /**
     * End section
     */
    public static function endsection()
    {
        if (self::$currentSection) {
            self::$sections[self::$currentSection] = ob_get_clean();
            self::$currentSection = null;
        }
    }

    /**
     * Yield section
     */
    public static function yield($name, $default = '')
    {
        return self::$sections[$name] ?? $default;
    }

    /**
     * Include partial view
     */
    public static function include($view, $data = [])
    {
        $data = array_merge(self::$data, $data);
        extract($data);

        $viewFile = self::getViewFile($view);

        if (!file_exists($viewFile)) {
            throw new Exception("Partial view file not found: {$viewFile}");
        }

        include $viewFile;
    }

    /**
     * Share data with all views
     */
    public static function share($key, $value = null)
    {
        if (is_array($key)) {
            self::$data = array_merge(self::$data, $key);
        } else {
            self::$data[$key] = $value;
        }
    }

    /**
     * Get shared data
     */
    public static function getShared($key = null)
    {
        if ($key === null) {
            return self::$data;
        }

        return self::$data[$key] ?? null;
    }

    /**
     * Check if view exists
     */
    public static function exists($view)
    {
        return file_exists(self::getViewFile($view));
    }

    /**
     * Render view with data (alternative method)
     */
    public function __invoke($view, $data = [])
    {
        return self::render($view, $data);
    }

    /**
     * Escape HTML
     */
    public static function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Format currency
     */
    public static function currency($amount, $currency = 'USD')
    {
        return number_format($amount, 2) . ' ' . $currency;
    }

    /**
     * Format date
     */
    public static function date($date, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($date));
    }

    /**
     * Truncate text
     */
    public static function truncate($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . $suffix;
    }

    /**
     * Generate URL
     */
    public static function url($path = '')
    {
        $baseUrl = getenv('APP_URL') ?: 'http://localhost';
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Generate asset URL
     */
    public static function asset($path)
    {
        return self::url('assets/' . ltrim($path, '/'));
    }

    /**
     * Generate route URL
     */
    public static function route($name, $params = [])
    {
        return Router::url($name, $params);
    }

    /**
     * Check if current route matches
     */
    public static function isActive($route)
    {
        $currentRoute = Router::currentRoute();
        return $currentRoute && $currentRoute['path'] === $route;
    }

    /**
     * Get CSRF token
     */
    public static function csrf()
    {
        return Session::getCsrfToken();
    }

    /**
     * Render CSRF field
     */
    public static function csrfField()
    {
        return '<input type="hidden" name="_token" value="' . self::csrf() . '">';
    }

    /**
     * Render flash messages
     */
    public static function flash($type = null)
    {
        $messages = Session::getFlashMessages();

        if ($type) {
            return $messages[$type] ?? [];
        }

        return $messages;
    }

    /**
     * Check if user is authenticated
     */
    public static function auth()
    {
        return Auth::check();
    }

    /**
     * Get authenticated user
     */
    public static function user()
    {
        return Auth::user();
    }

    /**
     * Check if admin is authenticated
     */
    public static function admin()
    {
        return Auth::checkAdmin();
    }

    /**
     * Get authenticated admin
     */
    public static function adminUser()
    {
        return Auth::admin();
    }
}