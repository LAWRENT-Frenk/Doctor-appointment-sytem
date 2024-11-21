<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->view('emails.doctor_notification')
                    ->with([
                        'appointmentDate' => $this->appointment->date,
                        'appointmentTime' => $this->appointment->time,
                        'patientName' => $this->appointment->patient->name,
                    ]);
    }
}
