<?php

namespace App\Http\Controllers\ManageAuth;

use App\Helpers\AuthCommon;
use App\Helpers\PermissionCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = "module";
        $this->module_name = "Module";
        $this->service = ModuleService::class;
        $this->help_key = "master.module";
        $this->folder = "master.module";

        $this->allow = [
            "list" => PermissionCommon::check($this->module . ".list"),
            "create" => PermissionCommon::check($this->module . ".create"),
            "delete" => PermissionCommon::check($this->module . ".delete"),
            "update" => PermissionCommon::check($this->module . ".update"),
            "show" => PermissionCommon::check($this->module . ".show"),
            "export" => PermissionCommon::check($this->module . ".export"),
            "change_status" => PermissionCommon::check($this->module . ".change_status"),
            "list_trash" => PermissionCommon::check($this->module . ".list_trash"),
            "soft_delete" => PermissionCommon::check($this->module . ".soft_delete"),
            "restore" => PermissionCommon::check($this->module . ".restore"),
            "permission" => PermissionCommon::check("permission.list"),
        ];
    }

    public function index()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Master";
        $icon = "fas fa-cube";
        $module = $this->module;
        $module_name = $this->module_name;

        return view("pages." . $this->folder . ".list", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function create()
    {
        if (!$this->allow["create"]) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $body = view("pages." . $this->folder . ".create", [
                "module" => $this->module,
                "module_name" => $this->module_name,
                "folder" => $this->folder,
            ])->render();

            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>';
        }

        return [
            "title" => "Tambah " . $this->module_name,
            "body" => $body,
            "footer" => $footer,
        ];
    }

    public function store(Request $request)
    {
        if (!$this->allow["create"]) {
            return response(
                [
                    "status" => false,
                    "message" => "403 | Forbidden",
                ],
                400
            );
        }

        $request->validate(
            [
                "module" => "required",
                "deskripsi" => "required",
            ],
            [
                "required" => "Kolom :attribute wajib diisi.",
            ]
        );

        $formData = $request->except("_token");
        $formData["user_id"] = AuthCommon::user()->id;

        $run = (new $this->service())->create($formData);

        if (isset($run->rc)) {
            switch ($run->rc) {
                case ResponseConstant::RC_VALIDATION_ERROR:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => Util::validationConvert(@$run->data),
                        ],
                        422
                    );

                    break;
                case ResponseConstant::RC_CREATE_SUCCESS:
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function show($id)
    {
        $run = (new $this->service())->datatable([
            "id" => $id,
        ]);
        if (isset($run->recordsFiltered) && (int) $run->recordsFiltered > 0) {
            $data = $run->data[0];

            if (!$this->allow["show"]) {
                $body = "<h3>403 | Forbidden</h3>";
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            } else {
                $body = view("pages." . $this->folder . ".show", compact("data"))->render();
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }

            return [
                "title" => "Detail " . $this->module_name,
                "body" => $body,
                "footer" => $footer,
            ];
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function edit($id)
    {
        $run = (new $this->service())->datatable([
            "id" => $id,
        ]);
        if (isset($run->recordsFiltered) && (int) $run->recordsFiltered > 0) {
            $data = $run->data[0];

            if (!$this->allow["update"]) {
                $body = "<h3>403 | Forbidden</h3>";
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            } else {
                $body = view("pages." . $this->folder . ".edit", [
                    "id" => $id,
                    "data" => $data,
                    "folder" => $this->folder,
                    "module" => $this->module,
                    "module_name" => $this->module_name,
                ])->render();
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>';
            }

            return [
                "title" => "Edit " . $this->module_name,
                "body" => $body,
                "footer" => $footer,
            ];
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function update(Request $request, $id)
    {
        if (!$this->allow["update"]) {
            return response(
                [
                    "status" => false,
                    "message" => "403 | Forbidden",
                ],
                400
            );
        }

        $request->validate(
            [
                "module" => "required",
                "deskripsi" => "required",
            ],
            [
                "required" => "Kolom :attribute wajib diisi.",
            ]
        );

        $formData = $request->except("_token");
        $formData["id"] = $id;
        $formData["user_id"] = AuthCommon::user()->id;

        $run = (new $this->service())->update($formData);

        if (isset($run->rc)) {
            switch ($run->rc) {
                case ResponseConstant::RC_VALIDATION_ERROR:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => Util::validationConvert(@$run->data),
                        ],
                        422
                    );

                    break;
                case ResponseConstant::RC_UPDATE_SUCCESS:
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function destroy($id)
    {
        if (!$this->allow["delete"]) {
            return response(
                [
                    "status" => false,
                    "message" => "403 | Forbidden",
                ],
                400
            );
        }

        $run = (new $this->service())->delete($id);
        if (isset($run->rc)) {
            switch ($run->rc) {
                case ResponseConstant::RC_VALIDATION_ERROR:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => Util::validationConvert(@$run->data),
                        ],
                        422
                    );

                    break;
                case ResponseConstant::RC_DELETE_SUCCESS:
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function soft_delete($id)
    {
        if (!$this->allow["soft_delete"]) {
            return response(
                [
                    "status" => false,
                    "message" => "403 | Forbidden",
                ],
                400
            );
        }

        $formData["user_id"] = AuthCommon::user()->id;
        $run = (new $this->service())->softDelete($id, $formData);

        if (isset($run->rc)) {
            switch ($run->rc) {
                case ResponseConstant::RC_VALIDATION_ERROR:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => Util::validationConvert(@$run->data),
                        ],
                        422
                    );

                    break;
                case ResponseConstant::RC_SOFT_DELETE_SUCCESS:
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function restore($id)
    {
        if (!$this->allow["restore"]) {
            return response(
                [
                    "status" => false,
                    "message" => "403 | Forbidden",
                ],
                400
            );
        }

        $formData["user_id"] = AuthCommon::user()->id;
        $run = (new $this->service())->restore($id, $formData);

        if (isset($run->rc)) {
            switch ($run->rc) {
                case ResponseConstant::RC_VALIDATION_ERROR:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => Util::validationConvert(@$run->data),
                        ],
                        422
                    );

                    break;
                case ResponseConstant::RC_RESTORE_SUCCESS:
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function list_trash()
    {
        if (!$this->allow["list_trash"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Sampah";
        $icon = "fas fa-cube";
        $module = $this->module;
        $module_name = $this->module_name;

        return view("pages." . $this->folder . ".list_trash", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function change_status($id, Request $request)
    {
        if (!$this->allow["change_status"]) {
            return response(
                [
                    "status" => false,
                    "message" => "403 | Forbidden",
                ],
                400
            );
        }

        $formData["user_id"] = AuthCommon::user()->id;
        $formData["status"] = $request->status;

        $run = (new $this->service())->changeStatus($id, $formData);

        if (isset($run->rc)) {
            switch ($run->rc) {
                case ResponseConstant::RC_VALIDATION_ERROR:
                    return response(
                        [
                            "status" => false,
                            "message" => $run->rm,
                            "errors" => Util::validationConvert(@$run->data),
                        ],
                        422
                    );

                    break;
                case ResponseConstant::RC_UPDATE_SUCCESS:
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        }

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }
}
