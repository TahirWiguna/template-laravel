<?php

namespace App\Http\Controllers\Master;

use App\Helpers\AuthCommon;
use App\Helpers\PermissionCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Services\ManageAuth\BprService;
use App\Services\ManageAuth\PermissionService;
use App\Services\ManageAuth\RoleService;
use App\Services\ManageAuth\UserService;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class BPRController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
    }

    public function datatable(Request $request)
    {
        $formData = $request->all();
        $run = (new BprService)->datatable($formData);
        return $run;
    }

    public function datatable_branch(Request $request)
    {
        $formData = $request->all();
        $run = (new BprService)->datatable_branch($formData);
        return $run;
    }

    public function select2_branch(Request $request)
    {
        $request->validate([
            'limit' => 'required',
            'page' => 'required',
            'bpr_id' => 'required'
        ]);

        $limit = $request->limit;
        $start = $limit * $request->page;
        $term = isset($request->term) ? $request->term : '';

        $filter = [
            "columns" => [
                [
                    "data" => "name",
                    "name" => "name",
                    "searchable" => "true",
                    "orderable" => "true",
                    "search" => [
                        "value" => "",
                        "regex" => "false",
                    ]
                ],
            ],
            "start" => $start,
            "length" => $limit,
            "search" => [
                "value" => $term,
                "regex" => "false"
            ],
            "bpr_id" => $request->bpr_id
        ];

        $run = (new BprService)->datatable_branch($filter);

        $res['items'] = [];
        $res['total'] = 0;
        if (isset($run->data)) {
            $res['items'] = $run->data;
            $res['total'] = count($run->data);
        }

        return $res;
    }
}
