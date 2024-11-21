<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder</title>
</head>
<body>
    <h1>Appointment Reminder</h1>
    <p>Dear {{ $appointment->name }},</p>
    <p>This is a reminder for your appointment with Dr. {{ $appointment->doctor->name }}.</p>
    <p><strong>Date:</strong> {{ $appointment->date }}</p>
    <p><strong>Time:</strong> {{ $appointment->time }}</p>
    <p>Please be on time.</p>
</body>
</html>
