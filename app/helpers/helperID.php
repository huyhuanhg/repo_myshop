<?php
if (!function_exists('setCategoryID')) {
    function setCategoryID($maxCurrentID)
    {
            $id = 'DTDD-' . str_pad(++$maxCurrentID, 3, "0", STR_PAD_LEFT);
            return $id;
    }
}
if (!function_exists('setProductID')) {
    function setProductID($maxCurrentProductID, $categoryID)
    {
            $id = str_pad($categoryID, 3, "0", STR_PAD_LEFT) . '-' .
                str_pad(++$maxCurrentProductID, 4, "0", STR_PAD_LEFT);
            return $id;
    }
}
?>