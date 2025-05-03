<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EarlyWarning2Mail extends Mailable
{
    use Queueable, SerializesModels;

    public $testAlat;
    public $testMesin;

    public function __construct($testAlat, $testMesin)
    {
        $this->testAlat = $testAlat;
        $this->testMesin = $testMesin;
    }

    public function build()
    {
        return $this->subject('Early Warning 2 Notification')
            ->view('emails.earlyWarning2');
    }
}