<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultationStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $appointment;
    protected $joinUrl;

    /**
     * Create a new message instance.
     *
     * @param $appointment
     * @param $joinUrl
     */
    public function __construct($appointment, $joinUrl)
    {
        $this->appointment = $appointment;
        $this->joinUrl = $joinUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Consultation en ligne démarrée')
            ->markdown('emails.consultation_started')
            ->with([
                'appointment' => $this->appointment,
                'joinUrl' => $this->joinUrl,
            ]);
    }
}
