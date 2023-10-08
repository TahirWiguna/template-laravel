<?php

namespace App\Services\Report;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class RekomendasiPengajuanService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function filter($id)
    {
        return $this->run("GET", "/api/rekomendasi_pengajuan/report/$id", []);
    }
    public function get_pengajuan()
    {
        return $this->run("GET", "/api/rekomendasi_pengajuan/get_pengajuan/", []);
    }
}
