<?php

namespace App\Console\Commands;

use App\Enums\AppointmentStatus;
use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class DeleteOldAppointments extends Command
{
    protected $signature = 'appointments:delete-old';
    protected $description = 'Delete appointments with status Annulé or Refusé after 1 month from start_date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        Appointment::whereIn('status', [AppointmentStatus::CANCELLED, AppointmentStatus::REFUSED])
            ->where('start_date', '<=', $oneMonthAgo)
            ->delete();

        $this->info('Old appointments deleted successfully.');
    }
}

