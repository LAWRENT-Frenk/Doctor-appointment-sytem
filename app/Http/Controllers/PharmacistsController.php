<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Pharmacist; // Updated model name

class PharmacistsController extends Controller

{
    /**
     * Display a listing of the pharmacists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $pharmacists = Pharmacist::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('pharmacists.index', compact('pharmacists'));
    }
    /**
     * Show the form for creating a new pharmacist.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch available roles, filter to show only 'pharmacist' role
        $roles = Role::where('name', 'pharmacist')->get();
        return view('pharmacists.create', compact('roles'));
    }

    /**
     * Store a newly created pharmacist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'role' => 'required|string|exists:roles,name',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            // Create a new User record
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            // Assign roles to the new user
            $user->assignRole($request->input('role'));
            $user->assignRole('pharmacist');

            // Create a new Pharmacist record and associate it with the created user
            $pharmacist = Pharmacist::create([
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

            // Commit the transaction
            DB::commit();

            // Redirect back to the index page with success message
            return redirect()->route('pharmacists.index')->with('success', 'Pharmacist created successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Log the exception message
            Log::error('Exception occurred: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Failed to create pharmacist.']);
        }
    }

    /**
     * Show the form for editing the specified pharmacist.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function edit(Pharmacist $pharmacist)
    {
        return view('pharmacists.edit', compact('pharmacist'));
    }

    /**
     * Update the specified pharmacist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pharmacist $pharmacist)
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

        // Update the Pharmacist record
        $pharmacist->update($validatedData);

        // Redirect back to the index page with success message
        return redirect()->route('pharmacists.index')->with('success', 'Pharmacist updated successfully.');
    }

    /**
     * Remove the specified pharmacist from storage.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacist $pharmacist)
    {
        // Delete the pharmacist record
        $pharmacist->delete();

        // Redirect back to the index page with success message
        return redirect()->route('pharmacists.index')->with('success', 'Pharmacist deleted successfully.');
    }
}
