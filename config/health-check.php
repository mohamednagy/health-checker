<?php

use Nagy\HealthChecker\Result;

return [
    'notify' => true,
    'notify_on' => [Result::ERROR_STATUS,Result::SUCCESS_STATUS, Result::WARNING_STATUS],
    'emails' => [],
    'channels' => [],

    'checkers' => [
        'httpd-check' => [
            'class' => '\Nagy\HealthChecker\Checkers\ProcessCount',
            'options' => ['processName' => 'httpd', 'min' => 1, 'max' => 99999]
        ],

        'docker-compose-check' => [
            'class' => '\Nagy\HealthChecker\Checkers\ProcessCount',
            'options' => ['processName' => 'docker-compose', 'min' => 1, 'max' => 99999]
        ],

        'expression-test' => [
            'class' => '\Nagy\HealthChecker\Checkers\Expression',
            'options' => [
                'expression' => '1+1',
                'expectedOutput' => '1',
                'operator' => '='
            ]
        ],
    ]

];
