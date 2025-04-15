<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\RefController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Validation_assetController;
use App\Http\Controllers\WeightController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('actionLogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::get('/go-back', function () {
    return redirect()->back();
})->name('goBack');
Route::get('/image/{filename}', function ($filename) {
    $path = storage_path('app/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('actionLogout', [AuthController::class, 'actionLogout'])->name('actionLogout');
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/{uuid}/delete', [UserController::class, 'destroy'])->name('user.delete');
    Route::resource('department', DeptController::class);
    Route::resource('plant', PlantController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('asset', AssetController::class);
    Route::post('/asset/upload-csv', [AssetController::class, 'importCsv'])->name('asset.importCsv');
    Route::resource('machine', MachineController::class);
    Route::resource('weight', WeightController::class);
    Route::resource('validation_asset', Validation_assetController::class);
    Route::post('/validation_asset/upload-csv', [Validation_assetController::class, 'importCsv'])->name('validation_asset.importCsv');
    Route::get('report', [ReportController::class, 'index'])->name('report');
    Route::get('report/temperature', [ReportController::class, 'temperature'])->name('report.temperature');
    Route::get('report/temperature/addData', [ReportController::class, 'temperature_addData'])->name('report.addDataTemperature');
    Route::post('report/temperature/store', [ReportController::class, 'temperature_store'])->name('report.storeDataTemperature');
    Route::get('report/export/temperature/{uuid}', [ReportController::class, 'exportTempExcel'])->name('report.exportDataTemperature');
    Route::get('report/display', [ReportController::class, 'display'])->name('report.display');
    Route::get('report/display/addData', [ReportController::class, 'display_addData'])->name('report.addDataDisplay');
    Route::post('report/display/store', [ReportController::class, 'display_store'])->name('report.storeDataDisplay');
    Route::get('report/export/display/{uuid}', [ReportController::class, 'exportDisplayExcel'])->name('report.exportDataDisplay');
    Route::get('report/scale', [ReportController::class, 'scale'])->name('report.scale');
    Route::get('report/scale/addData', [ReportController::class, 'scale_addData'])->name('report.addDataScale');
    Route::post('report/scale/store', [ReportController::class, 'scale_store'])->name('report.storeDataScale');
    Route::get('sertifikat/internal', [CalController::class, 'internal'])->name('Internal_calibration');
    Route::get('sertifikat/internal/temperature', [CalController::class, 'temperature'])->name('Internal_calibration.temperature');
    Route::get('sertifikat/internal/temperature/{uuid}/print', [CalController::class, 'temperature_pdfPrint'])->name('Internal_calibration.PrintPDFTemperature');
    Route::get('sertifikat/internal/display', [CalController::class, 'display'])->name('Internal_calibration.display');
    Route::get('sertifikat/internal/display/{uuid}/print', [CalController::class, 'display_pdfPrint'])->name('Internal_calibration.PrintPDFdisplay');
    Route::get('sertifikat/internal/scale', [CalController::class, 'scale'])->name('Internal_calibration.scale');
    Route::get('sertifikat/internal/scale/{uuid}/print', [CalController::class, 'scale_pdfPrint'])->name('Internal_calibration.PrintPDFScale');
    Route::get('sertifikat/internal/scale', [CalController::class, 'scale'])->name('Internal_calibration.scale');
    Route::get('sertifikat/eksternal', [CalController::class, 'external'])->name('External_calibration');
    Route::post('sertifikat/eksternal/store', [CalController::class, 'externalStore'])->name('External_calibration.storeExternalCalibration');
    Route::get('referensi', [RefController::class, 'index'])->name('references');
    Route::resource('references', RefController::class);
});