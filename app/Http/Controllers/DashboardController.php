<?php

namespace App\Http\Controllers;

use App\Helpers\AuthCommon;
use App\Helpers\FileRun;
use App\Helpers\PermissionCommon;
use App\Helpers\StorageCommon;
use App\Services\Dashboard\DashboardService;
use App\Services\Init\InitService;
use App\Services\ManageAuth\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    //

    private $allow;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->allow = [
                "read" => PermissionCommon::check("dashboard.read"),
                "chart" => PermissionCommon::check("init.chart"),
                "notif" => PermissionCommon::check("notifikasi.read"),
            ];
            return $next($request);
        });
    }

    public function index()
    {
        // dd(Session::all());
        $auth = AuthCommon::user();
        $formData = [];

        $perm = $this->allow;

        // $chart_pengajuan = $this->chart_pengajuan();
        // $chart_pengajuan_today = $this->chart_pengajuan_today();
        // $chart_pengajuan_status = $this->chart_pengajuan_status();
        // $data_pengajuan_today = $this->data_pengajuan_today();
        // $chart_pengajuan_comparison = $this->chart_pengajuan_comparison();

        // return view("pages.dashboard.v1", compact("perm", "chart_pengajuan", "chart_pengajuan_today", "chart_pengajuan_status", "data_pengajuan_today", "chart_pengajuan_comparison"));
        return view("pages.dashboard.v1", compact("perm"));
    }

    public function save_token(Request $request)
    {
        $token = $request->token;

        $run = (new UserService())->save_token($token);
        if ($run->statusCode == 200) {
            return response()->json([
                "status" => true,
                "message" => "Token berhasil disimpan",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Token gagal disimpan",
            ]);
        }
    }

    public function notification()
    {
        $title = "Notification";
        if (!$this->allow["notif"]) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $data = [
                "length" => 100,
                "page" => 1,
            ];

            $run = (new DashboardService())->notification($data);
            if ($run->statusCode == 200 && isset($run->data)) {
                $body = view("pages.dashboard.notification", ["data" => $run->data])->render();
            } else {
                $body = "<h3>" . $run->rm . "</h3>";
            }

            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        }

        return [
            "title" => $title,
            "body" => $body,
            "footer" => $footer,
        ];
    }

    public function count_notification()
    {
        if (!$this->allow["notif"]) {
            return response()->json([
                "status" => false,
                "message" => "Forbidden",
                "data" => 0,
            ]);
        }

        $run = (new DashboardService())->count_notification();
        if ($run->statusCode == 200 && isset($run->data)) {
            return response()->json([
                "status" => false,
                "message" => "Success",
                "data" => $run->data,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Failed",
                "data" => 0,
            ]);
        }
    }

    public function data_ao($id)
    {
        if (!$this->allow["chart"]) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $title = "Data AO";

            $run = (new DashboardService())->data_ao_insight($id);
            if ($run->statusCode == 200 && isset($run->data)) {
                $title = "Data AO " . $run->data->name . " - All Time";
                $body = view("pages.dashboard.show", ["data" => $run->data])->render();
            } else {
                $body = "<h3>" . $run->rm . "</h3>";
            }

            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        }

        return [
            "title" => $title,
            "body" => $body,
            "footer" => $footer,
        ];
    }

    public function pengajuan_status_detail($name)
    {
        $name = urldecode($name);
        if (!$this->allow["chart"]) {
            $body = "<h3>403 | Forbidden</h3>";
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $title = "Data AO";

            $run = (new DashboardService())->pengajuan_status_detail($name);
            if ($run->statusCode == 200 && isset($run->data)) {
                $title = "Data AO " . $name;
                // dd($run);
                $body = view("pages.dashboard.show_detail_status", ["data" => $run->data])->render();
            } else {
                $body = "<h3>" . $run->rm . "</h3>";
            }

            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        }

        return [
            "title" => $title,
            "body" => $body,
            "footer" => $footer,
        ];
    }

    public function datatable_nasabah_tracker()
    {
        $formData = request()->all();
        $run = (new DashboardService())->datatable_nasabah_tracker($formData);
        return $run;
    }

    private function chart_pengajuan()
    {
        $chart = [
            "label" => [],
            "value" => [],
        ];
        $run = (new DashboardService())->chart_pengajuan();
        if ($run->statusCode == 200) {
            $chart = $chart = array_column($run->data, "y");
        }
        return $chart;
    }

    private function chart_pengajuan_today()
    {
        $chart = [
            "label" => [],
            "value" => [],
        ];

        $run = (new DashboardService())->chart_pengajuan_today();
        if ($run->statusCode == 200 && isset($run->data)) {
            $chart["label"] = array_column($run->data, "label");
            $chart["value"] = array_column($run->data, "value");
        }
        return $chart;
    }

    private function chart_pengajuan_comparison()
    {
        $chart = [
            "label" => [],
            "pengajuan" => [],
            "rekomendasi" => [],
        ];

        $run = (new DashboardService())->chart_pengajuan_comparison();
        if ($run->statusCode == 200 && isset($run->data)) {
            foreach ($run->data as $key => $value) {
                $chart["label"][] = $value->name;
                $chart["pengajuan"][] = $value->pengajuan;
                $chart["rekomendasi"][] = $value->rekomendasi;
            }
        }
        return $chart;
    }

    private function data_pengajuan_today()
    {
        $data = [];

        $run = (new DashboardService())->data_pengajuan_today();
        if ($run->statusCode == 200 && isset($run->data)) {
            $data = $run->data;
        }
        return $data;
    }

    private function chart_pengajuan_status()
    {
        $chart = [
            "label" => [],
            "status_1" => [],
            "status_2" => [],
            "status_3" => [],
        ];

        $run = (new DashboardService())->chart_pengajuan_status();
        if ($run->statusCode == 200 && isset($run->data)) {
            $chart["label"] = array_column($run->data, "name");
            $chart["status_1"] = array_column($run->data, "status_1");
            $chart["status_2"] = array_column($run->data, "status_2");
            $chart["status_3"] = array_column($run->data, "status_3");
        }
        return $chart;
    }
}
