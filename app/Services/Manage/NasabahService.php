<?php

namespace App\Services\Manage;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class NasabahService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }


    public function datatable($body)
    {
        return $this->run('POST', '/api/nasabah/datatable', $body);
    }

    public function getById($id)
    {
        return $this->run('GET', '/api/nasabah/id/' . $id, []);
    }

    public function create($body)
    {
        return $this->run('POST', '/api/nasabah/create', $body);
    }

    public function update($id, $body)
    {
        return $this->run('POST', '/api/nasabah/update/' . $id, $body);
    }

    public function delete($id)
    {
        return $this->run('DELETE', '/api/nasabah/delete/' . $id, []);
    }

    public function changeStatus($id, $data)
    {
        return $this->run('POST', '/api/nasabah/change_status/' . $id, $data);
    }

    public function softDelete($id, $data)
    {
        return $this->run('DELETE', '/api/nasabah/delete/soft/' . $id, $data);
    }

    public function restore($id, $data)
    {
        return $this->run('POST', '/api/nasabah/restore/' . $id, $data);
    }

    public function pengajuan($data)
    {
        return $this->run('POST', '/api/nasabah/pengajuan/', $data);
    }
}
