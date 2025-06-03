<?php

use App\Exports\MachineExport;
use App\Exports\UsersExport;
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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Mail\AssetReminderEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Assets;
use Maatwebsite\Excel\Facades\Excel;

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
    Route::get('/user/{uuid}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{uuid}/update', [UserController::class, 'update'])->name('user.update');
    Route::resource('department', DeptController::class);
    Route::resource('plant', PlantController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('asset', AssetController::class)->except(['show']);
    Route::post('/asset/upload-csv', [AssetController::class, 'importCsv'])->name('asset.importCsv');
    Route::get('asset/export-assets', [AssetController::class, 'exportExcelAssets'])->name('asset.exportExcel');
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
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-ppbj', [CalController::class, 'addNotes'])->name('external.save-notes-ppbj');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-ppbj', [CalController::class, 'addApprovePpbj'])->name('external.addApprovePpbj');

    Route::post('sertifikat/eksternal/negosiasiFilestore/{uuid}', [CalController::class, 'negosiasiFilestore'])->name('negosiasiFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-negosiasi', [CalController::class, 'addNotes'])->name('external.save-notes-negosiasi');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-negosiasi', [CalController::class, 'addApproveNegosiasi'])->name('external.addApproveNegosiasi');

    Route::post('sertifikat/eksternal/spkFilestore/{uuid}', [CalController::class, 'spkFilestore'])->name('spkFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-spk', [CalController::class, 'addNotes'])->name('external.save-notes-spk');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-spk', [CalController::class, 'addApproveSpk'])->name('external.addApproveSpk');

    Route::post('sertifikat/eksternal/pelaksanaanFilestore/{uuid}', [CalController::class, 'pelaksanaanFilestore'])->name('pelaksanaanFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-pelaksanaan', [CalController::class, 'addNotes'])->name('external.save-notes-pelaksanaan');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-pelaksanaan', [CalController::class, 'addApprovePelaksanaan'])->name('external.addApprovePelaksanaan');

    Route::post('sertifikat/eksternal/baFilestore/{uuid}', [CalController::class, 'baFilestore'])->name('baFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-ba', [CalController::class, 'addNotes'])->name('external.save-notes-ba');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-ba', [CalController::class, 'addApproveBa'])->name('external.addApproveBa');

    Route::post('sertifikat/eksternal/pembayaranFilestore/{uuid}', [CalController::class, 'pembayaranFilestore'])->name('pembayaranFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-pembayaran', [CalController::class, 'addNotes'])->name('external.save-notes-pembayaran');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-pembayaran', [CalController::class, 'addApprovePembayaran'])->name('external.addApprovePembayaran');

    Route::post('sertifikat/eksternal/sertifikatFilestore/{uuid}', [CalController::class, 'sertifikatFilestore'])->name('sertifikatFileStore');
    Route::post('/sertifikat/eksternal/{uuid}/add-notes-sertifikat', [CalController::class, 'addNotes'])->name('external.save-notes-sertifikat');
    Route::post('/sertifikat/eksternal/{uuid}/add-approve-sertifikat', [CalController::class, 'addApproveSertifikat'])->name('external.addApproveSertifikat');

    Route::get('/calibration/late-calibration', [CalController::class, 'lateCalibration'])->name('late-calibration');

    Route::get('/calibration/calibrated-assets', [CalController::class, 'calibratedAssets'])->name('calibrated-assets');

    Route::get('/test-email', function () {
        $asset = \App\Models\Assets::first(); // ambil salah satu asset
        \Illuminate\Support\Facades\Mail::to('rizalfahadian7@gmail.com')->send(new \App\Mail\AssetReminderEmail($asset));
        return "Email sent!";
    });

    Route::get('/dashboard/toggle/{table}', [DashboardController::class, 'toggleTableVisibility'])->name('dashboard.toggleTable');
    Route::get('/validation/{machine_uuid}/{uuid}', [ValidationController::class, 'validation'])->name('validation.index');

    Route::post('/validation_asset/send-warning', [Validation_assetController::class, 'sendEarlyWarning'])->name('validation_asset.sendWarning');
    Route::post('/validation-asset/early-warning-2', [Validation_assetController::class, 'sendEarlyWarning2'])->name('validation_asset.sendEarlyWarning2');
    Route::get('/export-validation-assets', [Validation_assetController::class, 'exportExcelValidtionAssets'])->name('validationAsset.exportExcel');
    Route::get('/validation/slaughterhouse/screwchiller', [ValidationController::class, 'screwChiller'])->name('slaughterhouse-screwchiller');
    Route::get('/validation/slaughterhouse/ABF', [ValidationController::class, 'ABF'])->name('slaughterhouse-ABF');
    Route::get('/validation/slaughterhouse/IQF', [ValidationController::class, 'IQF'])->name('slaughterhouse-IQF');
    Route::get('/validation/further/fryer-1', [ValidationController::class, 'fryer1'])->name('further-fryer-1');
    Route::get('/validation/further/fryer-2', [ValidationController::class, 'fryer2'])->name('further-fryer-2');
    Route::get('/validation/further/fryer-marel', [ValidationController::class, 'fryerMarel'])->name('further-fryer-marel');
    Route::get('/validation/further/hi-cook', [ValidationController::class, 'hiCook'])->name('further-hi-cook');

    Route::get('/validation/sausage/smoke-house', [ValidationController::class, 'smokeHouse'])->name('sausage-smoke-house');

    Route::get('/validation/sausage/smoke-house-fessmann', [ValidationController::class, 'smokeHouseFessmann'])->name('sausage-smoke-house-fessmann');

    Route::get('/validation/breadcrumb/aging', [ValidationController::class, 'aging'])->name('breadcrumb-aging');

    Route::get('/validation/laboratory/autoclave1', [ValidationController::class, 'autoclave1'])->name('laboratory-autoclave1');

    Route::get('/validation/laboratory/autoclave2', [ValidationController::class, 'autoclave2'])->name('laboratory-autoclave2');

    Route::get('/validation/laboratory/ovenmemert1', [ValidationController::class, 'ovenMemert1'])->name('laboratory-ovenmemert1');

    Route::get('/validation/laboratory/ovenmemert2', [ValidationController::class, 'ovenMemert2'])->name('laboratory-ovenmemert2');



    Route::get('report/validation/addDataScrewchiller', [ValidationController::class, 'screwChiller_addData'])->name('report.validation.addDataScrewchiller');
    Route::get('report/validation/addDataABF', [ValidationController::class, 'ABF_addData'])->name('report.validation.addDataABF');
    Route::get('report/validation/addDataIQF', [ValidationController::class, 'IQF_addData'])->name('report.validation.addDataIQF');
    Route::get('report/validation/addDataFryer1', [ValidationController::class, 'fryer1_addData'])->name('report.validation.addDataFryer1');
    Route::get('report/validation/addDataFryer2', [ValidationController::class, 'fryer2_addData'])->name('report.validation.addDataFryer2');
    Route::get('report/validation/addDataFryerMarel', [ValidationController::class, 'fryerMarel_addData'])->name('report.validation.addDataFryerMarel');
    Route::get('report/validation/addDatahiCook', [ValidationController::class, 'hiCook_addData'])->name('report.validation.addDatahiCook');
    Route::get('report/validation/addDataSmokeHouse', [ValidationController::class, 'smokeHouse_addData'])->name('report.validation.addDataSmokeHouse');
    Route::get('report/validation/addDataSmokeHouseFessmann', [ValidationController::class, 'smokeHouseFessmann_addData'])->name('report.validation.addDataSmokeHouseFessmann');
    Route::get('report/validation/addDataAging', [ValidationController::class, 'aging_addData'])->name('report.validation.addDataAging');
    Route::get('report/validation/addDataAutoclave1', [ValidationController::class, 'autoclave1_addData'])->name('report.validation.addDataAutoclave1');
    Route::get('report/validation/addDataAutoclave2', [ValidationController::class, 'autoclave2_addData'])->name('report.validation.addDataAutoclave2');
    Route::get('report/validation/addDataOvenmemert1', [ValidationController::class, 'ovenMemert1_addData'])->name('report.validation.addDataOvenmemert1');
    Route::get('report/validation/addDataOvenmemert2', [ValidationController::class, 'ovenMemert2_addData'])->name('report.validation.addDataOvenmemert2');

    Route::post('/validation/abf/store', [ValidationController::class, 'storeABF'])->name('validation.storeABF');
    Route::delete('/validation/abf/{id}', [ValidationController::class, 'deleteABF'])->name('validation.abf.delete');
    Route::get('/validation/abf/print/{id}', [ValidationController::class, 'printABF'])->name('report.abf.print');

    Route::post('/validation/fryerMarel/store', [ValidationController::class, 'storeFryerMarel'])->name('validation.storeFryerMarel');
    Route::delete('/validation/fryerMarel/{id}', [ValidationController::class, 'deleteFryerMarel'])->name('validation.fryerMarel.delete');
    Route::get('/validation/fryerMarel/print/{id}', [ValidationController::class, 'printFryerMarel'])->name('report.fryerMarel.print');

    Route::post('/validation/fryer1/store', [ValidationController::class, 'storeFryer1'])->name('validation.storeFryer1');
    Route::delete('/validation/fryer1/{id}', [ValidationController::class, 'deleteFryer1'])->name('validation.fryer1.delete');
    Route::get('/validation/fryer1/print/{id}', [ValidationController::class, 'printFryer1'])->name('report.fryer1.print');

    Route::post('/validation/fryer2/store', [ValidationController::class, 'storeFryer2'])->name('validation.storeFryer2');
    Route::delete('/validation/fryer2/{id}', [ValidationController::class, 'deleteFryer2'])->name('validation.fryer2.delete');
    Route::get('/validation/fryer2/print/{id}', [ValidationController::class, 'printFryer2'])->name('report.fryer2.print');

    Route::post('/validation/hiCook/store', [ValidationController::class, 'storeHiCook'])->name('validation.storehiCook');
    Route::delete('/validation/hiCook/{id}', [ValidationController::class, 'deleteHiCook'])->name('validation.hiCook.delete');
    Route::get('/validation/hiCook/print/{id}', [ValidationController::class, 'printHiCook'])->name('report.hiCook.print');







    Route::get('/validation/iqf/print', [ValidationController::class, 'printIQF'])->name('report.iqf.print');

    Route::get('/validation/screwchiller/print', [ValidationController::class, 'printScrewChiller'])->name('report.screwchiller.print');

    Route::get('/validation/smokeHouse/print', [ValidationController::class, 'printSmokehouse'])->name('report.smokeHouse.print');

    Route::get('/validation/smokeHouseFessmann/print', [ValidationController::class, 'printSmokehouseFessmann'])->name('report.smokeHouseFessmann.print');

    Route::get('/validation/aging/print', [ValidationController::class, 'printAging'])->name('report.aging.print');

    Route::get('/validation/autoclave1/print', [ValidationController::class, 'printAutoclave1'])->name('report.autoclave1.print');

    Route::get('/validation/autoclave2/print', [ValidationController::class, 'printAutoclave2'])->name('report.autoclave2.print');

    Route::get('/validation/ovenmemert1/print', [ValidationController::class, 'printOvenmemert1'])->name('report.ovenmemert1.print');

    Route::get('/validation/ovenmemert2/print', [ValidationController::class, 'printOvenmemert2'])->name('report.ovenmemert2.print');





    // ROLE ROUTES
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/roles/{role}/manage-access', [RoleController::class, 'manageAccess'])->name('roles.manage-access');
    Route::post('/roles/{role}/manage-access', [RoleController::class, 'updateAccess'])->name('roles.manage-access.update');

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});
