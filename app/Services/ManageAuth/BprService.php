<?php

namespace App\Services\ManageAuth;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class BprService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"), false);
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/master/bpr", $body);
    }

    public function datatable_branch($body)
    {
        return $this->run("POST", "/api/master/bpr_branch", $body);
    }
}
