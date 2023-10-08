<?php

namespace App\Services;

use App\Helpers\TokenCommon;
use App\Services\BaseService;

class ModuleService extends BaseService
{
    public function __construct()
    {
        parent::__construct(
            env('BASE_URL_SERVICE'),
            TokenCommon::getToken("BEARER_TOKEN"),
            false
        );
    }

    public function datatable($body){
        return $this->run('POST', '/master/module/datatable', $body);
    }

    public function create($body){
        return $this->run('POST', '/master/module/create', $body);
    }
    
    public function update($body){
        return $this->run('PUT', '/master/module/update', $body);
    }

    public function delete($id){
        return $this->run('DELETE', '/master/module/delete/'.$id, []);
    }
    
    public function changeStatus($id, $data){
        return $this->run('POST', '/master/module/change_status/'.$id, $data);
    }

    public function softDelete($id, $data){
        return $this->run('DELETE', '/master/module/delete/soft/'.$id, $data);  
    }

    public function restore($id, $data){
        return $this->run('POST', '/master/module/restore/'.$id, $data);  
    }
}
