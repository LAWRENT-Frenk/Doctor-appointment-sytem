@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title">Create Appointment</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('appointments.index')}}">Appointments</a></li>
                <li class="breadcrumb-item active">Create Appointment</li>
            </ol>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="add-appointment-form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <!-- Patient's ID will be selected -->
                            <div class="form-group">
                                <label for="patient_id">Patient</label>
                                <select name="patient_id" id="patient_id" class="form-control" required>
                                    <option value="">Select Patient</option>
                                    <!-- Assuming patients list is passed to the view -->
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="reason">Reason for Appointment</label>
                                <textarea name="reason" class="form-control" id="reason" rows="5" placeholder="Enter the reason for the appointment"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="date">Appointment Date</label>
                                <input id="date" name="date" type="date" class="form-control" value="{{ old('date') }}" required>
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="time">Appointment Time</label>
                                <input id="time" name="time" type="time" class="form-control" value="{{ old('time') }}" required>
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="row mt-4">
                        <div class="col-12 text-right">
                            <button type="button" id="submit-button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>

<script>
    document.getElementById('submit-button').onclick = function() {
        const form = document.getElementById('add-appointment-form');
        const formData = new FormData(form);

        if (!validateForm(formData)) {
            Swal.fire({
                title: 'Error',
                text: 'Please fill out all fields.',
                icon: 'error',
                showConfirmButton: true
            });
            return;
        }

        fetch('{{ route('appointments.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success',
                    text: data.message || 'Appointment scheduled successfully.',
                    icon: 'success',
                    showConfirmButton: true
                }).then(() => {
                    window.location.href = '{{ route('appointments.index') }}';
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'The chosen appointment time and date are already taken. Please select a different time or date, or consider scheduling with another available doctor.',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            Swal.fire({
                title: 'Error',
                text: error.message || 'Failed to schedule appointment',
                icon: 'error',
                showConfirmButton: true
            });
        });
    };

    function validateForm(formData) {
        // Implement your form validation logic here
        // Example: Check if all fields are filled
        let isValid = true;
        formData.forEach((value, key) => {
            if (!value) {
                isValid = false;
            }
        });
        return isValid;
    }
</script>

@endsection
