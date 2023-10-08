<?php

namespace App\Http\Controllers\ManageAuth;

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

class UserController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = "user";
        $this->module_name = "User";
        $this->service = UserService::class;
        $this->help_key = "manage_auth.user";
        $this->folder = "manage_auth.user";

        $this->middleware(function ($request, $next) {
            $this->allow = [
                "read" => PermissionCommon::check($this->module . ".read"),
                "create" => PermissionCommon::check($this->module . ".create"),
                "update" => PermissionCommon::check($this->module . ".update"),
                "delete" => PermissionCommon::check($this->module . ".delete"),
                "soft_delete" => PermissionCommon::check($this->module . ".soft_delete"),
                "export" => PermissionCommon::check($this->module . ".export"),
                "permission" => PermissionCommon::check("permission.create"),
                "is_adminroot" => PermissionCommon::check("auth.adminroot"),
                "is_adminbpr" => PermissionCommon::check("auth.adminbpr"),
                "is_memberbpr" => PermissionCommon::check("auth.memberbpr"),
            ];
            return $next($request);
        });
    }

    public function index()
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Manage Auth";
        $icon = "fas fa-user-lock";
        $module = $this->module;
        $module_name = $this->module_name;

        return view("pages." . $this->folder . ".list", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function datatable()
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $formData = request()->all();
        $run = (new UserService())->datatable($formData);
        return $run;
    }

    public function create()
    {
        if (!$this->allow["create"]) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $role = (object) [];
            if ($this->allow["is_adminroot"]) {
                $bpr = (new BprService())->datatable([]);
                if (!isset($bpr->data)) {
                    return response(
                        [
                            "status" => false,
                            "message" => "Bad Request",
                            "data" => [],
                        ],
                        400
                    );
                }

                $bpr_branch = (new BprService())->datatable_branch([]);
                if (!isset($bpr_branch->data)) {
                    return response(
                        [
                            "status" => false,
                            "message" => "Bad Request",
                            "data" => [],
                        ],
                        400
                    );
                }

                $role = (new RoleService())->datatable([]);
                if (!isset($role->data)) {
                    return response(
                        [
                            "status" => false,
                            "message" => "Bad Request",
                            "data" => [],
                        ],
                        400
                    );
                }
            } elseif ($this->allow["is_adminbpr"]) {
            } elseif ($this->allow["is_memberbpr"]) {
            }
            $body = view("pages." . $this->folder . ".create", [
                "module" => $this->module,
                "module_name" => $this->module_name,
                "folder" => $this->folder,
                "role" => isset($role->data) ? $role->data : (object) [],
                "bpr" => isset($bpr->data) ? $bpr->data : (object) [],
                "bpr_branch" => isset($bpr_branch->data) ? $bpr_branch->data : (object) [],
                "allow" => $this->allow,
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

        if (!$this->allow["is_adminroot"]) {
            $request->merge(["bpr_id" => AuthCommon::user()->bpr_id]);
            $request->merge(["bpr_branch_id" => AuthCommon::user()->bpr_branch_id]);
            $request->merge(["role_id" => 2]);
        }

        $request->validate([
            "name" => "required|max:255",
            "email" => "required|max:255",
            "phone_number" => "nullable|min:10|max:15",
            "whatsapp" => "nullable|min:10|max:15",
            "telegram" => "nullable|min:10|max:15",
            "bpr_id" => "required|max:255",
            "bpr_branch_id" => "nullable|max:255",
            "role_id" => "required|max:255",
            "username" => "required|max:255",
            "password" => "required|max:255",
        ]);

        $formData = $request->except("_token");
        $run = (new UserService())->create($formData);

        if (isset($run->rc)) {
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
        if (!$this->allow["update"]) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $user = (new UserService())->get_by_id($id);
            if (!isset($user->data)) {
                return response(
                    [
                        "status" => false,
                        "message" => "User Not found",
                        "data" => [],
                    ],
                    400
                );
            }

            $current_branch = (new BprService())->datatable_branch([
                "columns" => [
                    [
                        "data" => "id",
                        "name" => "id",
                        "searchable" => "true",
                        "orderable" => "true",
                        "search" => [
                            "value" => $user->data->bpr_branch_id,
                            "regex" => "false",
                        ]
                    ],
                ],
            ]);
            if (!isset($current_branch->data)) {
                $current_branch = (object) [];
            } else {
                $current_branch = $current_branch->data[0];
            }


            $role = (object) [];
            if ($this->allow["is_adminroot"]) {
                $bpr = (new BprService())->datatable([]);
                if (!isset($bpr->data)) {
                    return response(
                        [
                            "status" => false,
                            "message" => "Bad Request",
                            "data" => [],
                        ],
                        400
                    );
                }

                $role = (new RoleService())->datatable([]);
                if (!isset($role->data)) {
                    return response(
                        [
                            "status" => false,
                            "message" => "Bad Request",
                            "data" => [],
                        ],
                        400
                    );
                }
            } elseif ($this->allow["is_adminbpr"]) {
            } elseif ($this->allow["is_memberbpr"]) {
            }
            $body = view("pages." . $this->folder . ".edit", [
                "module" => $this->module,
                "module_name" => $this->module_name,
                "folder" => $this->folder,
                "role" => isset($role->data) ? $role->data : (object) [],
                "bpr" => isset($bpr->data) ? $bpr->data : (object) [],
                "data" => $user->data,
                "id" => $id,
                "allow" => $this->allow,
                "current_branch" => $current_branch,
            ])->render();

            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>';

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

        $request->validate([
            "name" => "required|max:255",
            "email" => "required|max:255",
        ]);

        $formData = $request->except("_token", "_method");
        $run = (new UserService())->update($id, $formData);
        if (isset($run->rc)) {
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

        $run = (new UserService())->delete($id);
        if (isset($run->rc)) {
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
        $run = (new UserService())->softDelete($id, $formData);
        if (isset($run->rc)) {
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

        return response(
            [
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
            ],
            400
        );
    }

    public function delete($id)
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

        $run = (new UserService())->delete($id);
        if (isset($run->rc)) {
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
