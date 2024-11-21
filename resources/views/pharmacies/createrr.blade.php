@extends('layouts.app')

@section('main')
<div class="container">
    <h2>Create Staff</h2>
    <form id="add-staff-form" action="{{ route('staffs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" class="form-control" id="contact" name="contact" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="department_id">Department:</label>
            <select name="department_id" id="department_id" class="form-control" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" onclick="registerStaff()" class="btn btn-primary">Add Staff</button>
    </form>
</div>
@endsection

<script>
    function registerStaff() {
        // Get the form data
        let formData = new FormData(document.getElementById('add-staff-form'));

        // Perform client-side form validation
        if (!validateForm(formData)) {
            // If the form validation fails, display an error message and return
            Swal.fire({
                title: 'Error',
                text: 'Please fill in all the required fields correctly.',
                icon: 'error',
                showConfirmButton: true
            });
            return;
        }

        // Perform an AJAX request to submit the form data
        fetch('{{ route("staffs.store") }}', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    // If the request was successful, generate the success message
                    return Swal.fire({
                        title: 'Success',
                        text: 'Staff registered successfully.',
                        icon: 'success',
                        showConfirmButton: true
                    }).then(() => {
                        // Redirect to the index page after the user confirms the success message
                        window.location.href = '{{ route("staffs.index") }}';
                    });
                } else {
                    // If the request was not successful, throw an error
                    throw new Error('Failed to register Staff');
                }
            })
            .catch(error => {
                // Display an error message if an exception occurs
                Swal.fire({
                    title: 'Error',
                    text: error.message,
                    icon: 'error',
                    showConfirmButton: true
                });
            });
    }

    function validateForm(formData) {
        // Perform your form field validation here
        // For example, check if the required fields are filled

        const name = formData.get('name');
        const address = formData.get('address');
        const contact = formData.get('contact');
        const email = formData.get('email');
        const departmentId = formData.get('department_id');
     

        // Check if any of the required fields are empty
        if (!name || !address || !contact || !email|| !departmentId ) {
            return false; // Return false if any required field is empty
        }

        // Check if the password and password confirmation match
      

        // Add more validation checks as needed

        return true; // Return true if all fields are valid
    }
</script>