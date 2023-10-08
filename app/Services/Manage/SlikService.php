<?php

namespace App\Services\Manage;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class SlikService extends BaseService
{
    public function __construct()
    {
        parent::__construct(env("BASE_URL_SERVICE"), TokenCommon::getToken("BEARER_TOKEN"));
    }

    public function read_raw_slik($file)
    {
        return $this->run("POST", "/api/slik/read_raw_slik", [], $file);
    }

    public function check_slik($id_pengajuan, $file)
    {
        return $this->run("POST", "/api/slik/check_slik/", ["id_pengajuan" => $id_pengajuan], $file);
    }

    public function read_raw_slik_by_id($id_slik, $data)
    {
        return $this->run("POST", "/api/slik/read_raw_slik_by_id/" . $id_slik, $data);
    }

    public function read_raw_slik_by_id2($id_slik, $data)
    {
        return $this->run("POST", "/api/slik/read_raw_slik_by_id2/" . $id_slik, $data);
    }

    public function upload_slik_pengajuan($data, $file)
    {
        return $this->run("POST", "/api/slik/upload_slik_nasabah", $data, $file);
    }

    public function encrypt_cipher($data)
    {
        return $this->run("POST", "/api/slik/encrypt_cipher", $data);
    }

    public function datatable($id_pengajuan, $data)
    {
        return $this->run("POST", "/api/slik/datatable/" . $id_pengajuan, $data);
    }

    public function datatable_tanpa_pengajuan($id_nasabah, $data)
    {
        return $this->run("POST", "/api/slik/datatable_tanpa_pengajuan/" . $id_nasabah, $data);
    }

    public function get_all_slik($data)
    {
        return $this->run("POST", "/api/slik/get_all_slik/", $data);
    }

    public function check_slik_batch($file)
    {
        return $this->run("POST", "/api/slik/check_slik_batch", [], $file);
    }

    public function upload_slik_batch($data, $file)
    {
        return $this->run("POST", "/api/slik/upload_slik_batch", $data, $file);
    }

    public function upload_slik_tanpa_pengajuan_batch($data, $file)
    {
        return $this->run("POST", "/api/slik/upload_slik_tanpa_pengajuan_batch", $data, $file);
    }

    public function get_nik_slik()
    {
        return $this->run("get", "/api/slik/get_nik_slik", []);
    }
}
