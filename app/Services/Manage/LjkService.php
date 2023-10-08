<?php

namespace App\Services\Manage;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class LjkService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"), false);
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/ljk/datatable", $body);
    }

    public function get_by_id($id)
    {
        return $this->run("GET", "/api/ljk/get_by_id/" . $id, []);
    }
    public function get_by_code($code)
    {
        return $this->run("GET", "/api/ljk/get_by_code/" . $code, []);
    }

    public function create($body)
    {
        return $this->run("POST", "/api/ljk/create", $body);
    }

    public function update($id, $body)
    {
        return $this->run("PUT", "/api/ljk/update/" . $id, $body);
    }

    public function delete($id)
    {
        return $this->run("DELETE", "/api/ljk/delete/" . $id, []);
    }
}
