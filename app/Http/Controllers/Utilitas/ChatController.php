<?php

namespace App\Http\Controllers\Utilitas;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\ManageAuth\UserService;
use Illuminate\Http\Request;

class ChatController extends Controller
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

        $this->module = "chat";
        $this->module_name = "Chat";
        $this->service = UserService::class;
        $this->help_key = "utilitas.chat";
        $this->folder = "utilitas.chat";
    }

    public function index()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        $auth = AuthCommon::user();
        $data = (new UserService())->get_user_list_support();
        if (isset($data->data)) {
            $user = $data->data;
        } else {
            $user = [];
        }
        $user = json_encode($user);
        $current_user = json_encode([
            "id" => $auth->id,
            "name" => $auth->name,
            "number" => null,
            "pic" => null,
        ]);

        return view("pages." . $this->folder . ".list", compact("user", "current_user"));
    }
}
