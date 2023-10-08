<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\MultipartStream;

use stdClass;

class BaseService
{
    private $api_key;
    private $client;

    function __construct($base_url, $api_key = "")
    {
        $this->api_key = $api_key;
        $this->client = new Client([
            "base_uri" => $base_url,
            "timeout" => 120,
        ]);
    }

    public function run($method, $path, $body, $files = [])
    {
        $json = [];

        $headers = [];
        if ($this->api_key != "") {
            $headers["Authorization"] = "Bearer " . $this->api_key;
        }
        try {
            $multipart = [];
            foreach ($files as $field => $file) {
                if (is_array($file)) {
                    foreach ($file as $f) {
                        $multipart[] = [
                            "name" => $field . "[]",
                            "contents" => fopen($f->getPathname(), "r"),
                            "filename" => $f->getClientOriginalName(),
                        ];
                    }
                } else {
                    $multipart[] = [
                        "name" => $field,
                        "contents" => fopen($file->getPathname(), "r"),
                        "filename" => $file->getClientOriginalName(),
                    ];
                }
            }

            if ($files) {
                foreach ($body as $key => $b) {
                    $multipart[] = [
                        "name" => $key,
                        "contents" => $b,
                    ];
                }
            }

            $options = [
                "headers" => $headers,
                "json" => $body,
            ];

            if (!empty($multipart)) {
                $options["multipart"] = $multipart;
                unset($options["json"]);
            }

            $response = $this->client->request($method, $path, $options);

            $status = $response->getStatusCode();
            // if ($status == "200" || $status == "201") {
            $content = $response->getBody()->getContents();
            $json = json_decode($content);
            // }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // dd($e);
            try {
                //code...
                $response = @$e->getResponse();
                $responseBodyAsString = @$response->getBody()->getContents();
                $json = json_decode($responseBodyAsString);
            } catch (\Throwable $th) {
                //throw $th;
                $json = [];
            }
            if (is_object($json)) {
                $json->err = $e->getMessage();
            } else {
                $obj = new stdClass();
                $obj->err = $e->getMessage();
                $json = $obj;
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $obj = new stdClass();
            $obj->err = $e->getMessage();
            $obj->statusCode = "500";
            $json = $obj;
        }

        if ($json && isset($response)) {
            $json->statusCode = $response->getStatusCode();
        }

        return $json;
    }

    private function array_depth($array)
    {
        if (!is_array($array)) {
            return 0;
        }

        $max_depth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = array_depth($value) + 1;
                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
}
