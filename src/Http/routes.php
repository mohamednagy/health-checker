<?php

$router = app()->make('router');

$router->group(['prefix' => 'health-check'], function () use ($router) {
    $router->get('/dashboard', '\Nagy\HealthChecker\Http\HealthCheckController@index');
    $router->get('/checkers', '\Nagy\HealthChecker\Http\HealthCheckController@getCheckers');
    $router->get('/{name}', '\Nagy\HealthChecker\Http\HealthCheckController@run');
    $router->get('/', '\Nagy\HealthChecker\Http\HealthCheckController@runAll');
});
