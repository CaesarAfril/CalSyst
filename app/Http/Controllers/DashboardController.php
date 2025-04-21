<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\External_calibration;
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

        $onTrackAsset = External_calibration::with(['asset', 'latestCalibrationFile'])->get();

        // dd($assets);

        // expiring asset 3-6
        // $expiringAssets = $assets->filter(function ($asset) {
        //     $now = now();
        //     $nowPlus3Months = $now->copy()->addMonths(3);

        //     $external = $asset->latest_external_calibration;
        //     $temp = $asset->latest_temp_calibration;
        //     $display = $asset->latest_display_calibration;
        //     $scale = $asset->latest_scale_calibration;

        //     $externalExpiring = $external && $external->expired_date &&
        //         Carbon::parse($external->expired_date)->between($now, $nowPlus3Months);

        //     $tempExpiring = $temp && $temp->expired_date &&
        //         Carbon::parse($temp->expired_date)->between($now, $nowPlus3Months);

        //     $displayExpiring = $display && $display->expired_date &&
        //         Carbon::parse($display->expired_date)->between($now, $nowPlus3Months);

        //     $scaleExpiring = $scale && $scale->expired_date &&
        //         Carbon::parse($scale->expired_date)->between($now, $nowPlus3Months);

        //     return $externalExpiring || $tempExpiring || $displayExpiring || $scaleExpiring;
        // });


        $progressTimeline = [
            'Persiapan Pengajuan' => 0,
            'Penawaran' => 7,
            'PPBJ' => 14,
            'Negosiasi' => 30,
            'SPK' => 14,
            'Pelaksanaan' => 7,
            'BA' => 14,
            'Pembayaran' => 14,
            'Sertifikat' => 7,
        ];

        $progressStages = array_keys($progressTimeline);

        $onTrackAsset->map(function ($item) use ($progressTimeline) {
            $asset = $item->asset;
            $progress = $asset->latest_external_calibration->progress_status ?? null;

            $startDate = Carbon::parse($asset->expired_date ?? $item->created_at);
            $now = now();

            if ($progress && isset($progressTimeline[$progress])) {
                // Dapatkan semua kunci
                $progressKeys = array_keys($progressTimeline);
                $currentIndex = array_search($progress, $progressKeys);

                if ($currentIndex !== false) {
                    // Hitung jumlah hari dari tahap-tahap setelah progress saat ini
                    $remainingStages = array_slice($progressTimeline, $currentIndex + 1);
                    $totalRemainingDays = array_sum($remainingStages);

                    // Ubah startDate ke awal (dengan mundur dari expired)
                    $startDate = $startDate->subDays($totalRemainingDays);
                }
            }

            $daysPassed = (int) $startDate->diffInDays($now, false);

            // Hitung total ideal waktu sampai progress saat ini
            $expectedDays = 0;
            foreach ($progressTimeline as $key => $days) {
                $expectedDays += $days;
                if ($key == $progress)
                    break;
            }

            if ($progress) {
                if ($daysPassed > $expectedDays) {
                    $delay = $daysPassed - $expectedDays;

                    // Cari tahap seharusnya sekarang
                    $total = 0;
                    $shouldBeStage = null;
                    foreach ($progressTimeline as $key => $val) {
                        $total += $val;
                        if ($daysPassed <= $total) {
                            $shouldBeStage = $key;
                            break;
                        }
                    }

                    $item->status_message = "Telat proses <span class='text-danger font-semibold'>{$delay} hari</span>, seharusnya sudah sampai tahap <span class='text-danger font-semibold'>" . ($shouldBeStage ?? 'Selesai') . "</span>";
                } else {
                    $item->status_message = 'Sesuai Jadwal';
                }
            } else {
                $item->status_message = '-';
            }

            return $item;
        });

        // total alat on track kalibrasi
        $onTrackCount = $onTrackAsset->filter(function ($item) use ($progressStages) {
            $progress = $item->asset->latest_external_calibration->progress_status ?? null;
            return in_array($progress, $progressStages);
        })->count();

        $expiringAssets = $assets->filter(function ($asset) {
            $now = now();
            $internalLimit = $now->copy()->addMonths(3); // untuk kalibrasi internal
            $externalLimit = $now->copy()->addMonths(6); // untuk kalibrasi eksternal

            $external = $asset->latest_external_calibration;
            $temp = $asset->latest_temp_calibration;
            $display = $asset->latest_display_calibration;
            $scale = $asset->latest_scale_calibration;

            $externalExpiring =
                Carbon::parse($asset->expired_date)->between($now, $externalLimit);

            $tempExpiring = $temp && $temp->expired_date &&
                Carbon::parse($temp->expired_date)->between($now, $internalLimit);

            $displayExpiring = $display && $display->expired_date &&
                Carbon::parse($display->expired_date)->between($now, $internalLimit);

            $scaleExpiring = $scale && $scale->expired_date &&
                Carbon::parse($scale->expired_date)->between($now, $internalLimit);

            return $externalExpiring || $tempExpiring || $displayExpiring || $scaleExpiring;
        });
        $approachingEDCount = $expiringAssets->count();

        // total alat sudah kalibrasi
        $year = now()->year;
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

        return view('dashboard.dashboard', [
            'onTrackAsset' => $onTrackAsset,
            'assets' => $expiringAssets,
            'totalAssets' => $totalAssets,
            'calibratedCount' => $calibratedCount,
            'onTrackCount' => $onTrackCount,
            'approachingEDCount' => $approachingEDCount,
        ]);
    }
}