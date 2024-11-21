@component('mail::message')
# Appointment Reminder

Dear {{ $appointment->name }},

This is a reminder for your appointment with Dr. {{ $appointment->doctor->name }} on {{ $appointment->date }} at {{ $appointment->time }}.

Please ensure to be on time.

@component('mail::button', ['url' => ''])
View Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
