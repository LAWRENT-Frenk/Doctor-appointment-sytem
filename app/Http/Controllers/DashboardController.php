<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Fetch top scheduled doctors with appointment count
        $topScheduledDoctors = Doctor::withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();
    
        // Fetch latest appointments
        $recentAppointments = Appointment::with(['doctor', 'patient'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

                    // Calculate the total number of appointments
        $totalAppointments = Appointment::count();

           // Calculate the total number of doctors
           $totalDoctorsCount = Doctor::count();
           $totalPharmacyAmount = Pharmacy::sum('amount'); // Calculate the total number of patients
           $totalPatients = Patient::count();
           $appointments = Appointment::with(['doctor', 'patient'])->orderBy('created_at', 'desc')->limit(10)->get();
           $pharmacies = Pharmacy::all();
           $topPatients = Patient::withCount('appointments')
           ->orderByDesc('appointments_count')
           ->take(5)
           ->get();
           
           // Other data you want to pass to the view 

    
        // Other queries and data preparation
    
        // Pass the data to the view
        return view('dashboard', compact(
            'topScheduledDoctors',
            'recentAppointments',
            'totalAppointments',
            'totalDoctorsCount',
            'totalPharmacyAmount',
            'totalPatients',
            'appointments',
            'pharmacies',
            'topPatients',

            // Other variables
        ));
    }

    public function dashboard_olds()
    {  
        // Calculate total pharmacy amount
        $appointments = Appointment::with(['doctor', 'patient'])->orderBy('created_at', 'desc')->get();
        $totalPharmacyAmount = DB::table('pharmacies')->sum('amount');
    
        // Fetch latest appointments
        $latestAppointments = Appointment::orderBy('created_at', 'desc')->take(10)->get();
    
        // Counts
        $totalPharmacyCount = Pharmacy::count();
        $totalPatients = Patient::count();
        $totalDoctorsCount = Doctor::count();
        $totalAppointments = Appointment::count();
    
        // Fetch count of active doctors
        $activeDoctorsCount = Doctor::where('status', 'active')->count();
    
        // Fetch count of inactive doctors
        $inactiveDoctorsCount = Doctor::where('status', 'inactive')->count();
    
        // Fetch top scheduled doctors
        $topScheduledDoctors = Doctor::withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();

            $recentAppointments = Appointment::with(['doctor', 'patient'])
            ->orderBy('created_at', 'desc')
            ->take(10) // Fetch the latest 10 appointments
            ->get();

            $patients = Patient::with('pharmacyInvolvements')
            ->get()
            ->map(function ($patient) {
                return [
                    'name' => $patient->name,
                    'total_amount' => $patient->totalPharmacyAmount(),
                ];
            });

            $topPatients = Patient::withCount('appointments')
        ->get()
        ->map(function ($patient) {
            return [
                'id' => $patient->id,
                'name' => $patient->name,
                'appointments_count' => $patient->appointments_count,
                'total_pharmacy_amount' => $patient->totalPharmacyAmount(),
                'status' => $patient->status,
                'avatar' => $patient->avatar ? asset('storage/' . $patient->avatar) : 'https://via.placeholder.com/50',
            ];
        });

        $recentPharmacies = Pharmacy::with('patient', 'doctor')
        ->latest() // You might want to adjust the ordering based on your needs
        ->take(10) // Adjust the number of records to show
        ->get();

        $pharmacies = Pharmacy::with('patient') // Ensure the patient relationship is loaded
            ->orderBy('created_at', 'desc') // Order by creation date
            ->limit(10) // Adjust as needed
            ->get();

                     // Fetch the appointments data
    $appointments = Appointment::with(['doctor', 'patient'])->orderBy('created_at', 'desc')->limit(10)->get();  
        
        // Pass the data to the view
        return view('dashboard', compact(
            'activeDoctorsCount',
            'totalAppointments',
            'latestAppointments',
            'totalPatients',
            'totalPharmacyCount',
            'totalPharmacyAmount',
            'totalDoctorsCount',
            'inactiveDoctorsCount',
            'topScheduledDoctors',
            'recentAppointments',
            'appointments',
            'patients',
            'topPatients',
            'recentPharmacies',
            'pharmacies',
            'appointments'

        ));
    }
    public function dashboard_old()
    {  
        // Calculate total pharmacy amount
        $totalPharmacyAmount = DB::table('pharmacies')->sum('amount');
    
        // Fetch latest appointments
        $latestAppointments = Appointment::with(['doctor', 'patient'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    
        // Counts
        $totalPharmacyCount = Pharmacy::count();
        $totalPatients = Patient::count();
        $totalDoctorsCount = Doctor::count();
        $totalAppointments = Appointment::count();
    
        // Fetch count of active doctors
        $activeDoctorsCount = Doctor::where('status', 'active')->count();
    
        // Fetch count of inactive doctors
        $inactiveDoctorsCount = Doctor::where('status', 'inactive')->count();
    
        // Fetch top scheduled doctors
        $topScheduledDoctors = Doctor::withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();

        // Fetch recent appointments
        $recentAppointments = Appointment::with(['doctor', 'patient'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Fetch patients with their total pharmacy amount
        $patients = Patient::with('pharmacyInvolvements')
            ->get()
            ->map(function ($patient) {
                return [
                    'name' => $patient->name,
                    'total_amount' => $patient->totalPharmacyAmount(),
                ];
            });

        // Fetch top patients with their details
        $topPatients = Patient::withCount('appointments')
            ->get()
            ->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'appointments_count' => $patient->appointments_count,
                    'total_pharmacy_amount' => $patient->totalPharmacyAmount(),
                    'status' => $patient->status,
                    'avatar' => $patient->avatar ? asset('storage/' . $patient->avatar) : 'https://via.placeholder.com/50',
                ];
            });

        // Fetch recent pharmacies
        $recentPharmacies = Pharmacy::with('patient', 'doctor')
            ->latest()
            ->take(10)
            ->get();

        // Fetch all pharmacies
        $pharmacies = Pharmacy::with('patient')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

            $appointmentsCount = Appointment::where('doctor_id', auth()->id())->count();
    $patientsCount = Patient::whereHas('appointments', function($query) {
        $query->where('doctor_id', auth()->id());
    })->count();
    $monthlyAppointmentsCount = Appointment::where('doctor_id', auth()->id())
        ->whereMonth('date', now()->month)
        ->count();

             // Fetch the appointments data
    $appointments = Appointment::with(['doctor', 'patient'])->orderBy('created_at', 'desc')->limit(10)->get(); 
    
        
        // Pass the data to the view
        return view('dashboard', compact(
            'activeDoctorsCount',
            'totalAppointments',
            'latestAppointments',
            'totalPatients',
            'totalPharmacyCount',
            'totalPharmacyAmount',
            'totalDoctorsCount',
            'inactiveDoctorsCount',
            'topScheduledDoctors',
            'recentAppointments',
            'patients',
            'topPatients',
            'recentPharmacies',
            'pharmacies',
            'appointments',
        ));
    }

    // Other CRUD methods
    public function index_old()
    {
        return view('dashboard');
    }
    public function index()
    {
        $user = auth()->user();
    
        $data = [
            'totalAppointments' => Appointment::count(),
            'totalDoctorsCount' => Doctor::count(),
            'totalPharmacyAmount' => Pharmacy::sum('amount'),
            'totalPatients' => Patient::count(),
        ];
    
        if ($user->hasRole('super_admin')) {
            $data['topScheduledDoctors'] = Doctor::withCount('appointments')->orderBy('appointments_count', 'desc')->get();
            $data['appointments'] = Appointment::with('doctor', 'patient')->latest()->get();
            $data['pharmacies'] = Pharmacy::with('patient')->latest()->get();
        } elseif ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $data['topScheduledDoctors'] = Doctor::withCount('appointments')->orderBy('appointments_count', 'desc')->get();
            $data['appointments'] = Appointment::where('doctor_id', $doctor->id)->with('patient')->latest()->get();
            $data['pharmacies'] = Pharmacy::where('doctor_id', $doctor->id)->with('patient')->latest()->get();
        } elseif ($user->hasRole('patient')) {
            $patient = Patient::where('user_id', $user->id)->first();
            $data['appointments'] = Appointment::where('patient_id', $patient->id)->with('doctor')->latest()->get();
            $data['topDoctors'] = Doctor::withCount('appointments')->orderBy('appointments_count', 'desc')->limit(5)->get(); // Example
        }
    
        return view('dashboard', $data);
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
