<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MongoDB Database Configuration
    |--------------------------------------------------------------------------
    |
    | Advanced MongoDB configuration for hybrid database architecture.
    | This configuration supports multiple MongoDB connections, replica sets,
    | sharding, and performance optimization.
    |
    */

    'default' => env('MONGO_CONNECTION', 'mongodb'),

    'connections' => [
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_HOST', '127.0.0.1'),
            'port' => env('MONGO_PORT', 27017),
            'database' => env('MONGO_DATABASE', 'diet_plan_mongo'),
            'username' => env('MONGO_USERNAME'),
            'password' => env('MONGO_PASSWORD'),
            'options' => [
                'database' => env('MONGO_AUTH_DATABASE', 'admin'),
                'authSource' => env('MONGO_AUTH_SOURCE', 'admin'),
                'ssl' => env('MONGO_SSL', false),
                'sslVerify' => env('MONGO_SSL_VERIFY', true),
                'sslCert' => env('MONGO_SSL_CERT'),
                'sslKey' => env('MONGO_SSL_KEY'),
                'sslCA' => env('MONGO_SSL_CA'),
                'replicaSet' => env('MONGO_REPLICA_SET'),
                'readPreference' => env('MONGO_READ_PREFERENCE', 'primary'),
                'readConcern' => env('MONGO_READ_CONCERN', 'local'),
                'writeConcern' => env('MONGO_WRITE_CONCERN', 'majority'),
                'connectTimeoutMS' => env('MONGO_CONNECT_TIMEOUT', 10000),
                'socketTimeoutMS' => env('MONGO_SOCKET_TIMEOUT', 30000),
                'serverSelectionTimeoutMS' => env('MONGO_SERVER_SELECTION_TIMEOUT', 30000),
                'maxPoolSize' => env('MONGO_MAX_POOL_SIZE', 100),
                'minPoolSize' => env('MONGO_MIN_POOL_SIZE', 0),
                'maxIdleTimeMS' => env('MONGO_MAX_IDLE_TIME', 60000),
                'compressors' => env('MONGO_COMPRESSORS', 'snappy,zlib'),
            ],
        ],

        'mongodb_analytics' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_ANALYTICS_HOST', '127.0.0.1'),
            'port' => env('MONGO_ANALYTICS_PORT', 27017),
            'database' => env('MONGO_ANALYTICS_DATABASE', 'diet_analytics'),
            'username' => env('MONGO_ANALYTICS_USERNAME'),
            'password' => env('MONGO_ANALYTICS_PASSWORD'),
            'options' => [
                'readPreference' => 'secondary',
                'readConcern' => 'available',
                'writeConcern' => 'acknowledged',
                'maxPoolSize' => 50,
            ],
        ],

        'mongodb_logs' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_LOGS_HOST', '127.0.0.1'),
            'port' => env('MONGO_LOGS_PORT', 27017),
            'database' => env('MONGO_LOGS_DATABASE', 'application_logs'),
            'username' => env('MONGO_LOGS_USERNAME'),
            'password' => env('MONGO_LOGS_PASSWORD'),
            'options' => [
                'writeConcern' => 'acknowledged',
                'maxPoolSize' => 25,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Collection Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for MongoDB collections including sharding keys,
    | indexes, and performance optimization settings.
    |
    */

    'collections' => [
        'nutrition_analytics' => [
            'shardKey' => ['user_id' => 1, 'date' => 1],
            'indexes' => [
                ['user_id' => 1, 'date' => -1],
                ['created_at' => -1],
                ['user_id' => 1, 'meal_type' => 1],
            ],
            'options' => [
                'capped' => false,
                'size' => null,
                'max' => null,
            ],
        ],

        'user_activities' => [
            'shardKey' => ['user_id' => 1, 'timestamp' => 1],
            'indexes' => [
                ['user_id' => 1, 'timestamp' => -1],
                ['activity_type' => 1, 'timestamp' => -1],
                ['session_id' => 1],
            ],
            'ttl' => [
                'field' => 'timestamp',
                'expireAfterSeconds' => 2592000, // 30 days
            ],
        ],

        'api_metrics' => [
            'shardKey' => ['endpoint' => 1, 'timestamp' => 1],
            'indexes' => [
                ['endpoint' => 1, 'timestamp' => -1],
                ['user_id' => 1, 'timestamp' => -1],
                ['response_time' => 1],
            ],
            'ttl' => [
                'field' => 'timestamp',
                'expireAfterSeconds' => 604800, // 7 days
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Aggregation Pipeline Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for MongoDB aggregation pipelines and optimization.
    |
    */

    'aggregation' => [
        'allowDiskUse' => env('MONGO_ALLOW_DISK_USE', true),
        'maxTimeMS' => env('MONGO_MAX_TIME_MS', 30000),
        'batchSize' => env('MONGO_BATCH_SIZE', 1000),
        'cursor' => [
            'batchSize' => env('MONGO_CURSOR_BATCH_SIZE', 100),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | MongoDB performance optimization configurations.
    |
    */

    'performance' => [
        'query_timeout' => env('MONGO_QUERY_TIMEOUT', 30000),
        'connection_pool_size' => env('MONGO_CONNECTION_POOL_SIZE', 100),
        'enable_profiling' => env('MONGO_ENABLE_PROFILING', false),
        'profiling_level' => env('MONGO_PROFILING_LEVEL', 1),
        'slow_operation_threshold' => env('MONGO_SLOW_OP_THRESHOLD', 100),
        'enable_query_logging' => env('MONGO_ENABLE_QUERY_LOGGING', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | MongoDB security and authentication configurations.
    |
    */

    'security' => [
        'enable_auth' => env('MONGO_ENABLE_AUTH', true),
        'auth_mechanism' => env('MONGO_AUTH_MECHANISM', 'SCRAM-SHA-256'),
        'enable_encryption' => env('MONGO_ENABLE_ENCRYPTION', false),
        'encryption_key' => env('MONGO_ENCRYPTION_KEY'),
        'field_level_encryption' => env('MONGO_FIELD_LEVEL_ENCRYPTION', false),
    ],
];