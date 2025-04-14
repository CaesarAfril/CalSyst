<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Assets::count();
        $assets = Assets::with([
            'department',
            'plant',
            'category',
            'latest_external_calibration',
            'latest_temp_calibration',
            'latest_display_calibration'
        ])->get();

        $expiringAssets = $assets->filter(function ($asset) {
            $nowPlus6Months = now()->addMonths(6);

            $external = $asset->latest_external_calibration;
            $temp = $asset->latest_temp_calibration;
            $display = $asset->latest_display_calibration;

            $externalExpiring = $external && $external->expired_date &&
                Carbon::parse($external->expired_date)->lessThanOrEqualTo($nowPlus6Months);

            $tempExpiring = $temp && $temp->expired_date &&
                Carbon::parse($temp->expired_date)->lessThanOrEqualTo($nowPlus6Months);

            $displayExpiring = $display && $display->expired_date &&
                Carbon::parse($display->expired_date)->lessThanOrEqualTo($nowPlus6Months);

            return $externalExpiring || $tempExpiring || $displayExpiring;
        });

        return view('dashboard.dashboard', [
            'assets' => $expiringAssets,
            'totalAssets' => $totalAssets,
        ]);

    }
}