@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Patients</li>
                </ol>
            </div>
            <h4 class="page-title">Patients</h4>
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
                        <form class="form-inline" method="GET" action="{{ route('patients.index') }}">
                            <div class="form-group mb-2">
                                <label for="search" class="sr-only">Search</label>
                                <input type="search" name="search" class="form-control" id="search" placeholder="Search..." value="{{ request()->query('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                            @can('create', App\Models\Patient::class)
                                <a href="{{ route('patients.create') }}" class="btn btn-danger mb-2 mr-2">
                                    <i class="mdi mdi-basket mr-1"></i> Add New Patient
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
                                <th>Photo</th>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr>
                                    <td>
                                        @if($patient->avatar)
                                            <img src="{{ asset('storage/' . $patient->avatar) }}" alt="image" class="rounded-circle avatar-xs">
                                        @else
                                            <img src="{{ asset('images/default-avatar.png') }}" alt="image" class="rounded-circle avatar-xs">
                                        @endif
                                    </td>
                                    <td>{{ $patient->id }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->email }}</td>
                                    <td>{{ $patient->address }}</td>
                                    <td>{{ $patient->contact }}</td>
                                    <td>{{ $patient->contact_person }}</td>
                                    <td>{{ $patient->status }}</td>
                                    <td>
                                        @can('edit patients', $patient)
                                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        @endcan
                                        
                                        @can('delete patients', $patient)
                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination justify-content-end mt-3">
                    {{ $patients->links() }}
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection
