<?php

if (!function_exists('dejson')) {
    function dejson($data, $associative = true)
    {
        return json_decode($data, $associative);
    }
}

if (!function_exists('json')) {
    function json($data)
    {
        return json_encode($data);
    }
}
?>