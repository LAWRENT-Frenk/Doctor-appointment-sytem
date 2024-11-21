@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Doctors</li>
                </ol>
            </div>
            <h4 class="page-title">Doctors</h4>
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
                        <form class="form-inline" method="GET" action="{{ route('doctors.index') }}">
                            <div class="form-group mb-2">
                                <label for="search" class="sr-only">Search</label>
                                <input type="search" name="search" class="form-control" id="search" placeholder="Search..." value="{{ request()->query('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                            <a href="{{ route('doctors.create') }}" class="btn btn-danger mb-2 mr-2">
                                <i class="mdi mdi-basket mr-1"></i> Add New Doctor
                            </a>
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive">
                    <table id="doctors-table" class="table table-centered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Photo</th>
                                <th>Doctor ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Qualifications</th>
                                <th>Specialist</th>
                                <th>Status</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td>
                                        <img src="{{ $doctor->avatar ? asset('storage/' . $doctor->avatar) : 'https://via.placeholder.com/50' }}" alt="Doctor Picture" class="rounded-circle" width="50" height="50">
                                    </td>
                                    <td>{{ $doctor->id }}</td>
                                    <td>{{ $doctor->name }}</td>
                                    <td>{{ $doctor->email }}</td>
                                    <td>{{ $doctor->contact }}</td>
                                    <td>{{ $doctor->address }}</td>
                                    <td>{{ $doctor->qualification }}</td>
                                    <td>{{ $doctor->specialty }}</td>
                                    <td>{{ $doctor->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('doctors.edit', ['doctor' => $doctor->id]) }}" class="dropdown-item">
                                                <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                                            </a>
                                            <form id="delete-form-{{ $doctor->id }}" action="{{ route('doctors.destroy', ['doctor' => $doctor->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item" onclick="showDeleteConfirmation({{ $doctor->id }})">
                                                    <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                {{ $doctors->appends(request()->query())->links() }}
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { jsPDF } = window.jspdf;
        const autoTable = window.jspdf.AutoTable;

        document.getElementById('download-pdf').addEventListener('click', () => {
            const doc = new jsPDF();
            const table = document.querySelector('#doctors-table');
            const rows = Array.from(table.querySelectorAll('tr'));
            const data = rows.map(row => Array.from(row.querySelectorAll('td, th')).map(cell => cell.textContent));

            doc.autoTable({
                head: [['Doctor ID', 'Name', 'Email', 'Contact', 'Address', 'Qualifications', 'Specialist', 'Status']],
                body: data.slice(1) // Remove header row if already included in head
            });

            doc.save('doctors.pdf');
        });

        document.getElementById('download-excel').addEventListener('click', () => {
            const table = document.getElementById('doctors-table');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Doctors Entries" });
            XLSX.writeFile(wb, 'doctors.xlsx');
        });
    });

    // Show delete confirmation using SweetAlert
    function showDeleteConfirmation(doctorId) {
        Swal.fire({
            title: 'Confirm Deletion',
            text: 'Are you sure you want to delete this Doctor?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the delete form if user confirms
                document.getElementById('delete-form-' + doctorId).submit();
            }
        });
    }
</script>
@endsection
