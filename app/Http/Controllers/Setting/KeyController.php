<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\UserService;

class KeyController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "list" => PermissionCommon::check("slik.enc_cipher"),
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
}
