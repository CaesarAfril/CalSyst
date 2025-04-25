<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Mail\AssetReminderEmail;
use App\Models\External_calibration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // $onTrackAsset->map(function ($item) use ($progressTimeline) {
        //     $asset = $item->asset;
        //     $progress = $asset->latest_external_calibration->progress_status ?? null;

        //     $startDate = Carbon::parse($asset->expired_date ?? $item->created_at);
        //     $now = now();

        //     if ($progress && isset($progressTimeline[$progress])) {
        //         // Dapatkan semua kunci
        //         $progressKeys = array_keys($progressTimeline);
        //         $currentIndex = array_search($progress, $progressKeys);

        //         if ($currentIndex !== false) {
        //             // Hitung jumlah hari dari tahap-tahap setelah progress saat ini
        //             $remainingStages = array_slice($progressTimeline, $currentIndex + 1);
        //             $totalRemainingDays = array_sum($remainingStages);

        //             // Ubah startDate ke awal (dengan mundur dari expired)
        //             $startDate = $startDate->subDays($totalRemainingDays);
        //         }
        //     }

        //     $daysPassed = (int) $startDate->diffInDays($now, false);

        //     // Hitung total ideal waktu sampai progress saat ini
        //     $expectedDays = 0;
        //     foreach ($progressTimeline as $key => $days) {
        //         $expectedDays += $days;
        //         if ($key == $progress)
        //             break;
        //     }

        //     if ($progress) {
        //         if ($daysPassed > $expectedDays) {
        //             $delay = $daysPassed - $expectedDays;

        //             // Cari tahap seharusnya sekarang
        //             $total = 0;
        //             $shouldBeStage = null;
        //             foreach ($progressTimeline as $key => $val) {
        //                 $total += $val;
        //                 if ($daysPassed <= $total) {
        //                     $shouldBeStage = $key;
        //                     break;
        //                 }
        //             }

        //             $item->status_message = "Telat proses <span class='text-danger font-semibold'>{$delay} hari</span>, seharusnya sudah sampai tahap <span class='text-danger font-semibold'>" . ($shouldBeStage ?? 'Selesai') . "</span>";
        //         } else {
        //             $item->status_message = 'Sesuai Jadwal';
        //         }
        //     } else {
        //         $item->status_message = '-';
        //     }

        //     return $item;
        // });

        // total alat on track kalibrasi
        // $onTrackCount = $onTrackAsset->filter(function ($item) use ($progressStages) {
        //     $progress = $item->asset->latest_external_calibration->progress_status ?? null;
        //     return in_array($progress, $progressStages);
        // })->count();

        $now = now();
        $threeMonthsLater = $now->copy()->addMonths(3);
        $onTrackAsset = $onTrackAsset->filter(function ($item) use ($now, $threeMonthsLater) {
            $expired = $item->asset->expired_date;
            if (!$expired)
                return false;

            $expiredDate = Carbon::parse($expired);
            if (!$expiredDate->between($now, $threeMonthsLater))
                return false;

            // Ambil progress dan status dari latest_external_calibration
            $progress = $item->asset->latest_external_calibration->progress_status ?? null;
            $status = $item->asset->latest_external_calibration->status ?? null;

            // Jangan tampilkan jika progress "sertifikat" tapi status null
            if ($progress === 'Sertifikat' && is_null($status)) {
                return false;
            }
            return true;
        });

        // on track status message
        $onTrackAsset->map(function ($item) use ($progressTimeline) {
            $asset = $item->asset;

            // Ambil progress_status dari latest_external_calibration
            $progress = $asset->latest_external_calibration->progress_status ?? null;

            // Ambil expired_date dari asset
            $startDate = Carbon::parse($asset->expired_date ?? $item->created_at);
            $now = now();

            if ($progress && isset($progressTimeline[$progress])) {
                $progressKeys = array_keys($progressTimeline);
                $currentIndex = array_search($progress, $progressKeys);

                if ($currentIndex !== false) {
                    $remainingStages = array_slice($progressTimeline, $currentIndex + 1);
                    $totalRemainingDays = array_sum($remainingStages);

                    // Mundur dari expired_date untuk dapat tanggal awal proses
                    $startDate = $startDate->subDays($totalRemainingDays);
                }
            }

            $daysPassed = (int) $startDate->diffInDays($now, false);

            $expectedDays = 0;
            foreach ($progressTimeline as $key => $days) {
                $expectedDays += $days;
                if ($key == $progress)
                    break;
            }

            if ($progress) {
                if ($daysPassed > $expectedDays) {
                    $delay = $daysPassed - $expectedDays;

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

        $onTrackCount = $onTrackAsset->filter(function ($item) use ($progressStages) {
            $progress = $item->asset->latest_external_calibration->progress_status ?? null;
            return in_array($progress, $progressStages);
        })->count();

        // total alat mendekati ED kalibrasi
        // $expiringAssets = $assets->filter(function ($asset) {
        //     $now = now();
        //     $internalLimit = $now->copy()->addMonths(3); // untuk kalibrasi internal
        //     $externalLimit = $now->copy()->addMonths(6); // untuk kalibrasi eksternal

        //     $external = $asset->latest_external_calibration;
        //     $temp = $asset->latest_temp_calibration;
        //     $display = $asset->latest_display_calibration;
        //     $scale = $asset->latest_scale_calibration;

        //     $externalExpiring =
        //         Carbon::parse($asset->expired_date)->between($now, $externalLimit);

        //     $tempExpiring = $temp && $temp->expired_date &&
        //         Carbon::parse($temp->expired_date)->between($now, $internalLimit);

        //     $displayExpiring = $display && $display->expired_date &&
        //         Carbon::parse($display->expired_date)->between($now, $internalLimit);

        //     $scaleExpiring = $scale && $scale->expired_date &&
        //         Carbon::parse($scale->expired_date)->between($now, $internalLimit);

        //     return $externalExpiring || $tempExpiring || $displayExpiring || $scaleExpiring;
        // });
        // $approachingEDCount = $expiringAssets->count();
        // $expiringAssets = $assets->filter(function ($asset) {
        //     $now = now();

        //     if (!$asset->expired_date) {
        //         return false;
        //     }

        //     $expiredDate = Carbon::parse($asset->expired_date);
        //     $calibrationType = $asset->category->calibration ?? null;

        //     if ($calibrationType === 'Internal') {
        //         return $expiredDate->between($now, $now->copy()->addMonths(3));
        //     } elseif ($calibrationType === 'External') {
        //         return $expiredDate->between($now, $now->copy()->addMonths(6));
        //     }

        //     return false;
        // });

        // menampilkan 3-6 bulan untuk data mendekati ED
        $now = now();
        $threeMonthsLater = $now->copy()->addMonths(3);
        $sixMonthsLater = $now->copy()->addMonths(6);
        $sortColumn = request()->get('sort', 'category.calibration');
        $sortDirection = request()->get('direction', 'asc');

        $expiringAssets = Assets::with('category')
            ->join('category', 'category.uuid', '=', 'assets.category_uuid') // join dengan table category
            ->select('assets.*') // <-- PENTING: agar yang dikembalikan tetap instance model Assets
            ->whereNotNull('assets.expired_date')
            ->whereBetween('assets.expired_date', [$threeMonthsLater, $sixMonthsLater])
            ->orderBy('category.calibration', $sortDirection)
            ->paginate(10);
        $expiringCount = $expiringAssets->count();
        $approachingEDCount = $expiringAssets->total();

        // total alat sudah kalibrasi
        // $calibratedAssets = $assets->filter(function ($asset) use ($year) {
        //     $external = optional($asset->latest_external_calibration)->certificate_date;
        //     $temp = optional($asset->latest_temp_calibration)->date;
        //     $display = optional($asset->latest_display_calibration)->date;
        //     $scale = optional($asset->latest_scale_calibration)->date;

        //     return (
        //         ($external && Carbon::parse($external)->year == $year) ||
        //         ($temp && Carbon::parse($temp)->year == $year) ||
        //         ($display && Carbon::parse($display)->year == $year) ||
        //         ($scale && Carbon::parse($scale)->year == $year)
        //     );
        // });

        // total alat sudah kalibrasi
        $year = now()->year;
        $calibratedAssets = $assets->filter(function ($asset) {
            $now = now();
            $expired = $asset->expired_date;

            // Ambil tanggal kalibrasi terakhir dari semua jenis kalibrasi
            $latestCalibration = collect([
                optional($asset->latest_external_calibration)->certificate_date,
                optional($asset->latest_temp_calibration)->date,
                optional($asset->latest_display_calibration)->date,
                optional($asset->latest_scale_calibration)->date,
            ])->filter()->sortDesc()->first(); // ambil yang terbaru

            // Cek apakah expired masih masa depan dan ada kalibrasi terakhir
            return $expired && Carbon::parse($expired)->isFuture() && $latestCalibration;
        });
        $nextYear = now()->addYear()->year;
        $calibratedCount = 0;
        foreach ($assets as $asset) {
            $ed = Carbon::parse($asset->expired_date)->year;
            if ($nextYear == $ed) {
                $calibratedCount++;
            }
        }

        // show reminder
        $expiringAssets->map(function ($asset) {
            $asset->reminder_status = $this->getReminderStatus($asset->expired_date);
            return $asset;
        });
        $onTrackAsset->map(function ($item) {
            $asset = $item->asset;
            $asset->reminder_status = app(DashboardController::class)->getReminderStatus($asset->expired_date);
            return $item;
        });

        return view('dashboard.dashboard', [
            'onTrackAsset' => $onTrackAsset,
            'assets' => $expiringAssets,
            'totalAssets' => $totalAssets,
            'calibratedCount' => $calibratedCount,
            'onTrackCount' => $onTrackCount,
            'approachingEDCount' => $approachingEDCount,
        ]);
    }

    private function getReminderStatus($expiredDate, $reminderDays = 60)
    {
        if (!$expiredDate)
            return '-';

        $now = \Carbon\Carbon::today();
        $expired = \Carbon\Carbon::parse($expiredDate);
        $daysRemaining = $now->diffInDays($expired, false);

        if ($daysRemaining < 0) {
            return "❌ Expired " . abs($daysRemaining) . " hari lalu";
        } elseif ($daysRemaining <= $reminderDays) {
            return "⚠️ Expired dalam {$daysRemaining} hari";
        } else {
            return "{$daysRemaining} hari lagi";
        }
    }
}