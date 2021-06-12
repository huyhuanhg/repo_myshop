<?php

use app\http\middlewares\Authenticate;
use app\http\middlewares\CheckMiddleware;
use app\http\middlewares\GlobalMiddleware;
use app\http\middlewares\ValidateMiddleware;
use app\service\AppServiceProvider;
use app\service\HtmlHelper;

return [
    'service' => [
        HtmlHelper::class
    ],
    'routeMiddlware' => [
        'auth' => Authenticate::class,
        'ajax' => [Authenticate::class, 'ajax'],
        'logined' => [Authenticate::class, 'logined'],
        'vE_Cate' => [ValidateMiddleware::class, 'validate_updateCategory'],
        'register' => [ValidateMiddleware::class, 'validate_register'],
        'vA_Cate' => [ValidateMiddleware::class, 'validate_insertCategory'],
        'vD_Cate' => [ValidateMiddleware::class, 'validate_deleteCategory'],
    ],
    'globalMiddleware' => [
        GlobalMiddleware::class,
        [GlobalMiddleware::class, 'test'],
    ],
    'boot' => [
        AppServiceProvider::class
    ]
];
