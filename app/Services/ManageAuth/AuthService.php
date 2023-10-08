<?php

namespace App\Services\ManageAuth;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class AuthService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function login($body)
    {
        return $this->run("POST", "/api/login", $body);
    }

    public function userInfo()
    {
        return $this->run("POST", "/api/me", []);
    }
}
