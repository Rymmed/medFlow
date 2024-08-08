<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Events\ConsultationStarted;

class ConsultationNotification extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // You can add 'database' if you want to save the notification in the database
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $joinUrl = route('consultation.room', ['appointment_id' => $this->appointment->id]);

        return (new MailMessage)
            ->subject('Consultation en ligne démarrée')
            ->line('Le docteur a démarré la consultation.')
            ->action('Rejoindre la consultation', $joinUrl)
            ->line('Merci de nous faire confiance pour votre santé!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Le docteur a démarré la consultation.',
        ];
    }
}
