<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\External_calibration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TelatController extends Controller
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

        $expiredCount = 0;
        $expiredAssets = collect(); // Create an empty collection to store expired assets

        $today = now(); // Get the current date once, for both operations

        foreach ($assets as $asset) {

            $external = $asset->latest_external_calibration;
            $temp = $asset->latest_temp_calibration;
            $display = $asset->latest_display_calibration;
            $scale = $asset->latest_scale_calibration;

            // Check if any calibration is expired
            $externalExpired = $external && $external->expired_date &&
                Carbon::parse($external->expired_date)->lessThanOrEqualTo($today);

            $tempExpired = $temp && $temp->expired_date &&
                Carbon::parse($temp->expired_date)->lessThanOrEqualTo($today);

            $displayExpired = $display && $display->expired_date &&
                Carbon::parse($display->expired_date)->lessThanOrEqualTo($today);

            $scaleExpired = $scale && $scale->expired_date &&
                Carbon::parse($scale->expired_date)->lessThanOrEqualTo($today);

            // If any calibration has expired
            if ($externalExpired || $tempExpired || $displayExpired || $scaleExpired) {
                $expiredCount++; // Increment expired count
                $expiredAssets->push($asset); // Add the asset to expiredAssets collection
            }
        }

        // foreach ($assets as $asset) {
        //     // Ambil expired_date langsung dari Asset
        //     $expiredDate = $asset->expired_date;

        //     // Jika expired_date ada dan sudah lewat
        //     $expiredAsset = $expiredDate && Carbon::parse($expiredDate)->lessThanOrEqualTo($today);

        //     // Cek kalibrasi lainnya
        //     $external = $asset->latest_external_calibration;
        //     $temp = $asset->latest_temp_calibration;
        //     $display = $asset->latest_display_calibration;
        //     $scale = $asset->latest_scale_calibration;

        //     // Cek jika salah satu kalibrasi sudah expired
        //     $externalExpired = $external && $external->expired_date &&
        //         Carbon::parse($external->expired_date)->lessThanOrEqualTo($today);

        //     $tempExpired = $temp && $temp->expired_date &&
        //         Carbon::parse($temp->expired_date)->lessThanOrEqualTo($today);

        //     $displayExpired = $display && $display->expired_date &&
        //         Carbon::parse($display->expired_date)->lessThanOrEqualTo($today);

        //     $scaleExpired = $scale && $scale->expired_date &&
        //         Carbon::parse($scale->expired_date)->lessThanOrEqualTo($today);

        //     // Jika expired_date pada asset atau kalibrasi sudah expired
        //     if ($expiredAsset || $externalExpired || $tempExpired || $displayExpired || $scaleExpired) {
        //         $expiredCount++; // Increment expired count
        //         $expiredAssets->push($asset); // Add the asset to expiredAssets collection
        //     }
        // }

        return view('calibration.telatKalibrasi', [
            'totalAssets' => $totalAssets,
            'expiredCount' => $expiredCount,
            'expiredAssets' => $expiredAssets,
        ]);
    }
}