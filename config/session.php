<?php

use Illuminate\Support\Str;

return [

    // Default session driver configuration
    // Determines session storage method for incoming requests
    // Supported: file, cookie, database, memcached, redis, dynamodb, array

    'driver' => env('SESSION_DRIVER', 'database'),

    // Session lifetime configuration
    // Number of minutes before session expires due to inactivity
    // Use expire_on_close option for immediate expiration on browser close

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // Session encryption configuration
    // Enables automatic encryption of all session data before storage
    // Encryption is handled transparently by Laravel

    'encrypt' => env('SESSION_ENCRYPT', false),

    // Session file location configuration
    // Directory path for session files when using file driver
    // Default location can be customized as needed

    'files' => storage_path('framework/sessions'),

    // Session database connection configuration
    // Database connection for database or redis session drivers
    // Must correspond to a connection in database configuration

    'connection' => env('SESSION_CONNECTION'),

    // Session database table configuration
    // Table name for storing sessions when using database driver
    // Default table name can be customized

    'table' => env('SESSION_TABLE', 'sessions'),

    // Cache store for session data

    'store' => env('SESSION_STORE'),

    // Session cleanup lottery odds

    'lottery' => [2, 100],

    // Session cookie name configuration

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel')).'-session'
    ),

    // Session cookie path setting

    'path' => env('SESSION_PATH', '/'),

    // Session cookie domain configuration

    'domain' => env('SESSION_DOMAIN'),

    // HTTPS-only cookie security setting

    'secure' => env('SESSION_SECURE_COOKIE'),

    // HTTP-only cookie access control

    'http_only' => env('SESSION_HTTP_ONLY', true),

    // Same-site cookie policy for CSRF protection

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    // Partitioned cookie configuration for cross-site contexts

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
