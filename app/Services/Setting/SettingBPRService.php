<?php

namespace App\Services\Setting;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class SettingBPRService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"), false);
    }

    public function set($body)
    {
        return $this->run("POST", "/api/setting_bpr/update_or_create", $body);
    }

    public function set_google_credentials($body)
    {
        return $this->run("POST", "/api/setting_bpr/set_google_credentials", $body);
    }

    public function get_google_credentials()
    {
        return $this->run("GET", "/api/setting_bpr/get_google_credentials", []);
    }
}
