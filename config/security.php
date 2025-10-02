<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Advanced security settings for the application including rate limiting,
    | IP restrictions, request validation, and security monitoring.
    |
    */

    // Rate Limiting Configuration
    'rate_limits' => [
        'api' => [
            'requests' => env('API_RATE_LIMIT_REQUESTS', 100),
            'minutes' => env('API_RATE_LIMIT_MINUTES', 1),
        ],
        'auth' => [
            'login_attempts' => env('LOGIN_RATE_LIMIT_ATTEMPTS', 5),
            'minutes' => env('LOGIN_RATE_LIMIT_MINUTES', 15),
        ],
        'registration' => [
            'attempts' => env('REGISTRATION_RATE_LIMIT_ATTEMPTS', 3),
            'minutes' => env('REGISTRATION_RATE_LIMIT_MINUTES', 60),
        ],
    ],

    // IP Security Configuration
    'ip_security' => [
        'blacklisted_ips' => explode(',', env('BLACKLISTED_IPS', '')),
        'whitelisted_ips' => explode(',', env('WHITELISTED_IPS', '')),
        'enable_ip_logging' => env('ENABLE_IP_LOGGING', true),
    ],

    // Request Security Configuration
    'request_security' => [
        'max_request_size' => env('MAX_REQUEST_SIZE', 10 * 1024 * 1024), // 10MB
        'enable_user_agent_validation' => env('ENABLE_USER_AGENT_VALIDATION', true),
        'suspicious_user_agents' => [
            'sqlmap', 'nikto', 'nessus', 'burp', 'w3af', 'masscan',
            'nmap', 'dirb', 'gobuster', 'wpscan', 'nuclei'
        ],
    ],

    // Password Security Configuration
    'password_security' => [
        'min_length' => env('PASSWORD_MIN_LENGTH', 8),
        'require_uppercase' => env('PASSWORD_REQUIRE_UPPERCASE', true),
        'require_lowercase' => env('PASSWORD_REQUIRE_LOWERCASE', true),
        'require_numbers' => env('PASSWORD_REQUIRE_NUMBERS', true),
        'require_symbols' => env('PASSWORD_REQUIRE_SYMBOLS', true),
        'history_limit' => env('PASSWORD_HISTORY_LIMIT', 5), // Remember last 5 passwords
    ],

    // Session Security Configuration
    'session_security' => [
        'regenerate_on_login' => env('SESSION_REGENERATE_ON_LOGIN', true),
        'timeout_minutes' => env('SESSION_TIMEOUT_MINUTES', 120),
        'concurrent_sessions_limit' => env('CONCURRENT_SESSIONS_LIMIT', 3),
    ],

    // API Security Configuration  
    'api_security' => [
        'token_expiration_minutes' => env('API_TOKEN_EXPIRATION', 525600), // 1 year
        'max_tokens_per_user' => env('MAX_TOKENS_PER_USER', 10),
        'require_device_name' => env('API_REQUIRE_DEVICE_NAME', false),
        'log_token_usage' => env('API_LOG_TOKEN_USAGE', true),
    ],

    // Security Headers Configuration
    'security_headers' => [
        'content_security_policy' => [
            'enabled' => env('CSP_ENABLED', true),
            'directives' => [
                'default-src' => "'self'",
                'script-src' => "'self' 'unsafe-inline' 'unsafe-eval'",
                'style-src' => "'self' 'unsafe-inline' fonts.bunny.net",
                'font-src' => "'self' fonts.bunny.net",
                'img-src' => "'self' data: https:",
                'connect-src' => "'self'",
                'frame-ancestors' => "'none'",
            ],
        ],
        'strict_transport_security' => [
            'enabled' => env('HSTS_ENABLED', true),
            'max_age' => env('HSTS_MAX_AGE', 31536000), // 1 year
            'include_subdomains' => env('HSTS_INCLUDE_SUBDOMAINS', true),
            'preload' => env('HSTS_PRELOAD', true),
        ],
    ],

    // Audit Logging Configuration
    'audit_logging' => [
        'enabled' => env('AUDIT_LOGGING_ENABLED', true),
        'log_successful_logins' => env('LOG_SUCCESSFUL_LOGINS', true),
        'log_failed_logins' => env('LOG_FAILED_LOGINS', true),
        'log_password_changes' => env('LOG_PASSWORD_CHANGES', true),
        'log_account_changes' => env('LOG_ACCOUNT_CHANGES', true),
        'log_api_requests' => env('LOG_API_REQUESTS', false),
        'retention_days' => env('AUDIT_LOG_RETENTION_DAYS', 90),
    ],

    // Two-Factor Authentication Configuration
    'two_factor' => [
        'enabled' => env('TWO_FACTOR_ENABLED', true),
        'enforce_for_admin' => env('TWO_FACTOR_ENFORCE_ADMIN', true),
        'backup_codes_count' => env('TWO_FACTOR_BACKUP_CODES', 8),
        'qr_code_size' => env('TWO_FACTOR_QR_SIZE', 200),
    ],

    // Database Security Configuration
    'database_security' => [
        'enable_query_logging' => env('DB_QUERY_LOGGING', false),
        'enable_ssl' => env('DB_SSL_ENABLED', false),
        'connection_timeout' => env('DB_CONNECTION_TIMEOUT', 30),
        'max_connections' => env('DB_MAX_CONNECTIONS', 100),
    ],

    // File Upload Security Configuration
    'file_upload' => [
        'max_file_size' => env('MAX_FILE_SIZE', 5 * 1024 * 1024), // 5MB
        'allowed_extensions' => explode(',', env('ALLOWED_FILE_EXTENSIONS', 'jpg,jpeg,png,gif,pdf,doc,docx')),
        'scan_for_malware' => env('SCAN_FILES_FOR_MALWARE', false),
        'quarantine_suspicious_files' => env('QUARANTINE_SUSPICIOUS_FILES', true),
    ],

    // Encryption Configuration
    'encryption' => [
        'algorithm' => env('ENCRYPTION_ALGORITHM', 'AES-256-CBC'),
        'rotate_keys_days' => env('ENCRYPTION_KEY_ROTATION_DAYS', 90),
        'secure_key_storage' => env('SECURE_KEY_STORAGE', true),
    ],
];