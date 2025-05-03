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
use App\Http\Controllers\TelatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Validation_assetController;
use App\Http\Controllers\WeightController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Mail\AssetReminderEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Assets;

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

    Route::post('/report/temperature/approve/{uuid}', [ReportController::class, 'approveTemperature'])->name('temperature.approve');

    Route::post('/report/display/approve/{uuid}', [ReportController::class, 'approveDisplay'])->name('display.approve');

    Route::post('/report/scale/approve/{uuid}', [ReportController::class, 'approveScale'])->name('scale.approve');
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

    Route::post('sertifikat/eksternal/penawaranFileStore/{uuid}', [CalController::class, 'penawaranFileStore'])->name('penawaranFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes', [CalController::class, 'addNotes'])->name('external.save-notes');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve', [CalController::class, 'addApprove'])->name('external.addApprove');

    Route::post('sertifikat/eksternal/ppbjFilestore/{uuid}', [CalController::class, 'ppbjFilestore'])->name('ppbjFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-ppbj', [CalController::class, 'addNotesPpbj'])->name('external.save-notes-ppbj');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-ppbj', [CalController::class, 'addApprovePpbj'])->name('external.addApprovePpbj');

    Route::post('sertifikat/eksternal/negosiasiFilestore/{uuid}', [CalController::class, 'negosiasiFilestore'])->name('negosiasiFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-negosiasi', [CalController::class, 'addNotesNegosiasi'])->name('external.save-notes-negosiasi');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-negosiasi', [CalController::class, 'addApproveNegosiasi'])->name('external.addApproveNegosiasi');

    Route::post('sertifikat/eksternal/spkFilestore/{uuid}', [CalController::class, 'spkFilestore'])->name('spkFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-spk', [CalController::class, 'addNotesSpk'])->name('external.save-notes-spk');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-spk', [CalController::class, 'addApproveSpk'])->name('external.addApproveSpk');

    Route::post('sertifikat/eksternal/pelaksanaanFilestore/{uuid}', [CalController::class, 'pelaksanaanFilestore'])->name('pelaksanaanFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-pelaksanaan', [CalController::class, 'addNotesPelaksanaan'])->name('external.save-notes-pelaksanaan');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-pelaksanaan', [CalController::class, 'addApprovePelaksanaan'])->name('external.addApprovePelaksanaan');

    Route::post('sertifikat/eksternal/baFilestore/{uuid}', [CalController::class, 'baFilestore'])->name('baFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-ba', [CalController::class, 'addNotesBa'])->name('external.save-notes-ba');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-ba', [CalController::class, 'addApproveBa'])->name('external.addApproveBa');

    Route::post('sertifikat/eksternal/pembayaranFilestore/{uuid}', [CalController::class, 'pembayaranFilestore'])->name('pembayaranFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-pembayaran', [CalController::class, 'addNotesPembayaran'])->name('external.save-notes-pembayaran');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-pembayaran', [CalController::class, 'addApprovePembayaran'])->name('external.addApprovePembayaran');

    Route::post('sertifikat/eksternal/sertifikatFilestore/{uuid}', [CalController::class, 'sertifikatFilestore'])->name('sertifikatFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-sertifikat', [CalController::class, 'addNotesSertifikat'])->name('external.save-notes-sertifikat');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-sertifikat', [CalController::class, 'addApproveSertifikat'])->name('external.addApproveSertifikat');

    Route::get('/calibration/late-calibration', [CalController::class, 'lateCalibration'])->name('late-calibration');

    Route::get('/calibration/calibrated-assets', [CalController::class, 'calibratedAssets'])->name('calibrated-assets');

    Route::get('/test-email', function () {
        $asset = \App\Models\Assets::first(); // ambil salah satu asset
        \Illuminate\Support\Facades\Mail::to('rizalfahadian7@gmail.com')->send(new \App\Mail\AssetReminderEmail($asset));
        return "Email sent!";
    });

    Route::get('/dashboard/toggle/{table}', [DashboardController::class, 'toggleTableVisibility'])->name('dashboard.toggleTable');

    Route::get('/validation/slaughterhouse/screwchiller', [ValidationController::class, 'screwChiller'])->name('slaughterhouse-screwchiller');

    Route::get('/validation/further/fryer-1', [ValidationController::class, 'fryer1'])->name('further-fryer-1');
    Route::get('/validation/further/fryer-2', [ValidationController::class, 'fryer2'])->name('further-fryer-2');
    Route::get('/validation/further/fryer-marel', [ValidationController::class, 'fryerMarel'])->name('further-fryer-marel');
    Route::get('/validation/further/hi-cook', [ValidationController::class, 'hiCook'])->name('further-hi-cook');

    Route::get('/validation/sausage/smoke-house', [ValidationController::class, 'smokeHouse'])->name('sausage-smoke-house');

    Route::get('/validation/breadcrumb/aging', [ValidationController::class, 'aging'])->name('breadcrumb-aging');

    Route::post('/validation_asset/send-warning', [Validation_assetController::class, 'sendEarlyWarning'])->name('validation_asset.sendWarning');
    Route::post('/validation-asset/early-warning-2', [Validation_assetController::class, 'sendEarlyWarning2'])->name('validation_asset.sendEarlyWarning2');
});