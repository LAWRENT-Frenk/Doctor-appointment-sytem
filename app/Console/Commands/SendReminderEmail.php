<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Command
{
    protected $signature = 'send:reminder-email {appointment}';
    protected $description = 'Send reminder email to patient one hour before appointment';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $appointment = json_decode($this->argument('appointment'));
        Mail::to($appointment->email)->send(new AppointmentReminder($appointment));
        $this->info('Reminder email sent to ' . $appointment->email);
    }
}
