<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MJobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\MMaterialController;
use App\Http\Controllers\ExportDataController;
use App\Http\Controllers\FE\ServiceController;
use App\Http\Controllers\DailyReportJobController;
use App\Http\Controllers\FE\ParticipantController;
use App\Http\Controllers\TrainingContentController;
use App\Http\Controllers\DailyReportMaterialController;
use App\Http\Controllers\MaterialBalanceController;
use App\Http\Controllers\MaterialPickupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login-admin');
    });
    Route::get('/admin', function () {
        return redirect('/login-admin');
    });

    Route::get('/login-admin', [AuthController::class, 'index']);
    Route::post('/login-admin', [AuthController::class, 'auth']);
    Route::get('/register-admin', [AuthController::class, 'register']);
    Route::post('/register-admin', [AuthController::class, 'store']);
});


Route::middleware('admin')->group(function () {
    Route::get('/profile', [UserController::class, 'index']);
    Route::get('/dashboard', [Dashboard::class, 'index']);

    Route::get('/export/admin', [ExportDataController::class, 'export']);

    Route::get('/data-admin', [UserController::class, 'dataUser']);
    Route::get('/getDetailAdmin', [UserController::class, 'getDetailAdmin']);
    Route::get('/form-add-admin', [UserController::class, 'addFormAdmin']);
    Route::post('/add-new-admin', [UserController::class, 'storeAdmin']);
    Route::get('/form-edit-admin/{number}', [UserController::class, 'editFormAdmin']);
    Route::post('/edit-new-admin', [UserController::class, 'updateAdmin']);
    Route::delete('/delete-admin/{number}', [UserController::class, 'deleteAdmin']);

    Route::get('/data-staff', [StaffController::class, 'dataStaff']);
    Route::get('/getDetailStaff', [StaffController::class, 'getDetailStaff']);
    Route::get('/form-add-staff', [StaffController::class, 'addFormStaff']);
    Route::post('/add-new-staff', [StaffController::class, 'storeStaff']);
    Route::get('/form-edit-staff/{number}', [StaffController::class, 'editFormStaff']);
    Route::post('/edit-new-staff', [StaffController::class, 'updateStaff']);
    Route::delete('/delete-staff/{number}', [StaffController::class, 'deleteStaff']);

    // Master Data //
    Route::get('/data-job', [MJobController::class, 'dataJob']);
    Route::post('/add-new-job', [MJobController::class, 'storeJob']);
    Route::put('/edit-new-job', [MJobController::class, 'updateJob']);
    Route::delete('/delete-job/{number}', [MJobController::class, 'deleteJob']);
    // Master Data //
    Route::get('/data-material', [MMaterialController::class, 'dataMaterial']);
    Route::post('/add-new-material', [MMaterialController::class, 'storeJob']);
    Route::put('/edit-new-material', [MMaterialController::class, 'updateJob']);
    Route::delete('/delete-material/{number}', [MMaterialController::class, 'deleteJob']);

    // AJAX //
    Route::get('/get-master-jobs', [MJobController::class, 'getMasterJob']);
    Route::post('/save-tr-jobs', [MJobController::class, 'saveTrJob']);
    Route::post('/delete-tr-job', [MJobController::class, 'deleteTrJob']);

    Route::get('/get-master-materials', [MMaterialController::class, 'getMasterMaterial']);
    Route::post('/save-tr-materials', [MMaterialController::class, 'saveTrMaterial']);
    Route::post('/delete-tr-materials', [MMaterialController::class, 'deleteTrMaterial']);

    Route::get('/get-material-balance', [MMaterialController::class, 'getMaterialBalance']);

    // DAFTAR PROYEK //
    Route::get('/project-list', [ProjectController::class, 'index']);
    Route::get('/form-project', [ProjectController::class, 'form_project']);
    Route::get('/form-project/{id}', [ProjectController::class, 'form_project']);
    Route::get('/job-of-project', [ProjectController::class, 'jobOfProject']); // AJAX //
    Route::get('/material-of-project', [ProjectController::class, 'materialOfProject']); // AJAX //
    Route::post('/store-project', [ProjectController::class, 'saveProject']);
    Route::delete('/delete-project/{id}', [ProjectController::class, 'deleteProject']);

    // AJAX GET PROJECT //
    Route::get('/get-project', [ProjectController::class, 'getProjectBySPK']);
    Route::get('/get-project-id', [ProjectController::class, 'getProjectById']);

    Route::post('/save-daily-report-jobs', [MJobController::class, 'saveReportJob']);
    Route::post('/delete-daily-report-jobs', [MJobController::class, 'deleteDailyReportJob']);

    Route::post('/save-daily-report-materials', [MMaterialController::class, 'saveReportMaterial']);
    Route::post('/delete-daily-report-materials', [MMaterialController::class, 'deleteDailyReportMaterial']);

    Route::post('/save-material-pickup', [MMaterialController::class, 'saveMaterialPickup']);
    Route::post('/delete-material-pickup', [MMaterialController::class, 'deleteMaterialPickup']);

    Route::post('/save-material-balance', [MMaterialController::class, 'saveMaterialBalance']);
    Route::post('/delete-material-balance', [MMaterialController::class, 'deleteMaterialBalance']);

    // DAFTAR LAPORAN HARIAN PEKERJAAN //
    Route::get('/job-daily-report', [DailyReportJobController::class, 'index']);
    Route::get('/form-job-daily-report', [DailyReportJobController::class, 'formJobDailyReport']);
    Route::get('/form-job-daily-report/{id}', [DailyReportJobController::class, 'formJobDailyReport']);
    Route::get('/job-daily-report-details', [DailyReportJobController::class, 'jobOfDailyReportDetails']); // AJAX //
    Route::post('/store-job-daily-report', [DailyReportJobController::class, 'saveDailyReport']);
    Route::delete('/delete-job-daily-report/{id}', [DailyReportJobController::class, 'deleteDailyReport']);

    // DAFTAR LAPORAN HARIAN MATERIAL //
    Route::get('/material-daily-report', [DailyReportMaterialController::class, 'index']);
    Route::get('/form-material-daily-report', [DailyReportMaterialController::class, 'formMaterialDailyReport']);
    Route::get('/form-material-daily-report/{id}', [DailyReportMaterialController::class, 'formMaterialDailyReport']);
    Route::get('/material-daily-report-details', [DailyReportMaterialController::class, 'materialOfDailyReportDetails']); // AJAX //
    Route::post('/store-material-daily-report', [DailyReportMaterialController::class, 'saveDailyReport']);
    Route::delete('/delete-material-daily-report/{id}', [DailyReportMaterialController::class, 'deleteDailyReport']);

    // DAFTAR PENGAMBILAN MATERIAL //
    Route::get('/material-pickup', [MaterialPickupController::class, 'index']);
    Route::get('/form-material-pickup', [MaterialPickupController::class, 'formMaterialPickup']);
    Route::get('/form-material-pickup/{id}', [MaterialPickupController::class, 'formMaterialPickup']);
    Route::get('/material-pickup-details', [MaterialPickupController::class, 'materialPickupDetails']); // AJAX //
    Route::post('/store-material-pickup', [MaterialPickupController::class, 'saveMaterialPickup']);
    Route::delete('/delete-material-pickup/{id}', [MaterialPickupController::class, 'deleteMaterialPickup']);

    // DAFTAR BALANCE MATERIAL //
    Route::get('/material-balance', [MaterialBalanceController::class, 'index']);
    Route::get('/form-material-balance', [MaterialBalanceController::class, 'formMaterialBalance']);
    Route::get('/form-material-balance/{id}', [MaterialBalanceController::class, 'formMaterialBalance']);
    Route::get('/detail-material-balance', [MaterialBalanceController::class, 'detailMaterialBalance']); // AJAX //
    Route::post('/store-material-balance', [MaterialBalanceController::class, 'saveMaterialBalance']);

    Route::post('/logout-admin', [AuthController::class, 'logout']);
});


