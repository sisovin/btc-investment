<?php

/**
 * Application Constants
 *
 * This file defines application constants based on environment configuration.
 * These constants are used throughout the application for configuration values.
 */

// Load environment if not already loaded
if (!\App\Config\EnvLoader::has('APP_NAME')) {
    \App\Config\EnvLoader::load();
}

// Application Constants
if (!defined('APP_NAME')) define('APP_NAME', env('APP_NAME', 'BTC Investment'));
if (!defined('APP_ENV')) define('APP_ENV', env('APP_ENV', 'production'));
if (!defined('APP_DEBUG')) define('APP_DEBUG', env('APP_DEBUG', false));
if (!defined('APP_URL')) define('APP_URL', env('APP_URL', 'http://localhost'));
if (!defined('APP_KEY')) define('APP_KEY', env('APP_KEY', 'base64:your-32-character-random-string-here'));
if (!defined('APP_TIMEZONE')) define('APP_TIMEZONE', env('TIMEZONE', 'UTC'));
if (!defined('APP_LOCALE')) define('APP_LOCALE', env('LOCALE', 'en'));

// Database Constants
if (!defined('DB_CONNECTION')) define('DB_CONNECTION', env('DB_CONNECTION', 'mysql'));
if (!defined('DB_HOST')) define('DB_HOST', env('DB_HOST', '127.0.0.1'));
if (!defined('DB_PORT')) define('DB_PORT', env('DB_PORT', 3306));
if (!defined('DB_DATABASE')) define('DB_DATABASE', env('DB_DATABASE', 'btc_investment'));
if (!defined('DB_USERNAME')) define('DB_USERNAME', env('DB_USERNAME', 'root'));
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', env('DB_PASSWORD', ''));

// Redis Constants
if (!defined('REDIS_HOST')) define('REDIS_HOST', env('REDIS_HOST', '127.0.0.1'));
if (!defined('REDIS_PORT')) define('REDIS_PORT', env('REDIS_PORT', 6379));
if (!defined('REDIS_PASSWORD')) define('REDIS_PASSWORD', env('REDIS_PASSWORD', null));

// JWT Constants
if (!defined('JWT_SECRET')) define('JWT_SECRET', env('JWT_SECRET', 'your-jwt-secret-key-change-this-in-production'));

// Session Constants
if (!defined('SESSION_LIFETIME')) define('SESSION_LIFETIME', env('SESSION_LIFETIME', 120));
if (!defined('SESSION_DOMAIN')) define('SESSION_DOMAIN', env('SESSION_DOMAIN', null));
if (!defined('SESSION_SECURE_COOKIE')) define('SESSION_SECURE_COOKIE', env('SESSION_SECURE_COOKIE', false));

// Cookie Constants
if (!defined('COOKIE_DOMAIN')) define('COOKIE_DOMAIN', env('COOKIE_DOMAIN', null));
if (!defined('COOKIE_SECURE')) define('COOKIE_SECURE', env('COOKIE_SECURE', false));

// Cache Constants
if (!defined('CACHE_DRIVER')) define('CACHE_DRIVER', env('CACHE_DRIVER', 'file'));
define('CACHE_PREFIX', env('CACHE_PREFIX', 'btc_investment'));

// Queue Constants
define('QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync'));

// Mail Constants
define('MAIL_MAILER', env('MAIL_MAILER', 'smtp'));
define('MAIL_HOST', env('MAIL_HOST', 'smtp.mailgun.org'));
define('MAIL_PORT', env('MAIL_PORT', 587));
define('MAIL_USERNAME', env('MAIL_USERNAME', null));
define('MAIL_PASSWORD', env('MAIL_PASSWORD', null));
define('MAIL_ENCRYPTION', env('MAIL_ENCRYPTION', 'tls'));
define('MAIL_FROM_ADDRESS', env('MAIL_FROM_ADDRESS', 'noreply@btc-investment.com'));
define('MAIL_FROM_NAME', env('MAIL_FROM_NAME', APP_NAME));

// File System Constants
define('FILESYSTEM_DISK', env('FILESYSTEM_DISK', 'local'));

// Investment Constants
define('MIN_INVESTMENT', env('MIN_INVESTMENT', 10));
define('MAX_INVESTMENT', env('MAX_INVESTMENT', 10000));
define('DEFAULT_INTEREST_RATE', env('DEFAULT_INTEREST_RATE', 5.0));
define('WITHDRAWAL_CHARGE', env('WITHDRAWAL_CHARGE', 5.0));
define('MIN_WITHDRAWAL', env('MIN_WITHDRAWAL', 10));
define('MAX_WITHDRAWAL', env('MAX_WITHDRAWAL', 10000));

