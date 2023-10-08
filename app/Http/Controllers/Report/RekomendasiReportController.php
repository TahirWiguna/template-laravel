<?php

namespace App\Http\Controllers\Report;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\Manage\PengajuanService;
use App\Services\Report\RekomendasiPengajuanService;
use Illuminate\Http\Request;

class RekomendasiReportController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "read" => PermissionCommon::check($this->module . ".read"),
                "export" => PermissionCommon::check($this->module . ".export"),
            ];
            return $next($request);
        });

        $this->module = "rekomendasi";
        $this->module_name = "Rekomendasi";
        $this->help_key = "report.rekomendasi";
        $this->folder = "report.rekomendasi";
    }

    public function index()
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $allow = json_encode($this->allow);
        $help_key = $this->help_key;

        $group = "Report";
        $icon = "fas fa-user";
        $module = $this->module;
        $module_name = $this->module_name;

        $pengajuan = [];
        $run_pengajuan = (new RekomendasiPengajuanService())->get_pengajuan();
        if (isset($run_pengajuan->data)) {
            $pengajuan = $run_pengajuan->data;
        } else {
            return response("Failed to connect to the server.", 400);
        }

        return view("pages." . $this->folder . ".list", compact("allow", "help_key", "group", "icon", "module", "module_name", "pengajuan"));
    }

    public function filter(Request $request)
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $run = (new RekomendasiPengajuanService())->filter($request->id_pengajuan);
        if (isset($run->rc)) {
            switch ($run->statusCode) {
                case "200":
                    return response(
                        [
                            "status" => true,
                            "message" => $run->rm,
                            "data" => $run->data,
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
        } else {
            return response(
                [
                    "status" => false,
                    "message" => "Failed to connect to the server.",
                    "data" => [],
                ],
                400
            );
        }
    }

    public function datatable()
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $formData = [];
        $run = (new RekomendasiPengajuanService())->datatable($formData);
        return $run;
    }
}
