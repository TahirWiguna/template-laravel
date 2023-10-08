<?php

namespace App\Services\Manage;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class PengajuanService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/pengajuan/datatable", $body);
    }

    public function filter($body)
    {
        return $this->run("POST", "/api/pengajuan/report", $body);
    }

    public function getById($id)
    {
        return $this->run("GET", "/api/pengajuan/get_by_id/" . $id, []);
    }

    public function getByBprId($id)
    {
        return $this->run("GET", "/api/pengajuan/get_by_bpr_id/" . $id, []);
    }

    public function print($body)
    {
        return $this->run("GET", "/api/pengajuan/print", $body);
    }

    public function delete($id)
    {
        return $this->run("DELETE", "/api/pengajuan/delete/" . $id, []);
    }

    public function reset($id)
    {
        return $this->run("POST", "/api/pengajuan/reset/" . $id, []);
    }

    public function create($id)
    {
        return $this->run("POST", "/api/pengajuan/create/" . $id, []);
    }
}
