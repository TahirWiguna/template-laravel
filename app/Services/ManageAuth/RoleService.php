<?php

namespace App\Services\ManageAuth;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class RoleService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"), false);
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/role/datatable", $body);
    }

    public function get_by_id($id)
    {
        return $this->run("GET", "/api/role/get_by_id/" . $id, []);
    }
    public function get_role_permission($id)
    {
        return $this->run("GET", "/api/role/get_role_permission/" . $id, []);
    }

    public function create($body)
    {
        return $this->run("POST", "/api/role/create", $body);
    }

    public function update($id, $body)
    {
        return $this->run("PUT", "/api/role/update/" . $id, $body);
    }

    public function delete($id)
    {
        return $this->run("DELETE", "/api/role/delete/" . $id, []);
    }

    public function softDelete($id, $data)
    {
        return $this->run("DELETE", "/api/role/soft_delete/" . $id, $data);
    }
}
