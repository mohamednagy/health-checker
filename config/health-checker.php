<?php

use Nagy\HealthChecker\Result;

return [
    'notifications' => [
        'enabled' => true,
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

        'artisan' => [
            'class' => '\Nagy\HealthChecker\Checkers\ProcessCount',
            'options' => ['processName' => 'artisan', 'min' => 1, 'max' => 99999]
        ],

        'expression-test' => [
            'class' => '\Nagy\HealthChecker\Checkers\Expression',
            'options' => [
                'expression' => '1+1 == 2'
            ]
        ],
    ]

];
