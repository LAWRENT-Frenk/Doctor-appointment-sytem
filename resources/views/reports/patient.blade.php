@extends('layouts.app')

@section('main')
<!-- Start Page Title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Patient Report</li>
                </ol>
            </div>
            <h4 class="page-title">Patient Report</h4>
        </div>
    </div>
</div>
<!-- End Page Title -->

<!-- Start Widgets -->
<div class="row mb-4">
    <!-- Total Patients Widget -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h4 class="card-title mb-4">Total Patients</h4>
                <h2 class="card-text">{{ $totalPatients }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Appointments Widget -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <h4 class="card-title mb-4">Total Appointments</h4>
                <h2 class="card-text">{{ $totalAppointments }}</h2>
            </div>
        </div>
    </div>
    
    <!-- Total Amount Earned Widget -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h4 class="card-title mb-4">Total Amount Earned</h4>
                <h2 class="card-text">${{ number_format($totalAmount, 2) }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Spent by Patients Widget -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h4 class="card-title mb-4">Total Spent by Patients</h4>
                <h2 class="card-text">${{ number_format($totalSpentByPatients, 2) }}</h2>
            </div>
        </div>
    </div>
</div>
<!-- End Widgets -->

<!-- Filter Card -->
<div class="row justify-content-center mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="header-title mb-0">Filter by Status</h4>
                    <form id="status-filter-form" class="d-flex">
                        <select id="status-filter" class="form-control custom-select" name="status" onchange="document.getElementById('status-filter-form').submit();">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Filter Card -->

<!-- Patient Cards -->
<div class="row">
    @foreach($patients as $patient)
    <div class="col-md-6 col-lg-4">
        <div class="card text-center mb-4">
            <div class="card-body">
                <div class="avatar-lg mx-auto mb-3">
                    <img src="{{ $patient->avatar ? asset('storage/' . $patient->avatar) : 'https://via.placeholder.com/100' }}" alt="{{ $patient->name }}" class="rounded-circle img-thumbnail">
                </div>
                <h4 class="card-title">{{ $patient->name }}</h4>
                <p class="text-muted mb-2">{{ ucfirst($patient->contact_person) }}</p>
                <span class="badge badge-primary">Appointments: {{ $patient->appointments_count }}</span>
                <span class="badge badge-success">Pharmacy Involvement: {{ $patient->pharmacy_involvement_count }}</span>
                <p class="text-muted mb-0">{{ $patient->email }}</p>
                <p class="text-muted mb-0">{{ $patient->contact }}</p>
                <p class="text-muted mb-0">{{ $patient->address }}</p>
                <span class="badge badge-info">Total Pharmacy Amount: ${{ number_format($patient->pharmacies_sum_amount, 2) }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- End Patient Cards -->


@endsection