// Referral Constants
define('REFERRAL_BONUS', env('REFERRAL_BONUS', 10.0));
define('REFERRAL_LEVEL_1', env('REFERRAL_LEVEL_1', 10.0));
define('REFERRAL_LEVEL_2', env('REFERRAL_LEVEL_2', 5.0));
define('REFERRAL_LEVEL_3', env('REFERRAL_LEVEL_3', 2.0));

// Security Constants
define('PASSWORD_MIN_LENGTH', env('PASSWORD_MIN_LENGTH', 8));
define('LOGIN_ATTEMPTS', env('LOGIN_ATTEMPTS', 5));
define('LOCKOUT_DURATION', env('LOCKOUT_DURATION', 30));

// Admin Constants
define('ADMIN_EMAIL', env('ADMIN_EMAIL', 'admin@btc-investment.com'));
define('ADMIN_PASSWORD', env('ADMIN_PASSWORD', 'admin123'));

// Site Constants
define('SITE_NAME', env('SITE_NAME', 'BTC Investment'));
define('SITE_DESCRIPTION', env('SITE_DESCRIPTION', 'High Yield Investment Platform'));

// Path Constants
if (!defined('ROOT_PATH')) define('ROOT_PATH', dirname(__DIR__, 2));
if (!defined('APP_PATH')) define('APP_PATH', ROOT_PATH . '/app');
if (!defined('CONFIG_PATH')) define('CONFIG_PATH', ROOT_PATH . '/config');
if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', ROOT_PATH . '/public');
if (!defined('RESOURCES_PATH')) define('RESOURCES_PATH', ROOT_PATH . '/resources');
if (!defined('STORAGE_PATH')) define('STORAGE_PATH', ROOT_PATH . '/storage');
define('DATABASE_PATH', ROOT_PATH . '/database');
define('LOGS_PATH', ROOT_PATH . '/logs');

// URL Constants
define('ASSETS_URL', APP_URL . '/assets');
define('UPLOADS_URL', APP_URL . '/uploads');
define('STORAGE_URL', APP_URL . '/storage');

// Status Constants
define('STATUS_ACTIVE', 'active');
define('STATUS_INACTIVE', 'inactive');
define('STATUS_PENDING', 'pending');
define('STATUS_COMPLETED', 'completed');
define('STATUS_CANCELLED', 'cancelled');
define('STATUS_SUSPENDED', 'suspended');

// Transaction Types
define('TRANSACTION_TYPE_DEPOSIT', 'deposit');
define('TRANSACTION_TYPE_WITHDRAWAL', 'withdrawal');
define('TRANSACTION_TYPE_INVESTMENT', 'investment');
define('TRANSACTION_TYPE_PROFIT', 'profit');
define('TRANSACTION_TYPE_REFERRAL', 'referral');
define('TRANSACTION_TYPE_BONUS', 'bonus');

// User Roles
define('ROLE_USER', 'user');
define('ROLE_ADMIN', 'admin');
define('ROLE_MODERATOR', 'moderator');

// Investment Status
define('INVESTMENT_STATUS_ACTIVE', 'active');
define('INVESTMENT_STATUS_COMPLETED', 'completed');
define('INVESTMENT_STATUS_CANCELLED', 'cancelled');

// Payment Methods
define('PAYMENT_METHOD_BTC', 'btc');
define('PAYMENT_METHOD_ETH', 'eth');
define('PAYMENT_METHOD_USDT', 'usdt');
define('PAYMENT_METHOD_BANK', 'bank');

// API Constants
define('API_VERSION', 'v1');
define('API_PREFIX', '/api/' . API_VERSION);

// Pagination Constants
define('DEFAULT_PER_PAGE', 20);
define('MAX_PER_PAGE', 100);

// Time Constants
define('MINUTE_IN_SECONDS', 60);
define('HOUR_IN_SECONDS', 3600);
define('DAY_IN_SECONDS', 86400);
define('WEEK_IN_SECONDS', 604800);
define('MONTH_IN_SECONDS', 2592000);
define('YEAR_IN_SECONDS', 31536000);

// Rate Limiting
define('RATE_LIMIT_LOGIN', 5); // attempts per minute
define('RATE_LIMIT_API', 60); // requests per minute
define('RATE_LIMIT_GLOBAL', 1000); // requests per hour

