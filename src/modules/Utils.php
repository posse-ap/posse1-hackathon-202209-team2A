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
    public static function convert_datetime($datetime_local)
    {
        return date('Y-m-d H:i:s', strtotime($datetime_local));
    }
    public static function get_day_of_week($w)
    {
      $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
      return $day_of_week_list["$w"];
    }
}
