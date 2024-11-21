@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title">Edit Appointment</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Appointments</a></li>
                <li class="breadcrumb-item active">Edit Appointment</li>
            </ol>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="edit-appointment-form" method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $appointment->name) }}" placeholder="Enter patient's name">
                            </div>

                            <div class="form-group">
                                <label for="appointment-overview">Reason</label>
                                <textarea name="reason" class="form-control" id="appointment-overview" rows="5" placeholder="Enter the reason for the appointment">{{ old('reason', $appointment->reason) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input id="date" name="date" type="date" class="form-control" value="{{ old('date', $appointment->date) }}">
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact', $appointment->contact) }}" placeholder="Enter contact number">
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">Doctor Name</label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input id="time" name="time" type="time" class="form-control" value="{{ old('time', $appointment->time) }}">
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="row mt-4">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>

<script>
function validateForm(formData) {
    const requiredFields = ['name', 'contact', 'date', 'time', 'reason', 'doctor_id'];
    for (const field of requiredFields) {
        if (!formData.get(field)) {
            return false;
        }
    }
    return true;
}

document.getElementById('edit-appointment-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(document.getElementById('edit-appointment-form'));

    if (!validateForm(formData)) {
        Swal.fire({
            title: 'Error',
            text: 'Please fill out all fields.',
            icon: 'error',
            showConfirmButton: true
        });
        return;
    }

    fetch('{{ route('appointments.update', $appointment->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PUT'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success',
                text: data.message || 'Appointment updated successfully.',
                icon: 'success',
                showConfirmButton: true
            }).then(() => {
                window.location.href = '{{ route('appointments.index') }}';
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Failed to update appointment.',
                icon: 'error',
                showConfirmButton: true
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: error.message || 'Failed to update appointment',
            icon: 'error',
            showConfirmButton: true
        });
    });
});
</script>
@endsection
