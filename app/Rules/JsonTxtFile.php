<?php

namespace App\Rules;

use App\Helpers\Util;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;
use ZipArchive;

class JsonTxtFile implements Rule
{
    protected $file_name;

    public function passes($attribute, $value)
    {
        $this->file_name = $value->getClientOriginalName();

        // Check if the file extension is .txt or .zip
        $extension = strtolower($value->getClientOriginalExtension());
        if ($extension !== "txt" && $extension !== "zip") {
            return false;
        }

        // Read the file content
        if ($extension === "zip") {
            // Skip zip file, validating in the controller
        } else {
            // Check if the content is valid JSON
            $fileContent = File::get($value->getPathname());
            if (!$this->_parse_json($fileContent)) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return "The '$this->file_name' must have a .txt or .zip extension and contain valid JSON.";
    }

    private function _parse_json($string)
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
