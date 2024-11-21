@extends('layouts.app')

@section('main')
<!-- Start Page Title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pharmacy Report</li>
                </ol>
            </div>
            <h4 class="page-title">Pharmacy Report</h4>
        </div>
    </div>
</div>
<!-- End Page Title -->

<div class="row justify-content-center">
    <!-- Filter Card -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
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
<!-- End Row -->

<div class="row">
    <!-- Pharmacy Report -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Pharmacy Report ({{ ucfirst($dateRange) }})</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Medicine</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Doctor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pharmacyReports as $report)
                                <tr>
                                    <td>{{ $report->patient->name }}</td>
                                    <td>{{ $report->contact }}</td>
                                    <td>{{ $report->medicine }}</td>
                                    <td>{{ number_format($report->amount, 2) }}</td>
                                    <td>{{ $report->description }}</td>
                                    <td>{{ $report->doctor->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table Responsive -->
            </div> <!-- End Card Body -->
        </div> <!-- End Card -->
    </div> <!-- End Col -->

    <!-- Medicine Summary -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Medicine Summary</h4>
                <div class="d-flex flex-column">
                    @foreach($medicineSummary as $medicine)
                        <div class="bg-light p-3 mb-2 rounded">
                            <h5 class="mb-1">{{ $medicine->medicine }}</h5>
                            <p class="mb-0 font-weight-bold">Total Amount: {{ number_format($medicine->total_amount, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- End Col -->

    <!-- Doctor Prescriptions -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Doctor Prescriptions</h4>
                <div class="d-flex flex-column">
                    @foreach($doctorPrescriptions as $doctor)
                        <div class="bg-light p-3 mb-2 rounded">
                            <h5 class="mb-1">{{ $doctor->doctor->name }}</h5>
                            <p class="mb-0 font-weight-bold">{{ $doctor->prescription_count }} prescriptions</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- End Col -->

    <!-- Summary Card -->
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Pharmacy Summary</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Total Transactions</td>
                            <td>{{ $pharmacyReports->count() }}</td>
                        </tr>
                        <tr>
                            <td>Total Medicines Sold</td>
                            <td>{{ number_format($totalMedicinesSold, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Total Amount Collected</td>
                            <td>{{ number_format($totalAmount, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End Table Responsive -->
            </div>
        </div>
    </div> <!-- End Col -->
</div>
<!-- End Row -->
@endsection
