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
            'latest_display_calibration',
            'latest_scale_calibration',
        ])->get();

        // expiring asset
        // $expiringAssets = $assets->filter(function ($asset) {
        //     $nowPlus3Months = now()->addMonths(3);

        //     $external = $asset->latest_external_calibration;
        //     $temp = $asset->latest_temp_calibration;
        //     $display = $asset->latest_display_calibration;
        //     $scale = $asset->latest_scale_calibration;

        //     $externalExpiring = $external && $external->expired_date &&
        //         Carbon::parse($external->expired_date)->lessThanOrEqualTo($nowPlus3Months);

        //     $tempExpiring = $temp && $temp->expired_date &&
        //         Carbon::parse($temp->expired_date)->lessThanOrEqualTo($nowPlus3Months);

        //     $displayExpiring = $display && $display->expired_date &&
        //         Carbon::parse($display->expired_date)->lessThanOrEqualTo($nowPlus3Months);

        //     $scaleExpiring = $scale && $scale->expired_date &&
        //         Carbon::parse($scale->expired_date)->lessThanOrEqualTo($nowPlus3Months);

        //     return $externalExpiring || $tempExpiring || $displayExpiring || $scaleExpiring;
        // });

        // expiring asset 3-6
        $expiringAssets = $assets->filter(function ($asset) {
            $now = now();
            $nowPlus3Months = $now->copy()->addMonths(3);

            $external = $asset->latest_external_calibration;
            $temp = $asset->latest_temp_calibration;
            $display = $asset->latest_display_calibration;
            $scale = $asset->latest_scale_calibration;

            $externalExpiring = $external && $external->expired_date &&
                Carbon::parse($external->expired_date)->between($now, $nowPlus3Months);

            $tempExpiring = $temp && $temp->expired_date &&
                Carbon::parse($temp->expired_date)->between($now, $nowPlus3Months);

            $displayExpiring = $display && $display->expired_date &&
                Carbon::parse($display->expired_date)->between($now, $nowPlus3Months);

            $scaleExpiring = $scale && $scale->expired_date &&
                Carbon::parse($scale->expired_date)->between($now, $nowPlus3Months);

            return $externalExpiring || $tempExpiring || $displayExpiring || $scaleExpiring;
        });

        $year = now()->year;

        // total alat sudah kalibrasi
        $calibratedAssets = $assets->filter(function ($asset) use ($year) {
            $external = optional($asset->latest_external_calibration)->certificate_date;
            $temp = optional($asset->latest_temp_calibration)->date;
            $display = optional($asset->latest_display_calibration)->date;
            $scale = optional($asset->latest_scale_calibration)->date;

            return (
                ($external && Carbon::parse($external)->year == $year) ||
                ($temp && Carbon::parse($temp)->year == $year) ||
                ($display && Carbon::parse($display)->year == $year) ||
                ($scale && Carbon::parse($scale)->year == $year)
            );
        });
        $calibratedCount = $calibratedAssets->count();

        // total alat telat kalibrasi
        $expiredCount = $assets->filter(function ($asset) {
            $today = now();

            $external = $asset->latest_external_calibration;
            $temp = $asset->latest_temp_calibration;
            $display = $asset->latest_display_calibration;
            $scale = $asset->latest_scale_calibration;

            $externalExpired = $external && $external->expired_date &&
                Carbon::parse($external->expired_date)->lessThanOrEqualTo($today);

            $tempExpired = $temp && $temp->expired_date &&
                Carbon::parse($temp->expired_date)->lessThanOrEqualTo($today);

            $displayExpired = $display && $display->expired_date &&
                Carbon::parse($display->expired_date)->lessThanOrEqualTo($today);

            $scaleExpired = $scale && $scale->expired_date &&
                Carbon::parse($scale->expired_date)->lessThanOrEqualTo($today);

            return $externalExpired || $tempExpired || $displayExpired || $scaleExpired;
        })->count();


        return view('dashboard.dashboard', [
            'assets' => $expiringAssets,
            'totalAssets' => $totalAssets,
            'calibratedCount' => $calibratedCount,
            'expiredCount' => $expiredCount,
        ]);
    }
}