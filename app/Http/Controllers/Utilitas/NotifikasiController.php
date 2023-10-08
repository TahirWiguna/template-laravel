<?php

namespace App\Http\Controllers\Utilitas;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\Utilitas\NotifikasiService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "list" => PermissionCommon::check($this->module . ".read"),
                "create" => PermissionCommon::check($this->module . ".create"),
            ];
            return $next($request);
        });

        $this->module = "notifikasi";
        $this->module_name = "Notifikasi";
        $this->service = NotifikasiService::class;
        $this->help_key = "utilitas.notifikasi";
        $this->folder = "utilitas.notifikasi";
    }

    public function index()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Utilitas";
        $icon = "fas fa-user";
        $module = $this->module;
        $module_name = $this->module_name;

        return view("pages." . $this->folder . ".list", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function datatable()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        // $formData = '';
        $formData = [];

        $run = (new $this->service())->datatable($formData);
        return $run;
    }
    public function create()
    {
        if (!$this->allow["create"]) {
            abort("403");
        }

        $module = $this->module;
        $folder = $this->folder = "utilitas.notifikasi";
        if (!PermissionCommon::check("notifikasi.create")) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        } else {
            $target_user = (new NotifikasiService())->getTargetUser();
            if (isset($target_user->rc) && $target_user->rc == "00") {
                $target_user = $target_user->data;
            } else {
                $target_user = [];
            }
            $body = view("pages.utilitas.notifikasi.create", compact("module", "folder", "target_user"))->render();
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save()">Save</button>';
        }

        return [
            "title" => "Create Notifikasi",
            "body" => $body,
            "footer" => $footer,
        ];
    }

    public function store(Request $request)
    {
        if (!$this->allow["create"]) {
            abort("403");
        }

        $auth = AuthCommon::user();
        $group = $auth->group ?? null;

        $validate = [
            "title" => "required",
            "header" => "required",
            "body" => "required",
            "image_url" => "required",
            "notification_type" => "required",
        ];

        if ($request->notification_type == "custom") {
            $validate["custom_type"] = "required";
        }

        if ($request->custom_type == "bpr") {
            // $validate["target_bpr"] = "required";
        } elseif ($request->custom_type == "user") {
            $validate["ids_user"] = "required";
        }

        $request->validate($validate);
        $formData = $request->except(["_token"]);

        $run = (new NotifikasiService())->create($formData);
        if (isset($run->rc)) {
            switch ($run->statusCode) {
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
                case "201":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => isset($run->data) ? $run->data : null,
                        ],
                        200
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
        } else {
            return response(
                [
                    "status" => false,
                    "message" => "Failed Connect to Server",
                ],
                400
            );
        }
    }

    public function edit($id)
    {
        if (!$this->allow["edit"]) {
            abort("403");
        }

        $run = (new NotifikasiService())->getById($id);
        // dd($run);
        if (isset($run->rc) && $run->rc == "00") {
            $data = $run->data;
            $module = $this->module;
            $folder = $this->folder = "utilitas.notifikasi";
            if (!PermissionCommon::check("notifikasi.update")) {
                $body = "<h3>403 | Forbidden</h3>";
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            } else {
                $body = view("pages.utilitas.notifikasi.edit", compact("id", "data", "module", "folder"))->render();
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save</button>';
            }

            return [
                "title" => "Edit Notifikasi",
                "body" => $body,
                "footer" => $footer,
            ];
        }

        return response(
            [
                "status" => false,
                "message" => "Failed Connect to Server",
            ],
            400
        );
    }

    public function update(Request $request, $id)
    {
        if (!$this->allow["edit"]) {
            abort("403");
        }

        $request->validate([
            "nik" => "required",
            "nama" => "required",
        ]);

        $formData = $request->except("_token", "_method");

        $run = (new NotifikasiService())->update($id, $formData);
        // dd($run);
        if (isset($run->rc) && $run->rc == "00") {
            return response(
                [
                    "status" => true,
                    "message" => "Data Saved Successfully",
                ],
                200
            );
        } else {
            return response(
                [
                    "status" => false,
                    "message" => isset($run->rm) ? $run->rm : "Data Failed to Save",
                ],
                400
            );
        }
    }

    public function delete($id)
    {
        if (!$this->allow["edit"]) {
            abort("403");
        }

        $run = (new NotifikasiService())->delete($id);
        if (isset($run->rc) && $run->rc == "00") {
            return response(
                [
                    "status" => true,
                    "message" => "Success Delete Data!",
                ],
                200
            );
        } else {
            return response(
                [
                    "status" => false,
                    "message" => "Data gagal di hapus",
                ],
                400
            );
        }
    }
}
