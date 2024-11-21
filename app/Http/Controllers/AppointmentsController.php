<?php
namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\DoctorNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientNotificationMail;
use App\Jobs\SendAppointmentReminderMail;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Validator;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{

    public function index1(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search');

        // Check if the user is a super_admin
        if ($user->hasRole('super_admin')) {
            // Super admin can see all appointments
            $appointments = Appointment::query();
        } elseif ($user->hasRole('doctor')) {
            // Doctor can see only their own appointments
            $appointments = Appointment::where('doctor_id', $user->id);
        } elseif ($user->hasRole('patient')) {
            // Patient can see only their own appointments
            $appointments = Appointment::where('patient_id', $user->id);
        } else {
            // Handle other roles if necessary
            $appointments = Appointment::query(); // Default case
        }

        // Apply search if needed
        if ($search) {
            $appointments = $appointments->where(function ($query) use ($search) {
                $query->where('custom_id', 'LIKE', "%{$search}%")
                    ->orWhere('reason', 'LIKE', "%{$search}%")
                    ->orWhereHas('patient', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('doctor', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Get paginated result
        $appointments = $appointments->orderBy('date', 'desc')->paginate(11);

        return view('appointments.index', compact('appointments'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'reason' => 'required|string',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
            ]);

            // Check for existing appointments
            $existingAppointment = Appointment::where('doctor_id', $request->input('doctor_id'))
                                              ->where('date', $request->input('date'))
                                              ->where('time', $request->input('time'))
                                              ->first();

            if ($existingAppointment) {
                return response()->json(['success' => false, 'message' => 'Doctor is busy at this time. Please schedule another time.']);
            }

            $appointment = Appointment::create($validated);

            // Send email notifications
            $doctor = Doctor::find($request->input('doctor_id'));
            $patient = Patient::find($request->input('patient_id'));

            // Send to doctor
            Mail::to($doctor->email)->send(new DoctorNotificationMail($appointment));

            // Send to patient
            Mail::to($patient->email)->send(new PatientNotificationMail($appointment));

            return response()->json(['success' => true, 'message' => 'Appointment scheduled successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to create appointment: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to schedule appointment.'], 500);
        }
    }
    public function index(Request $request)
    {
        $search = $request->query('search');
        $user = Auth::user();
    
        if (!$user) {
            abort(401, 'Unauthorized');
        }
    
        $appointments = Appointment::with('doctor', 'patient');
    
        if ($user->hasRole('super_admin')) {
            $appointments = $appointments;
        } elseif ($user->hasRole('doctor')) {
            $appointments = $appointments->where('doctor_id', $user->id);
        } elseif ($user->hasRole('patient')) {
            $appointments = $appointments->where('patient_id', $user->id);
        } else {
            abort(403, 'Unauthorized action.');
        }
    
        if ($search) {
            $appointments = $appointments->where(function ($query) use ($search) {
                $query->where('custom_id', 'LIKE', "%{$search}%")
                    ->orWhere('reason', 'LIKE', "%{$search}%")
                    ->orWhere('date', 'LIKE', "%{$search}%")
                    ->orWhere('time', 'LIKE', "%{$search}%")
                    ->orWhereHas('patient', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('doctor', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }
    
        $appointments = $appointments->orderBy('date', 'desc')->paginate(10);
    
        return view('appointments.index', compact('appointments'));
    }
    
    
    public function index_zaman(Request $request)
    {
        $search = $request->query('search');
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        $role = $user->role;

        $appointments = Appointment::with('doctor', 'patient')
            ->when($role !== 'super_admin', function ($query) use ($user, $role) {
                if ($role === 'doctor') {
                    return $query->where('doctor_id', $user->id);
                } elseif ($role === 'patient') {
                    return $query->where('patient_id', $user->id);
                }
            })
            ->when($search, function ($query, $search) {
                return $query->where('date', 'LIKE', "%{$search}%")
                             ->orWhere('time', 'LIKE', "%{$search}%")
                             ->orWhereHas('doctor', function ($query) use ($search) {
                                 $query->where('name', 'LIKE', "%{$search}%");
                             })
                             ->orWhereHas('patient', function ($query) use ($search) {
                                 $query->where('name', 'LIKE', "%{$search}%");
                             });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        if ($user->role === 'super_admin' || $user->id === $appointment->doctor_id || $user->id === $appointment->patient_id) {
            return view('appointments.show', compact('appointment'));
        }

        abort(403, 'Unauthorized action.');
    }

    public function create()
    {
        $user = Auth::user();
        $doctors = Doctor::all();
        
        // Adjust patients fetching logic based on user roles
        if ($user->hasRole('super_admin') || $user->hasRole('doctor')) {
            $patients = Patient::all();
        } elseif ($user->hasRole('patient')) {
            // Ensure patients can only see their own details
            $patients = Patient::where('user_id', $user->id)->get();
        } else {
            // Handle other roles or default case
            $patients = collect(); // Empty collection or handle as needed
        }

        return view('appointments.create', compact('patients', 'doctors'));
    }
    public function edit(Appointment $appointment)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        if ($user->role === 'super_admin' || $user->id === $appointment->doctor_id) {
            $doctors = Doctor::all();
            return view('appointments.edit', compact('appointment', 'doctors'));
        }

        abort(403, 'Unauthorized action.');
    }

    public function update(Request $request, Appointment $appointment)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'time' => 'required',
            'reason' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        if ($user->role === 'super_admin' || $user->id === $appointment->doctor_id) {
            try {
                $appointment->update($request->all());
                return response()->json(['success' => true, 'message' => 'Appointment updated successfully.'], 200);
            } catch (\Exception $e) {
                Log::error('Failed to update appointment: '.$e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to update appointment.'], 500);
            }
        }

        abort(403, 'Unauthorized action.');
    }

    public function destroy(Appointment $appointment)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        if ($user->role === 'super_admin' || $user->id === $appointment->doctor_id) {
            if ($appointment->delete()) {
                return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to delete appointment']);
            }
        }

        abort(403, 'Unauthorized action.');
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        $patient = Patient::find($appointment->patient_id);
        Mail::to($patient->email)->send(new AppointmentConfirmationMail($appointment));

        $reminderTime = Carbon::parse($appointment->date . ' ' . $appointment->time)->subHour();
        SendAppointmentReminderMail::dispatch($appointment)->delay($reminderTime);

        return response()->json(['success' => true, 'message' => 'Appointment confirmed successfully.']);
    }

    public function confirm111(Request $request, Appointment $appointment)
    {
        // Ensure the user is authorized to confirm the appointment
        // (This might involve additional logic to check permissions)

        // Update the appointment status
        $appointment->status = 'confirmed';
        $appointment->save();

        // Return a JSON response
        return response()->json(['success' => true]);
    }
}
