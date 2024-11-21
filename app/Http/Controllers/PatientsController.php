<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search');

        // Check if the user is a super_admin
        if ($user->hasRole('super_admin')) {
            // Super admin can see all patients
            $patients = Patient::query();
        } elseif($user->hasRole('doctor')) {
            // Non-super admin can see only their related patients
            $patients = Patient::query();
        }
        else{
            $patients = Patient::where('user_id', $user->id);
        
        }

        // Apply search if needed
        if ($search) {
            $patients = $patients->where(function($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('contact', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhere('contact_person', 'LIKE', "%{$search}%");
            });
        }

        // Get paginated result
        $patients = $patients->orderBy('created_at', 'desc')->paginate(11);

        return view('patients.index', compact('patients'));
    }


    public function create()
    {
        $user = Auth::user();

        // Fetch all doctors
        $doctors = Doctor::all();

        if ($user->hasRole('super_admin') || $user->hasRole('doctor')) {
            // Super admin and doctor can see all patients
            $patients = Patient::all();
        } elseif ($user->hasRole('patient')) {
            // Patient can see only their own information
            $patients = Patient::where('id', $user->id)->get();
        } else {
            // Handle other roles or default case if needed
            $patients = collect(); // Empty collection or handle as needed
        }

        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function create_old()
    {
        // Fetch available roles, filter to show only 'patient' role
        $roles = Role::where('name', 'patient')->get();
        return view('patients.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'address' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role' => 'required|string|exists:roles,name',  // Ensure the selected role exists
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Validate password
        ]);
    
        // Handle file upload if present
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            try {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['avatar' => 'Failed to upload image.']);
            }
        }
    
        // Begin a transaction
        DB::beginTransaction();
    
        try {
            // Create a new User record for the patient
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
    
            // Assign the selected role to the new user
            $user->assignRole($request->input('role'));
            $user->assignRole('patient');
    
            // Create a new Patient record and associate it with the created user
            $patient = Patient::create([
                'name' => $request->input('name'),
                'contact' => $request->input('contact'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'contact_person' => $request->input('contact_person'),
                'status' => $request->input('status'),
                'avatar' => $avatarPath,
                'user_id' => $user->id, // Associate the patient with the created user
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Redirect back to the index page with success message
            return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
    
            // Log the exception message
            Log::error('Exception occurred: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Failed to create patient.']);
        }
    }
    

    public function store_old(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'address' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role' => 'required|string|exists:roles,name',  // Ensure the selected role exists
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Validate password
        ]);

        // Handle file upload if present
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = null;
        }

        // Create a new User record for the patient
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Assign the selected role to the new user
        $user->assignRole($request->input('role'));
        $user->assignRole('patient');

        // Create a new Patient record and associate it with the created user
        $patient = new Patient([
            'name' => $request->input('name'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'contact_person' => $request->input('contact_person'),
            'status' => $request->input('status'),
            'avatar' => $avatarPath,
            'user_id' => $user->id, // Associate the patient with the created user
        ]);
        $patient->save();

        // Redirect back to the index page with success message
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle file upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $patient->avatar = $avatarPath;
        }

        // Update the Patient record
        $patient->update($request->only(['name', 'contact', 'email', 'address', 'contact_person', 'status']));

        // Redirect back to the index page with success message
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy_old(Patient $patient)
    {
        // Delete the Patient record
        $patient->delete();

        // Redirect back to the index page with success message
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function destroy(Patient $patient)
{
    // Update related appointments to set patient_id to NULL
    $patient->appointments()->update(['patient_id' => null]);

    // Delete the Patient record
    $patient->delete();

    // Redirect back to the index page with success message
    return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
}

}