// File Upload Constants
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);
define('UPLOAD_PATH', STORAGE_PATH . '/uploads');

// Cache Constants
define('CACHE_TTL_SHORT', 300); // 5 minutes
define('CACHE_TTL_MEDIUM', 3600); // 1 hour
define('CACHE_TTL_LONG', 86400); // 1 day
define('CACHE_TTL_FOREVER', 0); // forever

// Log Constants
define('LOG_LEVEL_EMERGENCY', 'emergency');
define('LOG_LEVEL_ALERT', 'alert');
define('LOG_LEVEL_CRITICAL', 'critical');
define('LOG_LEVEL_ERROR', 'error');
define('LOG_LEVEL_WARNING', 'warning');
define('LOG_LEVEL_NOTICE', 'notice');
define('LOG_LEVEL_INFO', 'info');
define('LOG_LEVEL_DEBUG', 'debug');

// Email Templates
define('EMAIL_TEMPLATE_WELCOME', 'welcome');
define('EMAIL_TEMPLATE_PASSWORD_RESET', 'password_reset');
define('EMAIL_TEMPLATE_INVESTMENT_CONFIRMATION', 'investment_confirmation');
define('EMAIL_TEMPLATE_WITHDRAWAL_REQUEST', 'withdrawal_request');
define('EMAIL_TEMPLATE_PROFIT_DISTRIBUTION', 'profit_distribution');

// Notification Types
define('NOTIFICATION_TYPE_EMAIL', 'email');
define('NOTIFICATION_TYPE_SMS', 'sms');
define('NOTIFICATION_TYPE_PUSH', 'push');
define('NOTIFICATION_TYPE_IN_APP', 'in_app');

// Currency Constants
define('DEFAULT_CURRENCY', 'USD');
define('SUPPORTED_CURRENCIES', ['USD', 'EUR', 'GBP', 'BTC', 'ETH', 'USDT']);

// Language Constants
define('DEFAULT_LANGUAGE', 'en');
define('SUPPORTED_LANGUAGES', ['en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko']);

// Theme Constants
define('DEFAULT_THEME', 'light');
define('SUPPORTED_THEMES', ['light', 'dark', 'auto']);

// Social Media Constants
define('SOCIAL_FACEBOOK', 'https://facebook.com/btcinvestment');
define('SOCIAL_TWITTER', 'https://twitter.com/btcinvestment');
define('SOCIAL_TELEGRAM', 'https://t.me/btcinvestment');
define('SOCIAL_DISCORD', 'https://discord.gg/btcinvestment');

// Support Constants
define('SUPPORT_EMAIL', 'support@btc-investment.com');
define('SUPPORT_PHONE', '+1-555-0123');
define('SUPPORT_CHAT_ENABLED', true);

// Maintenance Constants
define('MAINTENANCE_MODE', env('MAINTENANCE_MODE', false));
define('MAINTENANCE_MESSAGE', 'Site is under maintenance. Please check back later.');

// Version Constants
define('APP_VERSION', '1.0.0');
define('DB_VERSION', '1.0.0');

// Third-party API Constants
define('COINMARKETCAP_API_KEY', env('COINMARKETCAP_API_KEY', null));
define('EXCHANGE_RATE_API_KEY', env('EXCHANGE_RATE_API_KEY', null));
define('SMS_API_KEY', env('SMS_API_KEY', null));
define('PUSH_NOTIFICATION_KEY', env('PUSH_NOTIFICATION_KEY', null));

// Security Constants
define('CSRF_TOKEN_LENGTH', 32);
define('PASSWORD_RESET_TOKEN_LENGTH', 64);
define('API_KEY_LENGTH', 64);

// Performance Constants
define('QUERY_CACHE_TTL', 3600); // 1 hour
define('VIEW_CACHE_TTL', 1800); // 30 minutes
define('CONFIG_CACHE_TTL', 86400); // 1 day

// Backup Constants
define('BACKUP_RETENTION_DAYS', 30);
define('BACKUP_PATH', STORAGE_PATH . '/backups');

// Monitoring Constants
define('ENABLE_PERFORMANCE_MONITORING', env('ENABLE_PERFORMANCE_MONITORING', false));
define('ENABLE_ERROR_REPORTING', env('ENABLE_ERROR_REPORTING', true));
define('ERROR_REPORTING_EMAIL', env('ERROR_REPORTING_EMAIL', 'errors@btc-investment.com'));