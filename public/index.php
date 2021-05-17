<?php
session_start();
define("__DIR_PUBLIC__", __DIR__);
require_once  dirname(__DIR_PUBLIC__)."/bootstrap/bootstrap.php";
require_once (dirname(__DIR_PUBLIC__).'/app/core/App.php');
App::run();
