<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\RecentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecentActivityController extends Controller
{
    /**
     * Display a listing of the appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentActivities = RecentActivity::orderBy('date', 'desc')->take(4)->get();

        return view('recent_activity.index', ['recentActivities' => $recentActivities]);
    }

    
}
