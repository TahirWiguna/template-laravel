<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\ManageAuth\UserService;
use App\Services\Setting\SettingBPRService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingBPRController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "list" => PermissionCommon::check("setting_bpr.read"),
                "create" => PermissionCommon::check("setting_bpr.create"),
            ];
            return $next($request);
        });

        $this->module = "key";
        $this->module_name = "Key";
        $this->service = UserService::class;
        $this->help_key = "setting.key";
        $this->folder = "setting.key";
    }

    public function index()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Setting";
        $icon = "fas fa-id-card";
        $module = $this->module;
        $module_name = $this->module_name;

        return view("pages." . $this->folder . ".list", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function set(Request $request)
    {
        if (!$this->allow["create"]) {
            return response(
                [
                    "status" => false,
                    "message" => "Forbidden",
                ],
                403
            );
        }

        $request->validate([
            "key" => "required|max:255",
            "value" => "required|max:1000",
        ]);

        $formData = $request->all();

        $run = (new SettingBPRService())->set($formData);

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

    public function set_google_credentials(Request $request)
    {
        if (!$this->allow["create"]) {
            return response(
                [
                    "status" => false,
                    "message" => "Forbidden",
                ],
                403
            );
        }

        $request->validate([
            "client_id" => "required|max:255",
            "client_secret" => "required|max:255",
        ]);

        $client_id = $request->client_id;
        $client_secret = $request->client_secret;

        $formData = [
            "client_id" => $client_id,
            "client_secret" => $client_secret,
        ];

        $run = (new SettingBPRService())->set_google_credentials($formData);
        if (isset($run->rc)) {
            switch ($run->statusCode) {
                case "200":
                    Session::put("GOOGLE_DRIVE_CLIENT_ID", $client_id);
                    Session::put("GOOGLE_DRIVE_SECRET_KEY", $client_secret);
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
