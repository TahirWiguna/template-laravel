<?php

use App\Http\Middleware\RyunnaAuth;
use Illuminate\Support\Facades\Route;
use App\Helpers\AuthCommon;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\ManageAuth\{UserController, RoleController, PermissionController, ModuleController};
use App\Http\Controllers\Manage\{LjkController, PengajuanController, SlikController, NasabahController};
use App\Http\Controllers\Report\{AdminReportController, PengajuanReportController, RekomendasiReportController};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\Master\BPRController;
use App\Http\Controllers\Setting\BackupController;
use App\Http\Controllers\Setting\KeyController;
use App\Http\Controllers\Setting\SettingBPRController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Utilitas\ChatController;
use App\Http\Controllers\Utilitas\NotifikasiController;
use App\Http\Controllers\WikiContentController;
use App\Http\Controllers\WikiHeaderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("timezone", function () {
    dd(date("Y-m-d H:i:s"));
});

Route::get("/", function () {
    return redirect("/login");
});

// Auth
Route::namespace("App\Http\Controllers\Auth")->group(function () {
    Route::get("/login", [AuthController::class, "login"])->name("auth.login");
    Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout");
    Route::post("/login_process", [AuthController::class, "login_process"])->name("auth.login_process");
});

// Page
Route::prefix("public")->group(function () {
    Route::get("/privacy_policy", function () {
        return view("privacy_policy.v1");
    })->name("privacy_policy");
});

Route::prefix("admin")
    ->middleware([RyunnaAuth::class])
    ->group(function () {
        Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard.index");
        Route::post("/dashboard/save_token/", [DashboardController::class, "save_token"])->name("dashboard.save_token");
        Route::get("/dashboard/notification/", [DashboardController::class, "notification"])->name("dashboard.notification");
        Route::get("/dashboard/count_notification/", [DashboardController::class, "count_notification"])->name("dashboard.count_notification");

        //Manage
        Route::namespace("App\Http\Controllers\Manage")
            ->prefix("manage")
            ->group(function () {
            });

        Route::namespace("App\Http\Controllers\ManageAuth")
            ->prefix("manage_auth")
            ->group(function () {
                customResources([
                    "user" => UserController::class,
                    "role" => RoleController::class,
                    "permission" => PermissionController::class,
                ]);
                Route::get("/role/permission/{id}", [RoleController::class, "permission"])->name("role.permission");
            });

        Route::namespace("App\Http\Controllers\Master")
            ->prefix("manage_auth")
            ->group(function () {
                customResources([
                    // "bpr" => BPRController::class,
                ]);
                Route::prefix("bpr")->group(function () {
                    Route::get("/select2_branch", [BPRController::class, "select2_branch"])->name("bpr.select2_branch");
                });
            });

        Route::namespace("App\Http\Controllers\ManageAuth")
            ->prefix("manage_auth")
            ->group(function () {
                customResources([
                    "user" => UserController::class,
                    "role" => RoleController::class,
                    "permission" => PermissionController::class,
                ]);
                Route::get("/role/permission/{id}", [RoleController::class, "permission"])->name("role.permission");
                Route::put("/role/update_permission/{id}", [RoleController::class, "update_permission"])->name("role.update_permission");
            });

        Route::namespace("App\Http\Controllers\Setting")
            ->prefix("setting")
            ->group(function () {
                Route::get("/key", [KeyController::class, "index"])->name("key.index");
                Route::get("/backup", [BackupController::class, "index"])->name("backup.index");
                Route::get("/backup/login", [BackupController::class, "login"])->name("backup.login");
                Route::post("/backup/backup_slik", [BackupController::class, "backup_slik"])->name("backup.backup_slik");
                Route::post("/backup/backup_all", [BackupController::class, "backup_all"])->name("backup.backup_all");
            });

        Route::namespace("App\Http\Controllers\Utilitas")
            ->prefix("utilitas")
            ->group(function () {
                customResources([
                    "notifikasi" => NotifikasiController::class,
                    "chat" => ChatController::class,
                ]);
            });

        Route::namespace("App\Http\Controllers\Report")
            ->prefix("report")
            ->group(function () {
                Route::get("/penggunaan", [AdminReportController::class, "index"])->name("penggunaan.report");
                Route::post("/datatable_pengajuan_comparation", [AdminReportController::class, "datatable_pengajuan_comparation"])->name("datatable_pengajuan_comparation.report");
                Route::get("/pengajuan_comparation", [AdminReportController::class, "pengajuan_comparation"])->name("pengajuan_comparation.report");
                Route::post("/datatable_pengajuan_status", [AdminReportController::class, "datatable_pengajuan_status"])->name("datatable_pengajuan_status.report");
            });

        Route::namespace("App\Http\Controllers\SettingBPR")
            ->prefix("setting_bpr")
            ->group(function () {
                Route::post("/set", [SettingBPRController::class, "set"])->name("setting_bpr.set");
                Route::post("/set_google_credentials", [SettingBPRController::class, "set_google_credentials"])->name("setting_bpr.set_google_credentials");
            });

        Route::namespace("App\Http\Controllers\Setting")
            ->prefix("setting")
            ->group(function () {
                Route::get("/profile", [SettingController::class, "index"])->name("setting.profile");
                Route::get("/change_password", [SettingController::class, "change_password"])->name("setting.change_password");
                Route::post("/do_change_password", [SettingController::class, "do_change_password"])->name("setting.do_change_password");
            });
    });

function customResources($arr)
{
    foreach ($arr as $name => $controller) {
        Route::resources([
            $name => $controller,
        ]);

        Route::post("/$name/datatable", [$controller, "datatable"])->name("$name.datatable");
        Route::post("/$name/select2", [$controller, "select2"])->name("$name.select2");
        Route::delete("/$name/delete/soft/{id}", [$controller, "soft_delete"])->name("$name.soft_delete");
        Route::delete("/$name/delete/{id}", [$controller, "delete"])->name("$name.delete");
        Route::post("/$name/change_status/{id}", [$controller, "change_status"])->name("$name.change_status");
        Route::get("/$name/edit/{id}", [$controller, "edit"])->name("$name.edit");
        Route::get("/$name/create", [$controller, "create"])->name("$name.create");
    }
}
