@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Appointment Report</li>
                </ol>
            </div>
            <h4 class="page-title">Appointment Report</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <!-- Filter Card -->
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="header-title mb-0">Filter by Date Range</h4>
                    <form id="date-range-form" class="d-flex">
                        <select id="date-range" class="form-control custom-select" name="date_range" onchange="document.getElementById('date-range-form').submit();">
                            <option value="today" {{ $dateRange === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="weekly" {{ $dateRange === 'weekly' ? 'selected' : '' }}>This Week</option>
                            <option value="monthly" {{ $dateRange === 'monthly' ? 'selected' : '' }}>This Month</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Appointment Report ({{ $dateRange }})</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Doctor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->patient->contact }}</td>
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->reason }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <!-- Appointment Status Breakdown -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Appointment Status Breakdown</h4>
                
                <div class="d-flex flex-column">
                    <div class="bg-light p-3 mb-2 rounded">
                        <h5 class="mb-1">Confirmed</h5>
                        <p class="mb-0 font-weight-bold">{{ $statusCounts['confirmed'] }}</p>
                    </div>
                    <div class="bg-light p-3 mb-2 rounded">
                        <h5 class="mb-1">Pending</h5>
                        <p class="mb-0 font-weight-bold">{{ $statusCounts['pending'] }}</p>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <h5 class="mb-1">Canceled</h5>
                        <p class="mb-0 font-weight-bold">{{ $statusCounts['canceled'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->

    <!-- Doctor Utilization -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Doctor Utilization</h4>
                
                <div class="d-flex flex-column">
                    @foreach($doctorUtilization as $doctor)
                        <div class="bg-light p-3 mb-2 rounded">
                            <h5 class="mb-1">{{ $doctor->doctor->name }}</h5>
                            <p class="mb-0 font-weight-bold">{{ $doctor->appointment_count }} appointments</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- end col -->

    <!-- Summary Card -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Appointment Summary</h4>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th>Description</th>
                            <th>Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Total Appointments</td>
                            <td>{{ $appointments->count() }}</td>
                        </tr>
                        <tr>
                            <td>Total Confirmed</td>
                            <td>{{ $statusCounts['confirmed'] }}</td>
                        </tr>
                        <tr>
                            <td>Total Pending</td>
                            <td>{{ $statusCounts['pending'] }}</td>
                        </tr>
                        <tr>
                            <td>Total Canceled</td>
                            <td>{{ $statusCounts['canceled'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection
