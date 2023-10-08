<?php

if (!function_exists("tgl_indo")) {
    function tgl_indo($date)
    {
        $chars_length = strlen($date);
        $year = "";
        $month = "";
        $day = "";
        $hour = "";
        $minute = "";
        $second = "";
        $trans_month = [
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember",
        ];
        if ($chars_length > 3) {
            $year = substr($date, 0, 4);

            if ($chars_length > 5) {
                $month = substr($date, 4, 2);

                if ($chars_length > 7) {
                    $day = substr($date, 6, 2);

                    if ($chars_length > 8) {
                        $hour = substr($date, 8, 2);

                        if ($chars_length > 10) {
                            $minute = substr($date, 10, 2);

                            if ($chars_length > 12) {
                                $second = substr($date, 12, 2);
                            }
                        }
                    }
                }
            }
        }

        $formated_date = $day . " " . @$trans_month[$month] . " " . $year;

        if ($hour != "" && $minute != "" && $second != "") {
            $formated_date .= " " . $hour . ":" . $minute . ":" . $second;
        }

        return $formated_date;
    }
}

if (!function_exists("tgl_indo2")) {
    function tgl_indo2($date = null)
    {
        if ($date != null) {
            $formated_date = "";
            $chars_length = strlen($date);
            $year = "";
            $month = "";
            $day = "";
            $hour = "";
            $minute = "";
            $second = "";
            $trans_month = [
                "01" => "Jan",
                "02" => "Feb",
                "03" => "Mar",
                "04" => "Apr",
                "05" => "Mei",
                "06" => "Jun",
                "07" => "Jul",
                "08" => "Agt",
                "09" => "Sep",
                "10" => "Okt",
                "11" => "Nov",
                "12" => "Des",
            ];

            if ($chars_length > 3) {
                $year = substr($date, 0, 4);

                if ($chars_length > 5) {
                    $month = substr($date, 4, 2);

                    if ($chars_length > 7) {
                        $day = substr($date, 6, 2);

                        if ($chars_length > 8) {
                            $hour = substr($date, 8, 2);

                            if ($chars_length > 10) {
                                $minute = substr($date, 10, 2);

                                if ($chars_length > 12) {
                                    $second = substr($date, 12, 2);
                                }
                            }
                        }
                    }
                }
            }

            if ($month != "") {
                $month = $trans_month[$month];
            }

            $formated_date = $day . " " . $month . " " . $year;

            if ($hour != "" && $minute != "" && $second != "") {
                $formated_date .= " " . $hour . ":" . $minute . ":" . $second;
            }

            return $formated_date;
        }
    }
}

if (!function_exists("increment_letter")) {
    function increment_letter($letter, $increment)
    {
        $ascii = ord($letter); // Get ASCII value of the letter

        // Increment the ASCII value
        $ascii += $increment;

        // Convert back to letter
        $result = chr($ascii);

        return $result;
    }
}

if (!function_exists("decrement_letter")) {
    function decrement_letter($Alphabet)
    {
        return chr(ord($Alphabet) - 1);
    }
}
if (!function_exists("format_currency")) {
    function format_currency($number)
    {
        $currencySymbol = "Rp ";
        return $currencySymbol . number_format((float) $number, 2, ",", ".");
    }
}

if (!function_exists("unformat_currency")) {
    function unformat_currency($number)
    {
        $number = str_replace(".", "", $number);
        $number = str_replace(",", ".", $number);
        $number = str_replace("Rp ", "", $number);
        return (float) $number;
    }
}

if (!function_exists("rule_max_file_size")) {
    function rule_max_file_size($maxSize = 1024)
    {
        return function ($attribute, $value, $fail) use ($maxSize) {
            $fileName = $value->getClientOriginalName();

            if ($value->getSize() > $maxSize * 1024) {
                $fail("The {$fileName} must not be greater than {$maxSize} kilobytes.");
            }
        };
    }
}

if (!function_exists("rule_mimes")) {
    function rule_mimes($mime)
    {
        return function ($attribute, $value, $fail) use ($maxSize) {
            $fileName = $value->getClientOriginalName();

            if ($value->getSize() > $maxSize * 1024) {
                $fail("The {$fileName} must not be greater than {$maxSize} kilobytes.");
            }
        };
    }
}

if (!function_exists("parse_json")) {
    function parse_json($string)
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
}
