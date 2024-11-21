<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pharmacy;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Ensure to import Carbon

class ReportController extends Controller
{
    /**
     * Show the appointment report.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function appointmentReport(Request $request)
    {
        $dateRange = $request->input('date_range', 'today');

        // Determine date range
        switch ($dateRange) {
            case 'weekly':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'monthly':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
        }

        // Fetch appointments within the specified date range
        $appointments = Appointment::whereBetween('created_at', [$startDate, $endDate])->get();

        // Fetch appointment status breakdown
        $statusCounts = [
            'confirmed' => Appointment::where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'pending' => Appointment::where('status', 'pending')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'canceled' => Appointment::where('status', 'canceled')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        // Fetch doctor utilization
        $doctorUtilization = Appointment::select('doctor_id', DB::raw('COUNT(*) as appointment_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('doctor_id')
            ->with('doctor') // Include doctor details
            ->get();

        return view('reports.appointment', compact('appointments', 'statusCounts', 'doctorUtilization', 'dateRange'));
    }

    /**
     * Show the pharmacy report.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function pharmacyReport(Request $request)
    {
        $dateRange = $request->input('date_range', 'today');

        // Set the date range filter based on the selected option
        switch ($dateRange) {
            case 'weekly':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'today':
            default:
                $startDate = Carbon::now()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                break;
        }

        // Fetch the pharmacy reports within the date range
        $pharmacyReports = Pharmacy::whereBetween('created_at', [$startDate, $endDate])
            ->with('doctor', 'patient')
            ->get();

        // Aggregate medicine summary
        $medicineSummary = Pharmacy::select('medicine', DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('medicine')
            ->get();

        // Aggregate doctor prescriptions
        $doctorPrescriptions = Pharmacy::select('doctor_id', DB::raw('COUNT(*) as prescription_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('doctor_id')
            ->with('doctor')
            ->get();

        // Aggregate summary data
        $totalMedicinesSold = Pharmacy::whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $totalAmount = Pharmacy::whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        return view('reports.pharmacy', [
            'dateRange' => $dateRange,
            'pharmacyReports' => $pharmacyReports,
            'medicineSummary' => $medicineSummary,
            'doctorPrescriptions' => $doctorPrescriptions,
            'totalMedicinesSold' => $totalMedicinesSold,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function doctorReport(Request $request)
{
    $specialty = $request->get('specialty', 'all');

    $query = Doctor::withCount('appointments');

    if ($specialty !== 'all') {
        $query->where('specialty', $specialty);
    }

    $doctors = $query->get();
    $specialties = Doctor::distinct()->pluck('specialty');

    return view('reports.doctor', [
        'doctors' => $doctors,
        'specialty' => $specialty,
        'specialties' => $specialties,
    ]);
}



// In App/Http/Controllers/ReportController.php

public function patientReport(Request $request)
{
    $status = $request->get('status', 'all');

    // Query to fetch patients with count of appointments and sum of pharmacy amounts
    $query = Patient::withCount('appointments')
                    ->withSum('pharmacies', 'amount');

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $patients = $query->get();

    // Calculate total number of patients, appointments, and amount earned from pharmacies
    $totalPatients = Patient::count();
    $totalAppointments = Appointment::count();
    $totalAmount = Pharmacy::sum('amount');
    
    // New total amount spent by patients
    $totalSpentByPatients = Pharmacy::groupBy('patient_id')
                                    ->selectRaw('patient_id, sum(amount) as total')
                                    ->pluck('total')
                                    ->sum();

    return view('reports.patient', [
        'patients' => $patients,
        'status' => $status,
        'totalPatients' => $totalPatients,
        'totalAppointments' => $totalAppointments,
        'totalAmount' => $totalAmount,
        'totalSpentByPatients' => $totalSpentByPatients, // Add this line
    ]);
}



}
