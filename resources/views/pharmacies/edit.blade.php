@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Hospital Pharmacy</a></li>
                    <li class="breadcrumb-item active">Edit Hospital Pharmacy</li>
                </ol>
            </div>
            <h4 class="page-title">Edit Hospital Pharmacy</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pharmacies.update', $pharmacy->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="patient_id">Patient Name</label>
                                <select name="patient_id" id="patient_id" class="form-control" required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ $pharmacy->patient_id == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control" value="{{ $pharmacy->contact }}" placeholder="Enter patient's contact">
                            </div>

                            <div class="form-group">
                                <label for="medicine">Medicine</label>
                                <input type="text" name="medicine" id="medicine" class="form-control" value="{{ $pharmacy->medicine }}" placeholder="Enter medicine">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="5" placeholder="Enter the description">{{ $pharmacy->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ $pharmacy->amount }}" placeholder="Enter amount">
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">Doctor Name</label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $pharmacy->doctor_id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="form-group mt-3 mt-xl-0">
                                <label for="avatar" class="mb-0">Avatar</label>
                                <p class="text-muted font-14">Recommended thumbnail size 800x400 (px).</p>
                                <input type="file" name="avatar" id="avatar" class="form-control">
                            </div>

                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
@endsection
