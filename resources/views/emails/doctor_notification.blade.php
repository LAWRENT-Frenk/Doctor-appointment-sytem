<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Notification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            animation: fadeIn 1s ease-in;
            text-align: left;
        }
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(to right, #28a745, #20c997);
            border-radius: 15px 15px 0 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745;
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            animation: slideIn 1s ease-out;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }
        .highlight {
            color: #28a745;
            font-weight: bold;
        }
        .info {
            display: flex;
            align-items: center;
            margin: 15px 0;
            padding: 15px;
            border-radius: 10px;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1), -2px -2px 6px rgba(255, 255, 255, 0.3);
            transition: background 0.3s, transform 0.3s;
        }
        .info:hover {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            transform: scale(1.02);
        }
        .info i {
            font-size: 22px;
            color: #28a745;
            margin-right: 15px;
            transition: color 0.3s;
        }
        .info:hover i {
            color: #20c997;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
            text-align: center;
            width: 100%;
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
        .button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            line-height: 1.4;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
            text-align: center;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideIn {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <h1><i class="fas fa-calendar-check"></i> New Appointment Scheduled</h1>
        <p>Dear Dr. <span class="highlight">{{ $appointment->doctor->name }}</span>,</p>

        <p>You have a new appointment scheduled:</p>

        <div class="info">
            <i class="fas fa-user"></i>
            <strong>Patient Name:</strong> {{ $appointment->patient->name }}
        </div>
        <div class="info">
            <i class="fas fa-phone"></i>
            <strong>Contact:</strong> {{ $appointment->patient->contact }}
        </div>
        <div class="info">
            <i class="fas fa-calendar-day"></i>
            <strong>Date:</strong> {{ $appointment->date }}
        </div>
        <div class="info">
            <i class="fas fa-clock"></i>
            <strong>Time:</strong> {{ $appointment->time }}
        </div>
        <div class="info">
            <i class="fas fa-notes-medical"></i>
            <strong>Reason:</strong> {{ $appointment->reason }}
        </div>

        
            If you have any questions, please contact us at support@onlinedoctorappointment.com<br>
            &copy; {{ date('Y') }} Online Doctor Appointment System
        </div>
    </div>

    <script>
        document.getElementById('confirmButton').addEventListener('click', function(event) {
            event.preventDefault();
            const appointmentId = this.getAttribute('data-appointment-id');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/appointments/${appointmentId}/confirm`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = 'Confirmed';
                    this.style.backgroundColor = '#28a745';
                    this.style.cursor = 'default';
                    this.style.pointerEvents = 'none';
                } else {
                    alert('Error confirming appointment: ' + data.message);
                }
            })
            .catch(error => {
                alert('An error occurred: ' + error.message);
            });
        });
    </script>
</body>
</html>
