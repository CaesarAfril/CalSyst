<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assets;
use App\Mail\AssetReminderEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAssetReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:asset-reminder';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat untuk asset yang mendekati tanggal expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $assets = Assets::all();

        foreach ($assets as $asset) {
            $daysRemaining = Carbon::today()->diffInDays(Carbon::parse($asset->expired_date), false);

            if ($daysRemaining >= 0 && $daysRemaining <= 60) {
                $asset->reminder_status = $this->getReminderStatus($asset->expired_date);
                Mail::to('example@gmail.com')->send(new AssetReminderEmail($asset));
            }
        }

        $this->info('Email pengingat asset berhasil dikirim.');
    }

    private function getReminderStatus($expiredDate, $reminderDays = 60)
    {
        if (!$expiredDate) return '-';

        $now = Carbon::today();
        $expired = Carbon::parse($expiredDate);
        $daysRemaining = $now->diffInDays($expired, false);

        if ($daysRemaining < 0) {
            return "❌ Expired " . abs($daysRemaining) . " hari lalu";
        } elseif ($daysRemaining <= $reminderDays) {
            return "⚠️ Expired dalam {$daysRemaining} hari";
        } else {
            return "✅ Aman ({$daysRemaining} hari lagi)";
        }
    }
}