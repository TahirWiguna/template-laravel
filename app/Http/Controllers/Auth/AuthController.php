<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuthCommon;
use App\Helpers\TokenCommon;
use App\Services\ManageAuth\AuthService;
use App\Http\Controllers\Controller;
use App\Rules\ReCaptcha;
use App\Services\Setting\SettingBPRService;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use DB;

class AuthController extends Controller
{
    //

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function login()
    {
        // dd('xx');
        $auth = AuthCommon::user();
        if (isset($auth->username)) {
            return redirect("admin/dashboard");
        }
        return view("auth.login");
    }

    public function login_process(Request $request)
    {
        $rules = [
            "username" => "required",
            "password" => "required",
            "g-recaptcha-response" => ["required", new ReCaptcha()],
        ];

        $message = [
            "g-recaptcha-response.required" => "Recaptcha wajib dilengkapi",
            "username.required" => "Username tidak boleh kosong",
            "password.required" => "Password tidak boleh kosong",
        ];

        if (!env("RECAPTCHA")) {
            unset($rules["g-recaptcha-response"]);
            unset($message["g-recaptcha-response.required"]);
        }
        $request->validate($rules, $message);

        $body = $request->except("g-recaptcha-response");
        $run = (new AuthService())->login($body);
        if (!isset($run->rc)) {
            return redirect()
                ->route("auth.login")
                ->with(["error" => "Layanan Bermasalah"]);
        }

        if (isset($run->rc) && $run->rc == "00") {
            // if ($run->data->user->role_id === 2) {
            //     return redirect()
            //         ->route("auth.login")
            //         ->with(["error" => "AO tidak dapat login di sini"]);
            // }

            if (isset($run->data->access_token)) {
                TokenCommon::setToken("BEARER_TOKEN", $run->data->access_token);
            }

            $run2 = (new AuthService())->userInfo();
            if (!isset($run2->rc)) {
                return redirect()
                    ->route("auth.login")
                    ->with(["error" => "Layanan Bermasalah"]);
            }

            $google_credentials = (new SettingBPRService())->get_google_credentials();
            if (isset($google_credentials->rc) && $google_credentials->rc == "00") {
                $google_credentials2 = [];
                foreach ($google_credentials->data as $key => $value) {
                    $google_credentials2[$value->key] = $value->value;
                }

                if (isset($google_credentials2["GOOGLE_DRIVE_CLIENT_ID"]) && isset($google_credentials2["GOOGLE_DRIVE_SECRET_KEY"])) {
                    app("session")->put("GOOGLE_DRIVE_CLIENT_ID", $google_credentials2["GOOGLE_DRIVE_CLIENT_ID"]);
                    app("session")->put("GOOGLE_DRIVE_SECRET_KEY", $google_credentials2["GOOGLE_DRIVE_SECRET_KEY"]);
                }
            }

            if (isset($run2->rc) && $run2->rc == "00") {
                AuthCommon::setUser($run2->data);
                $permission = @$run2->data->permission;
                if ($permission != null) {
                    $permission = array_map(function ($permission) {
                        return $permission;
                    }, $permission);
                    app("session")->put("slug_permit", $permission);
                } else {
                    app("session")->put("slug_permit", []);
                }
                return redirect()
                    ->route("dashboard.index")
                    ->with(["initFCM" => true]);
            } else {
                return redirect()
                    ->route("auth.login")
                    ->with(["error" => "Error tidak terdefinisi"]);
            }
        } else {
            return redirect()
                ->route("auth.login")
                ->with(["error" => $run->rm]);
        }

        return redirect()
            ->route("auth.login")
            ->with(["error" => "Error tidak terdefinisi"]);
    }

    public function logout()
    {
        AuthCommon::logout();
        return redirect("/");
    }
}
