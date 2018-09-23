<?php

use Nagy\HealthChecker\Result;

return [
    'notifications' => [
        'enabled' => true,

        'schedule' => 'hourly',

        'notify_on' => [Result::ERROR_STATUS,Result::SUCCESS_STATUS, Result::WARNING_STATUS],
        
        'mail_from' => env('MAIL_USERNAME'),
        'mail_to' => ['first@example.com', 'second@example.com'],

        'channels' => [
            Nagy\HealthChecker\Notifications\Mail\MailChannel::class,
        ]
    ],

    'checkers' => [
        'httpd-check' => [
            'class' => '\Nagy\HealthChecker\Checkers\ProcessCount',
            'options' => ['processName' => 'httpd', 'min' => 1, 'max' => 99999]
        ],

        'supervisord' => [
            'class' => '\Nagy\HealthChecker\Checkers\ProcessCount',
            'options' => ['processName' => 'supervisord', 'min' => 1]
        ],

        'mysql-server' => [
            'class' => '\Nagy\HealthChecker\Checkers\ServerAvailability',
            'options' => ['host' => env('DB_HOST'), 'port' => env('DB_PORT')]
        ],

        'redis-server' => [
            'class' => '\Nagy\HealthChecker\Checkers\ServerAvailability',
            'options' => ['host' => env('REDIS_HOST'), 'port' => env('REDIS_PORT')]
        ],

        'app-debug' => [
            'class' => '\Nagy\HealthChecker\Checkers\Expression',
            'options' => [
                'expression' => 'env("APP_DEBUG") == false'
            ]
        ],
    ]

];
