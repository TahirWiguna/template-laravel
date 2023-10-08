<?php

namespace App\Http\Controllers\Report;

use App\Helpers\{AuthCommon, PermissionCommon, ResponseConstant, Util};
use App\Http\Controllers\Controller;
use App\Services\Manage\PengajuanService;
use Illuminate\Http\Request;
use PDF;

class PengajuanReportController extends Controller
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

        $this->module = "pengajuan";
        $this->module_name = "Pengajuan";
        $this->help_key = "report.pengajuan";
        $this->folder = "report.pengajuan";
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

    public function filter(Request $request)
    {
        if (!$this->allow["read"]) {
            abort("403");
        }

        $request->validate([
            "start_date" => "required|date|date_format:Y-m-d",
            "end_date" => "required|date|date_format:Y-m-d|after:start_date",
        ]);

        $formData = $request->all();

        $run = (new PengajuanService())->filter($formData);
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
        $run = (new PengajuanService())->datatable($formData);
        return $run;
    }

    public function print($id_pengajuan, $cipher_key)
    {   
        if (!$this->allow["read"]) {
            abort("403");
        }

        $requestData = [
            'id_pengajuan' => $id_pengajuan,
            'cipher_key' => $cipher_key
        ];

        $run = (new PengajuanService())->print($requestData);
        
        $data = [];
        if (isset($run->rc)) {
            switch  ($run->statusCode) {
                case "200":
                    $data = $run->data;
                    break;
                default:
                    $data = $run->data;
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
        // dd($data);
        $html = [];
        $html[] = view("pages." . $this->folder . ".print.pengajuan", compact('data'))->render();
        $html[] = view("pages." . $this->folder . ".print.debitur", compact('data'))->render();
        $html[] = view("pages." . $this->folder . ".print.jaminan", compact('data'))->render();
        $html[] = view("pages." . $this->folder . ".print.rekap_slik", compact('data'))->render();
        $html[] = view("pages." . $this->folder . ".print.rekomendasi_so", compact('data'))->render();
        
        $pdf = PDF::loadview("pages." . $this->folder . ".print.print_all", ["html" => $html]);
        return $pdf->stream();
    }
}
