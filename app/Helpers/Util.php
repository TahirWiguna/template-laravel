<?php

namespace App\Helpers;

use Carbon\Carbon;

class Util
{
    public static function parse_json($string)
    {
        $string = str_replace("\n", "", $string);
        $string = trim(preg_replace('/\t+/', "", $string));

        $encodings = ["UTF-8", "ISO-8859-1"];
        foreach ($encodings as $encoding) {
            if (mb_check_encoding($string, $encoding)) {
                $string = mb_convert_encoding($string, "UTF-8", $encoding);
                break;
            }
        }
        $string = json_decode($string, true);
        return $string;
    }

    public static function object_to_array($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = is_array($value) || is_object($value) ? Util::object_to_array($value) : $value;
            }
            return $result;
        }
        return $data;
    }
}
