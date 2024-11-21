@extends('layouts.app')
@section('main')
 <!-- start page title -->
 @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('doctor'))
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-light" id="dash-daterange">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-primary border-primary text-white">
                                                            <i class="mdi mdi-calendar-range font-13"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript: void(0);" class="btn btn-primary ml-2">
                                                <i class="mdi mdi-autorenew"></i>
                                            </a>
                                            <a href="javascript: void(0);" class="btn btn-primary ml-1">
                                                <i class="mdi mdi-filter-variant"></i>
                                            </a>
                                        </form>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-5 col-lg-6">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Appointments</h5>
                                                <h3 class="mt-3 mb-3">{{$totalAppointments}}</h3>
                                                <p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                                    <span class="text-nowrap">Since last month</span>  
                                                </p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-cart-plus widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Doctors</h5>
                                                <h3 class="mt-3 mb-3">{{$totalDoctorsCount}}</h3>
                                                <p class="mb-0 text-muted">
                                                    <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-currency-usd widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">Total Pharmacy Amount</h5>
                                                <h3 class="mt-3 mb-3">{{ number_format($totalPharmacyAmount, 2) }} TZS</h3>
                                                <p class="mb-0 text-muted">
                                                    <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-pulse widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Growth">Patients</h5>
                                                <h3 class="mt-3 mb-3">{{$totalPatients}}</h3>
                                                <p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                            </div> <!-- end col -->

                            <div class="col-xl-7  col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dropdown float-right">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title mb-3">Projections Vs Actuals</h4>

                                        <div id="high-performing-product" class="apex-charts"
                                            data-colors="#727cf5,#e3eaef"></div>
                                            
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                      
                          

                        <div class="row">
                        <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="" class="btn btn-sm btn-link float-right mb-3">Export
                    <i class="mdi mdi-download ml-1"></i>
                </a>
                <h4 class="header-title mt-2">Top Scheduled Doctors</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                            @foreach($topScheduledDoctors as $doctor)
                            <tr>
                                <td>
                                        <img src="{{ $doctor->avatar ? asset('storage/' . $doctor->avatar) : 'https://via.placeholder.com/50' }}" alt="Doctor Picture" class="rounded-circle" width="50" height="50">
                                    </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->name }}</h5>
                                    <span class="text-muted font-13">ID: {{ $doctor->id }}</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->appointments_count }}</h5>
                                    <span class="text-muted font-13">Appointments</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->specialty }}</h5>
                                    <span class="text-muted font-13">Specialty</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->status }}</h5>
                                    <span class="text-muted font-13">Status</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->

                            

                            <div class="col-xl-3 col-lg-6 order-lg-1">
    <div class="card">
        <div class="card-body">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
            </div>
            <h4 class="header-title mb-2">Recent Appointments</h4>

            <div data-simplebar style="max-height: 424px;">
                <div class="timeline-alt pb-0">
                    @foreach($appointments as $appointment)
                        <div class="timeline-item">
                            <div class="timeline-icon-wrapper bg-{{ $appointment->status == 'completed' ? 'success' : 'warning' }}-lighten">
                                <i class="mdi mdi-calendar-check text-{{ $appointment->status == 'completed' ? 'success' : 'warning' }}"></i>
                            </div>
                            <div class="timeline-item-info">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $appointment->doctor->avatar ? asset('storage/' . $appointment->doctor->avatar) : 'https://via.placeholder.com/50' }}" class="rounded-circle avatar-sm mr-3" alt="{{ $appointment->doctor->name }}" width="50" height="50">
                                    <div>
                                        <a href="#" class="text-primary font-weight-bold mb-1 d-block">{{ $appointment->doctor->name }}</a>
                                        <small>Appointment with {{ $appointment->patient->name }}</small>
                                    </div>
                                </div>
                                <p class="mb-0 pb-2">
                                    <small class="text-muted">{{ $appointment->created_at->diffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> <!-- end slimscroll -->
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div>
<div class="col-xl-3 col-lg-6 order-lg-1">
    <div class="card card-hover-shadow">
        <div class="card-body">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                </div>
            </div>
            <h4 class="header-title mb-2">Recent Pharmacies</h4>

            <div data-simplebar style="max-height: 424px;">
                <div class="timeline-alt pb-0">
                    @foreach($pharmacies as $pharmacy)
                        <div class="timeline-item">
                            <div class="timeline-icon-wrapper bg-{{ $pharmacy->amount > 100 ? 'success' : 'warning' }}-lighten">
                                <i class="mdi mdi-medical-bag text-{{ $pharmacy->amount > 100 ? 'success' : 'warning' }}"></i>
                            </div>
                            <div class="timeline-item-info">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $pharmacy->patient->avatar ? asset('storage/' . $pharmacy->patient->avatar) : 'https://via.placeholder.com/50' }}" class="rounded-circle avatar-sm mr-3" alt="{{ $pharmacy->patient->name }}" width="50" height="50">
                                    <div>
                                        <a href="#" class="text-primary font-weight-bold mb-1 d-block">{{ $pharmacy->patient->name }}</a>
                                        <small>Medicine: {{ $pharmacy->medicine }}</small>
                                    </div>
                                </div>
                                <p class="mb-0 pb-2">
                                    <span class="text-muted d-block">Amount: <span class="font-weight-bold text-{{ $pharmacy->amount > 100 ? 'success' : 'warning' }}">{{ $pharmacy->amount }}</span></span>
                                    <small class="text-muted">{{ $pharmacy->created_at->diffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> <!-- end slimscroll -->
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div>
@endif


<style>
.card {
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    background: white;
}
.card-body {
    padding: 1.5rem;
    border-radius: 15px;
}
.header-title {
    font-size: 1.2rem;
    color: #343a40;
    font-weight: bold;
    margin-bottom: 1rem;
}
.timeline-alt {
    position: relative;
    padding-left: 20px;
    margin-bottom: 1.5rem;
}
.timeline-item {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    position: relative;
    padding-left: 40px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: 18px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
.timeline-icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    position: absolute;
    left: 0;
}
.bg-success-lighten {
    background-color: #d4edda;
}
.bg-warning-lighten {
    background-color: #fff3cd;
}
.avatar-sm {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.timeline-item-info {
    margin-left: 1rem;
    background: rgba(255, 255, 255, 0.8);
    padding: 0.5rem 1rem;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}
.timeline-item-info a {
    color: #007bff;
    text-decoration: none;
}
.timeline-item-info a:hover {
    text-decoration: underline;
}
.text-primary {
    color: #007bff !important;
}
</style>


<style>
    .timeline-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }
    .avatar-sm {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .timeline-item-info {
        margin-left: 1rem;
    }
    .timeline-icon-wrapper.bg-success-lighten {
        background-color: #d4edda;
    }
    .timeline-icon-wrapper.bg-warning-lighten {
        background-color: #fff3cd;
    }
</style>

                            <!-- end col -->

                        </div>


                        <div class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="" class="btn btn-sm btn-link float-right mb-3">Export
                    <i class="mdi mdi-download ml-1"></i>
                </a>
                <h4 class="header-title mt-2">Top Scheduled Doctors</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                            @foreach($topScheduledDoctors as $doctor)
                            <tr>
                                <td>
                                    <img src="{{ $doctor->avatar ? asset('storage/' . $doctor->avatar) : 'https://via.placeholder.com/50' }}" alt="Doctor Picture" class="rounded-circle" width="50" height="50">
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->name }}</h5>
                                    <span class="text-muted font-13">ID: {{ $doctor->id }}</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->appointments_count }}</h5>
                                    <span class="text-muted font-13">Appointments</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->specialty }}</h5>
                                    <span class="text-muted font-13">Specialty</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 font-weight-normal">{{ $doctor->status }}</h5>
                                    <span class="text-muted font-13">Status</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive -->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->

    <div class="col-xl-6 col-lg-12">
    <div class="card">
        <div class="card-body">
            <a href="" class="btn btn-sm btn-link float-right mb-3">Export
                <i class="mdi mdi-download ml-1"></i>
            </a>
            <h4 class="header-title mt-2">Top Patients</h4>

            <div class="table-responsive">
                <table class="table table-centered table-nowrap table-hover mb-0">
                    <tbody>
                        @foreach($topPatients as $patient)
                        <tr>
                            <td>
                                <img src="{{ $patient['avatar'] }}" alt="Patient Picture" class="rounded-circle" width="50" height="50">
                            </td>
                            <td>
                                <h5 class="font-14 my-1 font-weight-normal">{{ $patient['name'] }}</h5>
                                <span class="text-muted font-13">ID: {{ $patient['id'] }}</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1 font-weight-normal">{{ $patient['appointments_count'] }}</h5>
                                <span class="text-muted font-13">Appointments</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1 font-weight-normal">{{ $patient['total_pharmacy_amount'] }}</h5>
                                <span class="text-muted font-13">Total Pharmacy Amount</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1 font-weight-normal">{{ $patient['status'] }}</h5>
                                <span class="text-muted font-13">Status</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end table-responsive -->
        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end col -->

