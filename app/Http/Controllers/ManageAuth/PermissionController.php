<?php

namespace App\Http\Controllers\ManageAuth;

use App\Helpers\AuthCommon;
use App\Helpers\PermissionCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Services\ModuleService;
use App\Services\ManageAuth\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct() {
        $this->module = 'permission';
        $this->module_name = 'Permission';
        $this->service = PermissionService::class;
        $this->help_key = 'manage_auth.permission';
        $this->folder = 'manage_auth.permission';

        $this->allow = [
            'list' => PermissionCommon::check($this->module.'.list'),
            'create' => PermissionCommon::check($this->module.'.create'),
            'delete' => PermissionCommon::check($this->module.'.delete'),
            'update' => PermissionCommon::check($this->module.'.update'),
            'show' => PermissionCommon::check($this->module.'.show'),
            'export' => PermissionCommon::check($this->module.'.export'),
            'change_status' => PermissionCommon::check($this->module.'.change_status'),
            'list_trash' => PermissionCommon::check($this->module.'.list_trash'),
            'soft_delete' => PermissionCommon::check($this->module.'.soft_delete'),
            'restore' => PermissionCommon::check($this->module.'.restore'),
        ];
        
    }

    public function index(Request $request)
    {
        if(!$this->allow['list']) abort('403');
        
        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Manage Auth";
        $icon = "fas fa-stream";
        $module = $this->module;
        $module_name = $this->module_name;
        
        $header = [];
        if(isset($request->module_id)){
            $module_id  = $request->module_id;
            $run = (new ModuleService)->datatable([
                'id' => $module_id
            ]);
            if(isset($run->recordsFiltered) && (int) $run->recordsFiltered > 0){
                $header = $run->data[0];
            }
        }
        
        // dd($header);
        return view('pages.'.$this->folder.'.list', compact('allow', 'help_key', 'group', 'icon', 'module', 'module_name', 'header'));
    }

    public function datatable()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        $formData = [];
        // dd('');
        $run = (new PermissionService())->datatable($formData);
        return $run;
    }

    public function create(Request $request)
    {
        if(!$this->allow['create']) {
            $body = '<h3>403 | Forbidden</h3>';
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        }else{
            $body = view('pages.'.$this->folder.'.create', [
                'module' => $this->module,
                'module_name' => $this->module_name,
                'folder' => $this->folder,
                'module_id' => $request->module_id
            ])->render(); 

            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>';
        }

        return [
            'title' => 'Tambah '.$this->module_name,
            'body' => $body,
            'footer' => $footer
        ];
    }

    public function store(Request $request)
    {
        if(!$this->allow['create']) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }
        
        $request->validate([
            'slug' => 'required',
            'name' => 'required',
            'description' => 'required',
            'module' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
        ]);

        $formData = $request->except('_token');
        $formData['user_id'] = AuthCommon::user()->id;
        
        $run = (new $this->service)->create($formData);
// dd($run);
        if(isset($run->rc)){
            switch ($run->statusCode) {
                case "201":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                        ],
                        200
                    );
                    break;
                case "422":
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => $run->data,
                        ],
                        422
                    );
                    break;
                default:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        400
                    );
                    break;
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function show($id)
    {
        $run = (new $this->service)->datatable([
            'id' => $id
        ]);
        if(isset($run->recordsFiltered) && (int) $run->recordsFiltered > 0){
            $data = $run->data[0];

            if(!$this->allow['show']) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }else{
                $body = view('pages.'.$this->folder.'.show', compact('data'))->render(); 
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }

            return [
                'title' => 'Detail '.$this->module_name,
                'body' => $body,
                'footer' => $footer
            ];
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function edit($id)
    {
        $run = (new PermissionService())->get_by_id($id);
        if (isset($run->rc)) {
            if ($run->rc == "00") {
                if (!$this->allow["update"]) {
                    $body = "<h3>403 | Forbidden</h3>";
                    $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
                } else {
                    $data = $run->data;
                    $body = view("pages." . $this->folder . ".edit", [
                        "id" => $id,
                        "data" => $data,
                        "module" => $this->module,
                        "folder" => $this->folder,
                    ])->render();
                    $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>';
                }

                return [
                    "title" => "Edit " . $this->module_name,
                    "body" => $body,
                    "footer" => $footer,
                ];
            } else {
                return response(
                    [
                        "status" => false,
                        "message" => $run->rm,
                    ],
                    400
                );
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function update(Request $request, $id)
    {
        if(!$this->allow['update']) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }
        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
        ]);

        $formData = $request->except('_token');
        $formData['id'] = $id;
        $formData['user_id'] = AuthCommon::user()->id;
        $run = (new $this->service)->update($id,$formData);

        if(isset($run->rc)){
            switch ($run->statusCode) {
                case "200":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                        ],
                        200
                    );
                    break;
                case "422":
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => $run->data,
                        ],
                        422
                    );
                    break;
                default:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        400
                    );
                    break;
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function destroy($id)
    {
        if(!$this->allow['delete']) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        $run = (new $this->service)->delete($id);
        if(isset($run->rc)){
            switch ($run->statusCode) {
                case "201":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                        ],
                        200
                    );
                    break;
                case "422":
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => $run->data,
                        ],
                        422
                    );
                    break;
                default:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        400
                    );
                    break;
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function soft_delete($id)
    {
        if(!$this->allow['soft_delete']) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }
        $formData['user_id'] = AuthCommon::user()->id;
        $run = (new $this->service)->softDelete($id, $formData);
        if(isset($run->rc)){
            switch ($run->statusCode) {
                case "200":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                        ],
                        200
                    );
                    break;
                case "422":
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => $run->data,
                        ],
                        422
                    );
                    break;
                default:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        400
                    );
                    break;
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function restore($id)
    {
        if(!$this->allow['restore']) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        $formData['user_id'] = AuthCommon::user()->id;
        $run = (new $this->service)->restore($id, $formData);
        
        if(isset($run->rc)){
            switch ($run->statusCode) {
                case "201":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                        ],
                        200
                    );
                    break;
                case "422":
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => $run->data,
                        ],
                        422
                    );
                    break;
                default:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        400
                    );
                    break;
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }

    public function list_trash()
    {
        if(!$this->allow['list_trash']) abort('403');

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Sampah";
        $icon = "fas fa-stream";
        $module = $this->module;
        $module_name = $this->module_name;

        return view('pages.'.$this->folder.'.list_trash', compact('allow', 'help_key', 'group', 'icon', 'module', 'module_name'));
    }

    public function change_status($id, Request $request)
    {
        if(!$this->allow['change_status']) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        $formData['user_id'] = AuthCommon::user()->id;
        $formData['status'] = $request->status;

        $run = (new $this->service)->changeStatus($id, $formData);
        
        if(isset($run->rc)){
            switch ($run->statusCode) {
                case "201":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                        ],
                        200
                    );
                    break;
                case "422":
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => $run->data,
                        ],
                        422
                    );
                    break;
                default:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        400
                    );
                    break;
            }
        }

        return response([
            "status" => false,
            "message" => "Bad Request",
            "data" => []
        ], 400);
    }
}
