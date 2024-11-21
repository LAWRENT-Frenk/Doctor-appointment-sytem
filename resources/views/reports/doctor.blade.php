@extends('layouts.app')

@section('main')
<!-- Start Page Title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Doctor Report</li>
                </ol>
            </div>
            <h4 class="page-title">Doctor Report</h4>
        </div>
    </div>
</div>
<!-- End Page Title -->

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <!-- Filter Card -->
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="header-title mb-0">Filter by Specialty</h4>
                    <form id="specialty-filter-form" class="d-flex">
                        <select id="specialty-filter" class="form-control custom-select" name="specialty" onchange="document.getElementById('specialty-filter-form').submit();">
                            <option value="all" {{ $specialty === 'all' ? 'selected' : '' }}>All</option>
                            @foreach($specialties as $spec)
                                <option value="{{ $spec }}" {{ $specialty === $spec ? 'selected' : '' }}>{{ ucfirst($spec) }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Filter Card -->

<div class="row">
    @foreach($doctors as $doctor)
    <div class="col-md-6 col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="avatar-lg mx-auto mb-3">
                    <img src="{{ $doctor->avatar ? asset('storage/' . $doctor->avatar) : 'https://via.placeholder.com/100' }}" alt="{{ $doctor->name }}" class="rounded-circle img-thumbnail">
                </div>
                <h4 class="card-title">{{ $doctor->name }}</h4>
                <p class="text-muted mb-2">{{ ucfirst($doctor->specialty) }}</p>
                <span class="badge badge-primary">Appointments: {{ $doctor->appointments_count }}</span>
                <p class="text-muted mb-0">{{ $doctor->email }}</p>
                <p class="text-muted mb-0">{{ $doctor->contact }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

