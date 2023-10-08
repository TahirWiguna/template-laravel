<?php

namespace App\Services\Init;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class InitService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function chart_pengajuan()
    {
        return $this->run("POST", "/api/init/chart_pengajuan", []);
    }
}
