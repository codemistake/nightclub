<?php

use Monolog\Handler\StreamHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => rtrim(env('LOG_PATH', storage_path('logs')), '/') . '/laravel.log',
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'single',
            'path' => rtrim(env('LOG_PATH', storage_path('logs')), '/') . '/' . date('Y/m/d') . '/laravel.log',
            'level' => 'debug',
        ],

        'daily-rotation' => [
            'driver' => 'daily',
            'path' => rtrim(env('LOG_PATH', storage_path('logs')), '/') . '/laravel.log',
            'level' => 'debug',
            'days' => 7,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

    // Путь для сохранения логов
    'path'       => env('LOG_PATH', storage_path('logs')),

    // Логгирование http запросов-ответов
    'req_resp'   => env('LOG_REQ_RESP', false),

    // Логгирование запросов к базе данных
    'db_queries' => env('LOG_DB_QUERIES', false),
];
