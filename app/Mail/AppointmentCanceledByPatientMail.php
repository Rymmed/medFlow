<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class AppointmentCanceledByPatientMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $appointment;

    /**
     * Create a new message instance.
     *
     * @param $appointment
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (Auth::id() == $this->appointment->patient_id) {
            $emailView =  'emails.appointment_canceled_by_patient';
        }
        else {
            $emailView =  'emails.appointment_canceled_by_doctor';
        }

        return $this->subject('Annulation du rendez-vous')
            ->markdown($emailView)
            ->with([
                'appointment' => $this->appointment,
            ]);
    }
}