</div> <!-- end row -->


<style>
.card {
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    background: white;
}
.card-body {
    padding: 1.5rem;
    border-radius: 15px;
}
.header-title {
    font-size: 1.2rem;
    color: #343a40;
    font-weight: bold;
    margin-bottom: 1rem;
}
.timeline-alt {
    position: relative;
    padding-left: 20px;
    margin-bottom: 1.5rem;
}
.timeline-item {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    position: relative;
    padding-left: 40px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: 18px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
.timeline-icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    position: absolute;
    left: 0;
}
.bg-success-lighten {
    background-color: #d4edda;
}
.bg-warning-lighten {
    background-color: #fff3cd;
}
.avatar-sm {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.timeline-item-info {
    margin-left: 1rem;
    background: rgba(255, 255, 255, 0.8);
    padding: 0.5rem 1rem;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}
.timeline-item-info a {
    color: #007bff;
    text-decoration: none;
}
.timeline-item-info a:hover {
    text-decoration: underline;
}
.text-primary {
    color: #007bff !important;
}
</style>


<style>
    .timeline-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }
    .avatar-sm {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .timeline-item-info {
        margin-left: 1rem;
    }
    .timeline-icon-wrapper.bg-success-lighten {
        background-color: #d4edda;
    }
    .timeline-icon-wrapper.bg-warning-lighten {
        background-color: #fff3cd;
    }
    
</style>

                            <!-- end col -->

                        </div>
                        <!-- end row -->

@endsection