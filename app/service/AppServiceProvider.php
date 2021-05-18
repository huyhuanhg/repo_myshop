<?php

namespace app\service;
use app\core\Database as DB;
use app\core\ServiceProvider as Service;
use app\core\View;

class AppServiceProvider extends Service
{
    public function boot(){
        $data = DB::table('users')->get();
        View::share($data);
    }
}