<?php

use app\core\Router;
use app\core\AppException as E;
use app\http\controllers\ProductController;


Router::get('/', 'Home@index');
Router::group(['middleware' => 'logined'], function () {
    Router::get('/login', 'Userform@login');
    Router::get('/register', "Userform@register");
});
Router::group(['middleware' => 'auth', 'namespace' => 'admin'], function () {
    Router::get('/myadmin', "User@index");
    Router::get('/myadmin/order', 'Order@index');
    Router::get('/myadmin/categories', 'Category@index');
    Router::get('/myadmin/products', 'Product@index');
    Router::get('/myadmin/customers', 'Customer@index');
    Router::get('/myadmin/employees', 'User@staff');
    Router::post('/categories/add', 'Category@insert')->middleware('vA_Cate');
    Router::post('/categories/edit', 'Category@update')->middleware('vE_Cate');
    Router::post('/categories/delete', 'Category@delete')->middleware('vD_Cate');
});
Router::group(['namespace' => 'admin'], function () {
    Router::get('/logout', 'User@logout');
    Router::post('/handle-login', 'User@login');
    Router::post('/handle-register', 'User@register')->middleware('register');
});
Router::group(['middleware' => ['auth', 'ajax'], 'namespace' => 'ajax'], function () {
    Router::post('/filter-category', 'Category@filter');
    Router::post('/delete-warning-category', 'Category@warring');
    Router::post('/search-customer', "Customer@search");
});
