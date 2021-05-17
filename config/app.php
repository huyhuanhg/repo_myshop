<?php

use app\http\middlewares\Authenticate;
use app\http\middlewares\CheckMiddleware;
use app\http\middlewares\GlobalMiddleware;
use app\http\middlewares\ValidateMiddleware;
use app\http\middlewares\Logined;

return [
    'service' => [
        HtmlHelper::class
    ],
    'routeMiddlware' => [
        'auth' => Authenticate::class,
        'check' => CheckMiddleware::class,
        'validate-login' => [ValidateMiddleware::class, 'validate_login'],
        'validate-edit' => [ValidateMiddleware::class, 'validate_edit'],
        'validate-add' => [ValidateMiddleware::class, 'validate_add'],
        'validate-registry' => [ValidateMiddleware::class, 'validate_registry'],
        'logined' => [Authenticate::class, 'logined']
    ],
    'globalMiddleware' => [
        GlobalMiddleware::class,
        [GlobalMiddleware::class, 'test'],
    ]
];
