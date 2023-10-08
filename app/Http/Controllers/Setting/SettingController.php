<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\{AuthCommon, GoogleClient, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\Manage\SlikService;
use App\Services\Setting\SettingBPRService;
use App\Services\ManageAuth\UserService;
use App\Services\ManageAuth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    private $module, $module_name, $service, $folder, $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "list" => PermissionCommon::check("setting.backup"),
            ];
            return $next($request);
        });

        $this->module = "setting";
        $this->module_name = "Setting";
        $this->service = UserService::class;
        $this->folder = "setting.user";
    }

    public function index()
    {  
        $user = AuthCommon::user();
        $run = (new UserService())->get_by_id($user->id);
        if(isset($run->data)){
            $user = $run->data;
        }

        return view("pages." . $this->folder . ".setting",compact("user"));
    }
    public function change_password()
    {  
        $user = AuthCommon::user();
        return view("pages." . $this->folder . ".change_password", compact("user"));
    }

    public function do_change_password(Request $request){

        $request->validate([
            "old_password" => "required|min:6|max:255",
            "password" => "required|confirmed|min:6|max:255",
        ]);
        $user = AuthCommon::user();
        $body = $request->except("_token");
        $body['password'] = $request->old_password;
        $run = (new AuthService())->login($body);

        if (isset($run->rc) && $run->rc != "00" ) {
            return response(
                        [
                            "status" => false,
                            "message" => "Invalid old password",
                            "errors" => ["Invalid old password"],
                        ],
                        422
                    );
                            
        }

        $formData = $request->except("_token");
        $run = (new UserService())->update($user->id,$formData);

        if (isset($run->rc)) {
            switch ($run->statusCode) {
                case "200":
                    return response(
                        [
                            "status" => true,
                            "message" => "Password berhasil diganti",
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
