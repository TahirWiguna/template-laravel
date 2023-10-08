<?php

namespace App\Services\ManageAuth;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class PermissionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"), false);
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/permission/datatable", $body);
    }

    public function get_by_id($id)
    {
        return $this->run("GET", "/api/permission/get_by_id/" . $id, []);
    }

    public function update_all($id, $body)
    {
        return $this->run("PUT", "/api/permission/update_all/" . $id, $body);
    }

    public function create($body)
    {
        return $this->run("POST", "/api/permission/create", $body);
    }

    public function update($id, $body)
    {
        return $this->run("PUT", "/api/permission/update/" . $id, $body);
    }

    public function delete($id)
    {
        return $this->run("DELETE", "/api/permission/delete/" . $id, []);
    }

    public function softDelete($id, $data)
    {
        return $this->run("DELETE", "/api/permission/soft_delete/" . $id, $data);
    }
}
