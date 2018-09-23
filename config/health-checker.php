<?php

use Nagy\HealthChecker\Result;

return [
    'notifications' => [
        'enabled' => false,

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

        'app-debug' => [
            'class' => '\Nagy\HealthChecker\Checkers\Expression',
            'options' => [
                'expression' => 'env("APP_DEBUG") == false'
            ]
        ],
    ]

];
