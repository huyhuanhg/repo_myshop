<?php
if (!function_exists('view')){
    function view($path, $data=[]){
        \app\core\Controller::view($path, $data);
    }
}
if (!function_exists('raw')){
    function raw($content, $data=[]){
        $template = new \app\core\Template();
        $template->run($content, $data);
    }
}
?>