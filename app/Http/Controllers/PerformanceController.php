<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;


class PerformanceController extends Controller
{
    public function getData()
    {
        // Fetch performance data from database using models
        $appointments = Appointment::pluck('count'); // Example query to get appointment counts
        $doctors = Doctor::pluck('count'); // Example query to get doctor counts
        $patients = Patient::pluck('count'); // Example query to get patient counts
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May']; // Example labels for x-axis

        return response()->json([
            'data' => [
                'appointments' => $appointments,
                'doctors' => $doctors,
                'patients' => $patients,
                'labels' => $labels,
            ]
        ]);
    }
}
