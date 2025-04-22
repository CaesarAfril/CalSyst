<?php

namespace App\Mail;

use App\Models\Assets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class AssetReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $asset;

    public function __construct(Assets $asset)
    {
        $this->asset = $asset;
    }

    public function build()
    {
        return $this->subject('Asset Expiration Reminder')
            ->view('emails.assetReminder');
    }
}