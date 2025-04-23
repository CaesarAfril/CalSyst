<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TelatController extends Controller
{
    public function index()
    {
        $totalAssets = Assets::count();

        // Ambil semua asset yang expired (expired_date sudah lewat)
        $today = now();
        $expiredAssets = Assets::with(['department', 'plant', 'category'])
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<=', $today)
            ->get();

        $expiredCount = $expiredAssets->count();

        return view('calibration.telatKalibrasi', [
            'totalAssets' => $totalAssets,
            'expiredCount' => $expiredCount,
            'expiredAssets' => $expiredAssets,
        ]);
    }
}