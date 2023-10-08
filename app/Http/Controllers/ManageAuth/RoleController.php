<?php

namespace App\Http\Controllers\ManageAuth;

use App\Helpers\AuthCommon;
use App\Helpers\PermissionCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Services\ManageAuth\PermissionService;
use App\Services\ManageAuth\RoleService;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = "role";
        $this->module_name = "Role";
        $this->service = RoleService::class;
        $this->help_key = "manage_auth.role";
        $this->folder = "manage_auth.role";

        $this->middleware(function ($request, $next) {
            $this->allow = [
                "read" => PermissionCommon::check($this->module . ".read"),
                "create" => PermissionCommon::check($this->module . ".create"),
                "update" => PermissionCommon::check($this->module . ".update"),
                "delete" => PermissionCommon::check($this->module . ".delete"),
                "soft_delete" => PermissionCommon::check($this->module . ".soft_delete"),
                "export" => PermissionCommon::check($this->module . ".export"),
                "permission" => PermissionCommon::check("permission.create"),
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
        $run = (new RoleService())->datatable($formData);
        return $run;
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

        $request->validate([
            "name" => "required",
        ]);

        $formData = $request->except("_token");
        $run = (new RoleService())->create($formData);

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
        $run = (new RoleService())->get_by_id($id);
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
            "name" => "required",
        ]);

        $formData = $request->except("_token");

        $run = (new RoleService())->update($id, $formData);
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

        $run = (new RoleService())->delete($id);
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
        $run = (new RoleService())->softDelete($id, $formData);
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

    public function permission($role_id)
    {
        if (!$this->allow["permission"]) {
            abort(403);
        }

        if (!$role_id) {
            return redirect()->back();
        }

        $role = (new RoleService())->get_by_id($role_id);
        if (!isset($role->statusCode) || $role->statusCode != "200") {
            return redirect()->back();
        }
        $role = $role->data;

        $perm = (new PermissionService())->datatable([]);
        if (!isset($perm->statusCode) || $perm->statusCode != "200") {
            return redirect()->back();
        }
        $perm = $perm->data;

        $role_perm = (new RoleService())->get_role_permission($role_id);
        if (!isset($role_perm->statusCode) || $role_perm->statusCode != "200") {
            return redirect()->back();
        }
        $role_perm = $role_perm->data;
        // dd($role_perm);
        $grouped_perm = [];
        foreach ($perm as $item) {
            $module = $item->module;
            if (!isset($grouped_perm[$module])) {
                $grouped_perm[$module] = [];
            }
            $grouped_perm[$module][] = $item;
        }

        foreach ($grouped_perm as $key => $value) {
            foreach ($value as $key2 => $item) {
                if (in_array($item->slug, $role_perm)) {
                    $grouped_perm[$key][$key2]->checked = true;
                } else {
                    $grouped_perm[$key][$key2]->checked = false;
                }
            }
        }

        return view("pages.manage_auth.role.permission", compact("grouped_perm", "role_id", "role"));

        // return redirect()->route('role.index')->with(['error' => 'Failed Connect to Server']);
    }

    public function update_permission(Request $request, $role_id)
    {
        $request->validate([
            "permission" => "required",
        ]);

        $formData = $request->except("_token");
        $run = (new PermissionService())->update_all($role_id, $formData);
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
}
