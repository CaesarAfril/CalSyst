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
        $now = now();
        $threeMonthsLater = $now->copy()->addMonths(3);
        
        $onTrackAsset = $onTrackAsset->filter(function ($item) use ($now, $threeMonthsLater) {
            $expired = $item->asset->expired_date;
            if (!$expired)
                return false;

            $expiredDate = Carbon::parse($expired);
            if (!$expiredDate->between($now, $threeMonthsLater))
                return false;

            $progress = $item->asset->latest_external_calibration->progress_status ?? null;
            $status = $item->asset->latest_external_calibration->status ?? null;

            if ($progress === 'Sertifikat' && is_null($status)) {
                return false;
            }
            return true;
        });

        // on track status message
        $onTrackAsset->map(function ($item) use ($progressTimeline) {
            $asset = $item->asset;

            $progress = $asset->latest_external_calibration->progress_status ?? null;

            $startDate = Carbon::parse($asset->expired_date ?? $item->created_at);
            $now = now();

            if ($progress && isset($progressTimeline[$progress])) {
                $progressKeys = array_keys($progressTimeline);
                $currentIndex = array_search($progress, $progressKeys);

                if ($currentIndex !== false) {
                    $remainingStages = array_slice($progressTimeline, $currentIndex + 1);
                    $totalRemainingDays = array_sum($remainingStages);
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

        // on track count
        $onTrackCount = $onTrackAsset->filter(function ($item) use ($progressStages) {
            $progress = $item->asset->latest_external_calibration->progress_status ?? null;
            return in_array($progress, $progressStages);
        })->count();

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
        $year = now()->year;
        $calibratedAssets = $assets->filter(function ($asset) {
            $now = now();
            $expired = $asset->expired_date;

            $latestCalibration = collect([
                optional($asset->latest_external_calibration)->certificate_date,
                optional($asset->latest_temp_calibration)->date,
                optional($asset->latest_display_calibration)->date,
                optional($asset->latest_scale_calibration)->date,
            ])->filter()->sortDesc()->first(); // ambil yang terbaru

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

    public function toggleTableVisibility($table)
    {
        $visible = session($table, false);
        session([$table => !$visible]);

        return redirect()->back();
    }
}