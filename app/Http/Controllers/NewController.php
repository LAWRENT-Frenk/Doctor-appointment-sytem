<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Spatie\Permission\Models\Role;

class NewController extends Controller
{
    // Other methods...

    public function create()
    {
        // Fetch available roles, filter to show only 'doctor' role
        $roles = Role::where('name', 'doctor')->get();
        return view('doctors.create', compact('roles'));
    }

    public function store(Request $request)
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
            'role' => 'required|exists:roles,id',  // Ensure the selected role exists
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
        $doctor = Doctor::create([
            'name' => $request->input('name'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'specialty' => $request->input('specialty'),
            'qualification' => $request->input('qualification'),
            'status' => $request->input('status'),
            'avatar' => $avatarPath,
        ]);

        // Assign role to the doctor
        $doctor->assignRole($request->input('role'));

        // Redirect back to the index page with success message
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    // Other methods...
}
