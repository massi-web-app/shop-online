<?php

namespace App\Helper;

class Helper
{
    public static function generateQueryString(string $queryString,string $text):string
    {
        if ($queryString=='?'){
            return $queryString.$text;
        }
        return $queryString.'&'.$text;
    }

}
