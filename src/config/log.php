<?php

return [

    // Директория для хранения логов
    'path' => env('LOGS_PATH', storage_path('logs')),

    // Логирование http запросов-ответов
    'req_resp' => env('LOG_REQ_RESP', false),

    // Логирование запросов к базе данных
    'db_queries' => env('LOG_DB_QUERIES', false),

    // Логирование вызовов artisan команд по крону
    'cron' => env('LOG_CRON', false),
];
