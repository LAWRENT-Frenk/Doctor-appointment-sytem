@component('mail::message')
# Appointment Confirmed

Dear {{ $appointment->name }},

Your appointment with Dr. {{ $appointment->doctor->name }} on {{ $appointment->date }} at {{ $appointment->time }} has been confirmed.

Thank you for choosing our service.

@component('mail::button', ['url' => ''])
View Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
