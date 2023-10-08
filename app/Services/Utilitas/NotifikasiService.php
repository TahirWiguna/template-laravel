<?php

namespace App\Services\Utilitas;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class NotifikasiService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/notification/datatable", $body);
    }

    public function getById($id)
    {
        return $this->run("GET", "/api/notification/id/" . $id, []);
    }

    public function getTargetUser()
    {
        return $this->run("GET", "/api/notification/get_target_user/", []);
    }

    public function create($body)
    {
        return $this->run("POST", "/api/notification/create", $body);
    }

    public function update($id, $body)
    {
        return $this->run("POST", "/api/notification/update/" . $id, $body);
    }

    public function delete($id)
    {
        return $this->run("DELETE", "/api/notification/delete/" . $id, []);
    }

    public function changeStatus($id, $data)
    {
        return $this->run("POST", "/api/notification/change_status/" . $id, $data);
    }

    public function softDelete($id, $data)
    {
        return $this->run("DELETE", "/api/notification/delete/soft/" . $id, $data);
    }

    public function restore($id, $data)
    {
        return $this->run("POST", "/api/notification/restore/" . $id, $data);
    }
}
