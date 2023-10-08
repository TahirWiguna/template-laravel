<?php

namespace App\Services\Dashboard;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class DashboardService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function datatable_pengajuan_comparation($formData)
    {
        return $this->run("POST", "/api/dashboard/datatable_pengajuan_comparation", $formData);
    }

    public function datatable_pengajuan_status($formData)
    {
        return $this->run("POST", "/api/dashboard/datatable_pengajuan_status", $formData);
    }

    public function notification($data)
    {
        return $this->run("GET", "/api/notification/list_notif_user", $data);
    }

    public function count_notification()
    {
        return $this->run("GET", "/api/notification/count_notif_user", []);
    }
}
