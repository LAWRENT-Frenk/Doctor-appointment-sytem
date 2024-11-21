@extends('layouts.app')
@section('main')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Appointments</li>
                </ol>
            </div>
            <h4 class="page-title">Appointments</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-8">
                        <form class="form-inline" method="GET" action="{{ route('appointments.index') }}">
                            <div class="form-group mb-2">
                                <label for="search" class="sr-only">Search</label>
                                <input type="search" name="search" class="form-control" id="search" placeholder="Search..." value="{{ request()->query('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                            @can('create', App\Models\Appointment::class)
                            <a href="{{ route('appointments.create') }}" class="btn btn-danger mb-2 mr-2">
                                <i class="mdi mdi-basket mr-1"></i> Add New Appointment
                            </a>
                            @endcan
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
            <tr>
                <th style="width: 20px;">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                    </div>
                </th>
                <th>ID</th>
                <th>Patient's Name</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Doctor's Name</th>
                <th style="width: 125px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck{{ $appointment->id }}">
                            <label class="custom-control-label" for="customCheck{{ $appointment->id }}"></label>
                        </div>
                    </td>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->patient ? $appointment->patient->name : 'N/A' }}</td>
                    <td>{{ $appointment->reason }}</td>
                    <td>{{ $appointment->date }}</td>
                    <td>{{ $appointment->time }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->doctor ? $appointment->doctor->name : 'N/A' }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}" class="dropdown-item">
                                <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                            </a>
                                <form id="delete-form-{{ $appointment->id }}" action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="button" class="dropdown-item" onclick="showDeleteConfirmation({{ $appointment->id }})">
                                            <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                        </button>
                                                    
                                </form>
                        </div>
                     </td>
   
                    <!-- <td>
                        <div class="btn-group">
                            @can('update', $appointment)
                                <a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}" class="dropdown-item">
                                    <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                                </a>
                            @endcan
                        </div>
                    </td> -->

                                        

                                    

                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


                {{ $appointments->links() }}
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Show delete confirmation using SweetAlert
    function showDeleteConfirmation(appointmentId) {
        Swal.fire({
            title: 'Confirm Deletion',
            text: 'Are you sure you want to delete this Appointment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the delete form if user confirms
                document.getElementById('delete-form-' + appointmentId).submit();
            }
        });
    }
</script>
@endsection
