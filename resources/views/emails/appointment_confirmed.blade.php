<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Your Appointment is Confirmed</h1>
    <p>Dear {{ $appointment->name }},</p>
    <p>Your appointment with Dr. {{ $appointment->doctor->name }} has been confirmed.</p>
    <p><strong>Date:</strong> {{ $appointment->date }}</p>
    <p><strong>Time:</strong> {{ $appointment->time }}</p>
    <p>Thank you for choosing our service.</p>
</body>
</html>
