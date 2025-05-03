<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EarlyWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $machineName;

    public function __construct($machineName)
    {
        $this->machineName = $machineName;
    }

    public function build()
    {
        return $this->subject('Early Warning 1: Machine Validation')
            ->view('emails.earlyWarning');
    }
}