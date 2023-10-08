<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\{AuthCommon, GoogleClient, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\Manage\SlikService;
use App\Services\Setting\SettingBPRService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BackupController extends Controller
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

        $this->module = "backup";
        $this->module_name = "Backup";
        $this->service = UserService::class;
        $this->folder = "setting.backup";
    }

    public function index()
    {
        if (!$this->allow["list"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
    
        $group = "Setting";
        $icon = "fas fa-id-card";
        $module = $this->module;
        $module_name = $this->module_name;
        $files = [];
        $google_credentials = [];
        $run = (new SettingBPRService())->get_google_credentials();
        $is_logged_in = false;

        $google = new GoogleClient();
        if (isset($_GET["code"])) {
            // Authenticate and start the session
            $google->authenticate($_GET["code"]);
        }

        if(!isset($run->status)){

            if (!isset($run->rc) || $run->rc != "00") {
                return response()->json([
                    "status" => false,
                    "message" => $run->rm ?? "Gagal mengambil data",
                    "data" => $run,
                ]);
            }
    
            
            foreach ($run->data as $key => $value) {
                $google_credentials[$value->key] = $value->value;
            }
    
           
            $is_logged_in = $google->isLoggedIn();
            // dd($is_logged_in);
            // dd(Session::all());
            if ($is_logged_in) {
                $google->initDriveService();
                $files = $google->getFileListFromGoogleDrive();
            }

        }

        return view("pages." . $this->folder . ".list", compact("allow", "group", "icon", "module", "module_name", "is_logged_in", "files", "google_credentials"));
    }

    public function login()
    {
        $google = new GoogleClient(); //Create GoogleClient Object

        // Check if the user is logged in
        if (!$google->isLoggedIn()) {
            // Go to Google Login Page
            header("Location: " . $google->getAuthURL());
            exit();
        }

        if (isset($_GET["code"])) {
            // Authenticate and start the session
            $google->authenticate($_GET["code"]);
        }
    }

    public function backup_slik(Request $request)
    {
        $validate = $request->validate([
            "id" => "required",
            "key" => "required",
        ]);

        $id = $request->id;
        $key = $request->key;

        $google = new GoogleClient();

        $is_logged_in = $google->isLoggedIn();
        if (!$is_logged_in) {
            return response()->json([
                "status" => false,
                "message" => "Login terlebih dahulu",
                "data" => [],
            ]);
        }

        $run = (new SlikService())->read_raw_slik_by_id2($id, ["cipher_key" => $key]);
        if (isset($run->statusCode) && $run->statusCode == "200" && $run->rc == "00") {
            $data = $run->data;
            $string = json_encode($data->slik);
            $google->initDriveService();

            try {
                $file_name = date("YmdHis") . "__" . $data->file_name;
                $upload = $google->uploadFileTxt($file_name, $string);
                return response()->json(
                    [
                        "status" => true,
                        "message" => "Berhasil backup data",
                        "data" => $upload,
                    ],
                    200
                );
            } catch (\Exception $e) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Error uploading file to Google Drive",
                        "data" => $e->getMessage(),
                    ],
                    400
                );
            }
        } else {
            return response()->json(
                [
                    "status" => false,
                    "message" => $run->rm ?? "Gagal backup data",
                    "data" => null,
                ],
                400
            );
        }
    }
}
