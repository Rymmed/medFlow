<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRescheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $appointment;
    protected $oldDate;

    /**
     * Create a new message instance.
     *
     * @param $appointment
     */
    public function __construct($appointment, $newDate)
    {
        $this->appointment = $appointment;
        $this->oldDate = $newDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Demande de report du rendez-vous')
            ->markdown('emails.appointment_rescheduled')
            ->with([
                'appointment' => $this->appointment,
                'oldDate' => $this->oldDate
            ]);
    }
}
