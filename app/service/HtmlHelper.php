<?php

namespace app\service;
class HtmlHelper
{
    public static function formOpen($method = 'get', $action = null)
    {
        echo "<form method='$method' action='$action'>";
    }

    public static function formClose()
    {
        echo "</form>";
    }

    public static function input($name, $type = 'text', $id = '', $class = '', $placeholder = null, $value = null)
    {
        echo "<input type='$type' name='$name' id='$id' class='$class' placeholder='$placeholder' value='$value'/>";
    }

    public static function tag($tag, $content)
    {
        echo "<$tag>$content</$tag>";
    }

    public static function divOpen($attribute = [])
    {
        self::tagOpen('div', $attribute);
    }

    public static function divClose()
    {
        self::tagClose('div');
    }

    public static function tagOpen($tag, $attribute = [])
    {
        $listAttr = [];
        if (is_array($attribute)) {
            foreach ($attribute as $attr => $value) {
                if (!is_int($attr)) {
                    $listAttr[] = "$attr='$value'";
                } else {
                    $listAttr[] = $value;
                }
            }
        } else {
            $listAttr[] = $attribute;
        }

        $html = "<$tag " . implode(' ', $listAttr) . ">";
        echo $html;
    }

    public static function tagClose($tag)
    {
        echo "</$tag>";
    }

    public static function content($content)
    {
        echo $content;
    }
}