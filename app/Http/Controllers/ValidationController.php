<?php

namespace App\Http\Controllers;

use App\Exports\DisplayCalibrationExport;
use App\Exports\TempCalibrationExport;
use App\Models\Actual_display_calibration;
use App\Models\Actual_eccentricity_scale;
use App\Models\Actual_repeatability_scale;
use App\Models\actual_temp_calibration;
use App\Models\Assets;
use App\Models\Display_calibration;
use App\Models\Eccentricity_scale_calibration;
use App\Models\Repeatability_scale_calibration;
use App\Models\Scale_calibration;
use App\Models\temp_calibration;
use App\Models\Weighing_performance;
use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ValidationController extends Controller
{
    // slaughterhouse
    public function screwChiller()
    {
        return view('validation.slaughterhouse.screwchiller');
    }

    public function screwChiller_addData()
    {
        return view('validation.store.store_screwchiller');
    }

    public function ABF()
    {
        return view('validation.slaughterhouse.ABF');
    }

    public function ABF_addData()
    {
        return view('validation.store.store_ABF');
    }

    public function IQF()
    {
        return view('validation.slaughterhouse.IQF');
    }

    public function IQF_addData()
    {
        return view('validation.store.store_IQF');
    }

    // further
    public function fryer1()
    {
        return view('validation.further.fryer1');
    }

    public function fryer1_addData()
    {
        return view('validation.store.store_fryer1');
    }


    public function fryer2()
    {
        return view('validation.further.fryer2');
    }

    public function fryer2_addData()
    {
        return view('validation.store.store_fryer2');
    }

    public function fryerMarel()
    {
        return view('validation.further.fryerMarel');
    }

    public function fryerMarel_addData()
    {
        return view('validation.store.store_fryerMarel');
    }

    public function hiCook()
    {
        return view('validation.further.hicook');
    }

    public function hiCook_addData()
    {
        return view('validation.store.store_hiCook');
    }

    // sausage
    public function smokeHouse()
    {
        return view('validation.sausage.smokehouse');
    }

    public function smokeHouse_addData()
    {
        return view('validation.store.store_smokeHouse');
    }

    // breadcrumb
    public function aging()
    {
        return view('validation.breadcrumb.aging');
    }

    public function aging_addData()
    {
        return view('validation.store.store_aging');
    }
}