@extends('layouts.app')
@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item active">{{ isset($patient) ? 'Edit Patient' : 'Create Patient' }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ isset($patient) ? 'Edit Patient' : 'Create Patient' }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="add-patient-form" action="{{ isset($patient) ? route('patients.update', $patient) : route('patients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($patient))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter patient's name" value="{{ old('name', $patient->name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter patient's email" value="{{ old('email', $patient->email ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" value="{{ old('address', $patient->address ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter patient's contact" value="{{ old('contact', $patient->contact ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Enter patient's contact person" value="{{ old('contact_person', $patient->contact_person ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" class="form-control" placeholder="Enter patient's status" value="{{ old('status', $patient->status ?? '') }}">
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="form-group mt-3 mt-xl-0">
                                <label for="avatar" class="mb-0">Avatar</label>
                                <p class="text-muted font-14">Recommended thumbnail size 800x400 (px).</p>
                                <input type="file" name="avatar" id="avatar" class="form-control">
                                @if(isset($patient) && $patient->avatar)
                                    <img src="{{ asset('storage/' . $patient->avatar) }}" alt="Patient Avatar" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">{{ isset($patient) ? 'Update' : 'Save' }}</button>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
@endsection
