<?php

use app\core\Router;
use app\core\AppException as E;
use app\http\controllers\ProductController;
Router::get('/', 'Home@index')->middleware('logined');
Router::get('/signin', 'Home@register')->middleware('logined');
Router::group(['namespace' => 'admin'], function (){
    Router::get('/user', 'User@index');
    Router::post('/handle-login','User@login')->middleware('validate-login');
    Router::get('/logout',"User@logout");
    Router::post('/handle-registry', 'User@registry')->middleware('validate-registry');
});
Router::group(['middleware'=>'auth'],function (){
    Router::get('/person', 'Person@index');
    Router::get('/person/add', 'Person@add');
    Router::post('/person/handle-add', 'Person@handleAdd')->middleware('validate-add');
    Router::get('/person/delete', 'Person@deleteView');
    Router::post('/person/handle-delete', 'Person@handleDelete')->middleware('validate-delete');
    Router::get('/person/edit', 'Person@editView');
    Router::post('/person/handle-edit', 'Person@handleEdit')->middleware('validate-edit');
});

Router::get('/query', 'Home@checkQuery');
Router::get('/product', function () {
    ProductController::view('test');
});
Router::get('/product/multi', 'Product@list');
Router::any('*', function () {
    Router::view('errors/404');
});
