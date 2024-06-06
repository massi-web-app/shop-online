<?php

namespace App\Helper;

use App\Lib\Jdf;

class Helper
{
    public static function generateQueryString(string $queryString, string $text): string
    {
        if ($queryString == '?') {
            return $queryString . $text;
        }
        return $queryString . '&' . $text;
    }

    public static function date()
    {
        return new Jdf();

    }

}
