<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Doctor; // Make sure to replace 'Doctor' with your actual model name
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Doctors; // Updated to use Doctors model

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request)
     {
         $search = $request->query('search');
     
         $doctors = Doctor::query()
             ->when($search, function ($query, $search) {
                 return $query->where('id', 'LIKE', "%{$search}%")
                              ->orWhere('name', 'LIKE', "%{$search}%")
                              ->orWhere('contact', 'LIKE', "%{$search}%")
                              ->orWhere('email', 'LIKE', "%{$search}%")
                              ->orWhere('address', 'LIKE', "%{$search}%")
                              ->orWhere('specialty', 'LIKE', "%{$search}%")
                              ->orWhere('qualification', 'LIKE', "%{$search}%")
                              ->orWhere('status', 'LIKE', "%{$search}%");
             })
             ->orderBy('created_at', 'desc')
             ->paginate(11);
     
         return view('doctors.index', compact('doctors'));
     }
     



    /**
     * Show the form for creating a new doctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_old()
    {
        return view('doctors.create');
    }

    public function create()
    {
        // Fetch available roles, filter to show only 'doctor' role
        $roles = Role::where('name', 'doctor')->get();
        return view('doctors.create', compact('roles'));
    }

    /**
     * Store a newly created doctor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'contact' => 'required|string|max:255',
             'email' => 'required|email|max:255|unique:users,email',
             'address' => 'required|string|max:255',
             'specialty' => 'required|string|max:255',
             'qualification' => 'required|string|max:255',
             'status' => 'required|string|in:active,inactive',
             'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'role' => 'required|string|exists:roles,name',
             'password' => ['required', 'string', 'min:8', 'confirmed'],
         ]);

         $avatarPath = null;
         if ($request->hasFile('avatar')) {
             try {
                 $avatarPath = $request->file('avatar')->store('avatars', 'public');
             } catch (\Exception $e) {
                 return redirect()->back()->withErrors(['avatar' => 'Failed to upload image.']);
             }
         }

         DB::beginTransaction();

         try {
             $user = User::create([
                 'name' => $request->input('name'),
                 'email' => $request->input('email'),
                 'password' => Hash::make($request->input('password')),
             ]);

             $user->assignRole($request->input('role'));
             $user->assignRole('doctor');

             $doctor = Doctor::create([
                 'name' => $request->input('name'),
                 'contact' => $request->input('contact'),
                 'email' => $request->input('email'),
                 'address' => $request->input('address'),
                 'specialty' => $request->input('specialty'),
                 'qualification' => $request->input('qualification'),
                 'role' => $request->input('role'),
                 'status' => $request->input('status'),
                 'avatar' => $avatarPath,
                 'user_id' => $user->id,
             ]);

             DB::commit();

             return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');

         } catch (\Exception $e) {
             DB::rollBack();
             Log::error('Exception occurred: ' . $e->getMessage());
             return redirect()->back()->withErrors(['error' => 'Failed to create Doctor.']);
         }
     }
     public function store12(Request $request)
     {
         // Validate the request data
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'contact' => 'required|string|max:255',
             'email' => 'required|email|max:255',
             'address' => 'required|string|max:255',
             'specialty' => 'required|string|max:255',
             'qualification' => 'required|string|max:255',
             'status' => 'required|string|in:active,inactive',
             'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'role' => 'required|string|exists:roles,name',  // Ensure the selected role exists
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
     
         // Log the validated data and avatar path
         Log::info('Validated Data:', $validatedData);
         Log::info('Avatar Path:', ['avatarPath' => $avatarPath]);
     
         // Create a new Doctor record
         $doctor = Doctor::create([
             'name' => $request->input('name'),
             'contact' => $request->input('contact'),
             'email' => $request->input('email'),
             'address' => $request->input('address'),
             'specialty' => $request->input('specialty'),
             'qualification' => $request->input('qualification'),
             'role' => $request->input('role'),
             'status' => $request->input('status'),
             'avatar' => $avatarPath,
         ]);
     
         // Assign role to the doctor
         try {
             $doctor->assignRole($request->input('role'));
         } catch (\Exception $e) {
             Log::error('Failed to assign role:', ['error' => $e->getMessage()]);
             return redirect()->back()->withErrors(['role' => 'Failed to assign role: ' . $e->getMessage()]);
         }
     
         // Redirect back to the index page with success message
         return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
     }
     
     
    public function store_old(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:255',
        'specialty' => 'required|string|max:255',
        'qualification' => 'required|string|max:255',
        'status' => 'required|string|in:active,inactive',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

    // Create a new Doctor record
    Doctor::create([
        'name' => $request->input('name'),
        'contact' => $request->input('contact'),
        'email' => $request->input('email'),
        'address' => $request->input('address'),
        'specialty' => $request->input('specialty'),
        'qualification' => $request->input('qualification'),
        'status' => $request->input('status'),
        'avatar' => $avatarPath,
    ]);

    // Redirect back to the index page with success message
    return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
}



    

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }
    
    
    public function update(Request $request, Doctor $doctor)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'address' => 'required|string|max:255',
        'specialty' => 'required|string|max:255',
        'qualification' => 'required|string|max:255',
        'status' => 'required|string|in:active,inactive',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle file upload if present
    if ($request->hasFile('avatar')) {          
        try {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $avatarPath;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['avatar' => 'Failed to upload image.']);
        }
    }

    // Update the Doctor record
    $doctor->update($validatedData);

    // Redirect back to the index page with success message
    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
}

    

public function destroy(Doctor $doctor)
{
    // Remove all roles associated with the doctor
    $doctor->syncRoles([]);

    // Delete the doctor record
    $doctor->delete();

    // Redirect back to the index page with a success message
    return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
}

    
    public function destroy1(Doctor $doctor)
    {
        // Delete the doctor record
        $doctor->delete();

        // Redirect back to the index page with success message
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }

}
