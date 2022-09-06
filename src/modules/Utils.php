<?php


namespace modules;

class Utils
{
    public static function h($var)
    {
        return htmlspecialchars($var, ENT_QUOTES);
    }

    public static function j($var)
    {
        return json_encode($var, JSON_UNESCAPED_UNICODE);
    }
}
