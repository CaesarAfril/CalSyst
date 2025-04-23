<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use Illuminate\Http\Request;

class TelatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $today = now();

        $query = Assets::with(['department', 'plant', 'category'])
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<=', $today);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('series_number', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category', 'like', "%{$search}%");
                })
                ->orWhereHas('department', function ($q) use ($search) {
                    $q->where('department', 'like', "%{$search}%");
                })
                ->orWhereHas('plant', function ($q) use ($search) {
                    $q->where('plant', 'like', "%{$search}%");
                });
        }

        $expiredAssets = $query->paginate(10);
        $totalAssets = Assets::count();
        $expiredCount = $query->count();

        return view('calibration.telatKalibrasi', [
            'totalAssets' => $totalAssets,
            'expiredCount' => $expiredCount,
            'expiredAssets' => $expiredAssets,
            'search' => $search,
        ]);
    }
}