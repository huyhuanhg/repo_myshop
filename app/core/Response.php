<?php

namespace app\core;
class Response
{
    public function redirect($uri, $isEnd = true, $resPonseCode = 302)
    {
        if (preg_match("~^(http|https)~is", $uri)) {
            $url = trim($uri,'/');
        } else {
            $url = __WEB_ROOT__ . "/" . trim($uri,'/');;
        }
        header("Location: $url", true, $resPonseCode);
        if ($isEnd) {
            exit;
        }
    }
}
