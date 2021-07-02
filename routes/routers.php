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

    //categories
    Router::get('/myadmin/categories', 'Category@index');
    Router::post('/categories/add', 'Category@insert')->middleware('vA_Cate');
    Router::post('/categories/edit', 'Category@update')->middleware('vE_Cate');
    Router::post('/categories/delete', 'Category@delete')->middleware('vD_Cate');

    //customer
    Router::get('/myadmin/customers', 'Customer@index');
    Router::post('/customer/blacklist', "Customer@blacklist");
    Router::post('/customer/delete', "Customer@delete");
    Router::post('/myadmin/customers/handle-add','Customer@insert')->middleware('vali_customer');
    Router::post('/myadmin/customers/handle-edit','Customer@update')->middleware('vali_customer');

    //order
    Router::get('/myadmin/order', 'Order@index');

    //products
    Router::get('/myadmin/products', 'Product@index');

    //employees
    Router::get('/myadmin/employees', 'User@staff');

    //user list
    Router::get('/myadmin/userlist', 'User@list');
});
Router::group(['namespace' => 'admin'], function () {
    Router::get('/logout', 'User@logout');
    Router::post('/handle-login', 'User@login');
    Router::post('/handle-register', 'User@register')->middleware('register');
});

//Ajax
Router::group(['middleware' => ['auth', 'ajax'], 'namespace' => 'ajax'], function () {

    Router::post('/filter-category', 'Category@filter');
    Router::post('/delete-warning-category', 'Category@warring');

    Router::post('/search-customer', "Customer@search");
    Router::post('/filter-customer', "Customer@filter");
    Router::post('/customer-alert', "Customer@alert");

    Router::post('/employees-alert', 'User@employeeAlert');
    Router::post('/search-employees', "User@searchEpl");
    Router::post('/filter-employees', "User@filterEpl");
});
