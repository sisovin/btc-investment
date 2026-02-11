<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'BTC Investment'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation / localization services provided by the application.
    | This option can be set to any of the locales which will be defined
    | in the list of locales.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'base64:your-32-character-random-string-here'),

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in maintenance mode, all requests will be
    | redirected to a maintenance page. This is useful when you need to
    | perform maintenance on your application.
    |
    */

    'maintenance' => [
        'enabled' => env('APP_MAINTENANCE', false),
        'message' => 'We are currently performing maintenance. Please check back soon.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the session settings for your application.
    | These settings determine how long sessions should be kept alive,
    | where they should be stored, and other session-related options.
    |
    */

    'session' => [
        'lifetime' => env('SESSION_LIFETIME', 120), // minutes
        'path' => '/',
        'domain' => env('SESSION_DOMAIN'),
        'secure' => env('SESSION_SECURE_COOKIE', false),
        'http_only' => true,
        'same_site' => 'lax',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookie Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the cookie settings for your application.
    | These settings determine how long cookies should be kept alive,
    | their security settings, and other cookie-related options.
    |
    */

    'cookie' => [
        'path' => '/',
        'domain' => env('COOKIE_DOMAIN'),
        'secure' => env('COOKIE_SECURE', false),
        'http_only' => true,
        'same_site' => 'lax',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the cache settings for your application.
    | Various cache drivers are available: file, redis, memcached, etc.
    |
    */

    'cache' => [
        'default' => env('CACHE_DRIVER', 'file'),
        'stores' => [
            'file' => [
                'driver' => 'file',
                'path' => storage_path('cache'),
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'cache',
            ],
        ],
        'prefix' => env('CACHE_PREFIX', 'btc_investment'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Filesystem Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the filesystem settings for your application.
    | Various filesystem drivers are available: local, s3, etc.
    |
    */

    'filesystem' => [
        'default' => env('FILESYSTEM_DISK', 'local'),
        'disks' => [
            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
                'throw' => false,
            ],
            'public' => [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => env('APP_URL').'/storage',
                'visibility' => 'public',
                'throw' => false,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the queue settings for your application.
    | Various queue drivers are available: sync, redis, database, etc.
    |
    */

    'queue' => [
        'default' => env('QUEUE_CONNECTION', 'sync'),
        'connections' => [
            'sync' => [
                'driver' => 'sync',
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
                'queue' => env('REDIS_QUEUE', 'default'),
                'retry_after' => 90,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure how your application sends emails.
    | Various mail drivers are available: smtp, mailgun, postmark, etc.
    |
    */

    'mail' => [
        'default' => env('MAIL_MAILER', 'smtp'),
        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'timeout' => null,
            ],
        ],
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@btc-investment.com'),
            'name' => env('MAIL_FROM_NAME', 'BTC Investment'),
        ],
    ],
];