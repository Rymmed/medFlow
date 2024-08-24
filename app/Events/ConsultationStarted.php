<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsultationStarted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;
    public $joinUrl;

    public function __construct($appointment, $joinUrl)
    {
        $this->appointment = $appointment;
        $this->joinUrl = $joinUrl;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('patient.'.$this->appointment->patient_id);
    }

    public function broadcastAs()
    {
        return 'consultation-started';
    }
}
