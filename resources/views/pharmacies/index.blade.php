@extends('layouts.app')

@section('main')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Hospital Pharmacy</li>
                </ol>
            </div>
            <h4 class="page-title">Hospital Pharmacy</h4>
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
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <label for="inputPassword2" class="sr-only">Search</label>
                                <input type="search" class="form-control" id="inputPassword2" placeholder="Search...">
                            </div>
                            
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                            <a href="{{ route('pharmacies.create') }}" class="btn btn-danger mb-2 mr-2">
                                <i class="mdi mdi-basket mr-1"></i> Add New Hospital Pharmacy
                            </a>
                            <button id="download-pdf" type="button" class="btn btn-light mb-2">Export PDF</button>
                            <button id="download-excel" type="button" class="btn btn-light mb-2">Export Excel</button>
                        </div>
                    </div>
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
                                <th>Contact</th>
                                <th>Medicine</th>
                                <th>Descriptions</th>
                                <th>Amount</th>
                                <th>Doctor's Name</th>
                                <th style="width: 125px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pharmacies as $pharmacy)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>HSPH00{{ $pharmacy->id }}</td>
                                <td>{{ $pharmacy->patient->name }}</td>
                                <td>{{ $pharmacy->contact }}</td>
                                <td>{{ $pharmacy->medicine}}</td>
                                <td>{{ $pharmacy->description }}</td>
                                <td>{{ number_format($pharmacy->amount, 2) }} TZS</td>
                                <td>Dr. {{ $pharmacy->doctor->name }}</td>
                                <td>
                                        <div class="btn-group">
                                            <a href="{{ route('pharmacies.edit', $pharmacy->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('pharmacies.destroy', $pharmacy->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row --> 

@endsection
