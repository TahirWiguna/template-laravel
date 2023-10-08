<?php

namespace App\Http\Controllers\Report;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\Manage\PengajuanService;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;
use PDF;

class AdminReportController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "read" => PermissionCommon::check("chat.read"),
                "export" => PermissionCommon::check("chat.export"),
            ];
            return $next($request);
        });

        $this->module = "penggunaan";
        $this->module_name = "Laporan Penggunaan";
        $this->help_key = "report.penggunaan";
        $this->folder = "report.penggunaan";
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

        return view("pages." . $this->folder . ".list", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function pengajuan_comparation()
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

        return view("pages." . $this->folder . ".list_pengajuan_comparation", compact("allow", "help_key", "group", "icon", "module", "module_name"));
    }

    public function datatable_pengajuan_status(Request $request)
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $formData = $request->except("_token");
        $run = (new DashboardService())->datatable_pengajuan_status($formData);
        return $run;
    }

    public function datatable_pengajuan_comparation(Request $request)
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $formData = $request->except("_token");
        $run = (new DashboardService())->datatable_pengajuan_comparation($formData);
        return $run;
    }

}
