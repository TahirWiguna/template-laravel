<?php

namespace App\Services\ManageAuth;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class UserService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"), false);
    }

    public function datatable($body)
    {
        return $this->run("POST", "/api/user/datatable", $body);
    }

    public function get_by_id($id)
    {
        return $this->run("GET", "/api/user/get_by_id/" . $id, []);
    }

    public function create($body)
    {
        return $this->run("POST", "/api/user/create", $body);
    }

    public function update($id, $body)
    {
        return $this->run("POST", "/api/user/update/" . $id, $body);
    }

    public function delete($id)
    {
        return $this->run("POST", "/api/user/delete/" . $id, []);
    }

    public function softDelete($id, $data)
    {
        return $this->run("POST", "/api/user/soft_delete/" . $id, $data);
    }

    public function get_user_list_support()
    {
        return $this->run("GET", "/api/user/get_user_list_support/", []);
    }

    public function save_token($token)
    {
        return $this->run("POST", "/api/user/save_token/", ["token" => $token]);
    }
}
