@extends('layouts.app')
@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                    <li class="breadcrumb-item active">Create Patient</li>
                </ol>
            </div>
            <h4 class="page-title">Create Patient</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="add-patient-form" action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter patient's name">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter patient's email">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address">
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter patient's contact">
                            </div>

                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Enter patient's contact person">
                            </div>

                            <div class="form-group">
                                <label for="Status">Status</label>
                                <input type="text" name="status" id="statis" class="form-control" placeholder="Enter patient's status">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                            <button type="button" onclick="addPatient()" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>

<script>
function addPatient() {
    // Get the form data
    let formData = new FormData(document.getElementById('add-patient-form'));

    // Perform client-side form validation
    if (!validateForm(formData)) {
        // If the form validation fails, display an error message and return
        Swal.fire({
            title: 'Error',
            text: 'Please fill in all the required fields.',
            icon: 'error',
            showConfirmButton: true,
            // timer: 2500,
        });
        return;
    }

    // Perform an AJAX request to submit the form data
    fetch('{{ route('patients.store') }}', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                // If the request was successful, generate the success message
                return Swal.fire({
                    title: 'Patient Added',
                    text: 'Patient added successfully.',
                    icon: 'success',
                    showConfirmButton: true,
                });
            } else {
                // If the request was not successful, throw an error
                throw new Error('Failed to add Patient');
            }
        })
        .catch(error => {
            // Display an error message if an exception occurs
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error',
                showConfirmButton: true,
                // timer: 2100 // Adjust the duration as needed
            });
        })
        .finally(() => {
            // Redirect to the index page with a success message
            window.location.href = '{{ route('patients.index') }}?message=success';
        });
}

function validateForm(formData) {
    // Perform your form field validation here
    // For example, check if the required fields are filled

    const name = formData.get('name');
    const email = formData.get('email');
    const address = formData.get('address');
    // Add more fields as needed

    // Check if any of the required fields are empty
    if (!name || !email || !address) {
        return false; // Return false if any required field is empty
    }

    return true; // Return true if all fields are valid
}

</script>
@endsection
