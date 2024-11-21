@extends('layouts.app')

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pharmacist</li>
                </ol>
            </div>
            <h4 class="page-title">Pharmacists</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- start main content row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Search and Add New Pharmacist Section -->
                <div class="row mb-2">
                    <div class="col-lg-8">
                        <form class="form-inline" method="GET" action="{{ route('pharmacists.index') }}">
                            <div class="form-group mb-2">
                                <label for="search" class="sr-only">Search</label>
                                <input type="search" name="search" class="form-control" id="search" placeholder="Search..." value="{{ request()->query('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                            @can('create pharmacy')
                            <a href="{{ route('pharmacists.create') }}" class="btn btn-danger mb-2 mr-2">
                                <i class="mdi mdi-basket mr-1"></i> Add New Pharmacist
                            </a>
                            @endcan
                            <button type="button" class="btn btn-light mb-2" id="download-excel">Export</button>
                            <button type="button" class="btn btn-light mb-2" id="download-pdf">Download PDF</button>
                        </div>
                    </div>
                </div>
                <!-- end of Search and Add New Pharmacist Section -->

                <!-- Pharmacists Table -->
                <div class="table-responsive">
                    <table id="pharmacists-table" class="table table-centered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Photo</th>
                                <th>Pharmacist ID</th>
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
                            @foreach ($pharmacists as $pharmacist)
                                <tr>
                                    <td>
                                        <img src="{{ $pharmacist->avatar ? asset('storage/' . $pharmacist->avatar) : 'https://via.placeholder.com/50' }}" alt="Pharmacist Picture" class="rounded-circle" width="50" height="50">
                                    </td>
                                    <td>{{ $pharmacist->id }}</td>
                                    <td>{{ $pharmacist->name }}</td>
                                    <td>{{ $pharmacist->email }}</td>
                                    <td>{{ $pharmacist->contact }}</td>
                                    <td>{{ $pharmacist->address }}</td>
                                    <td>{{ $pharmacist->qualification }}</td>
                                    <td>{{ $pharmacist->specialty }}</td>
                                    <td>{{ $pharmacist->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('edit pharmacy')
                                            <a href="{{ route('pharmacists.edit', ['pharmacist' => $pharmacist->id]) }}" class="dropdown-item">
                                                <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                                            </a>
                                            @endcan
                                            @can('delete pharmacy')
                                            <button type="button" class="dropdown-item" onclick="showDeleteConfirmation({{ $pharmacist->id }})">
                                                <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $pharmacist->id }}" action="{{ route('pharmacists.destroy', ['pharmacist' => $pharmacist->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end of Pharmacists Table -->

                <!-- Pagination Links -->
                {{ $pharmacists->appends(request()->query())->links() }}

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end main content row -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { jsPDF } = window.jspdf;
        const autoTable = window.jspdf.AutoTable;

        // Function to export table to PDF
        document.getElementById('download-pdf').addEventListener('click', () => {
            const doc = new jsPDF();
            const table = document.querySelector('#pharmacists-table');
            const rows = Array.from(table.querySelectorAll('tr'));
            const data = rows.map(row => Array.from(row.querySelectorAll('td, th')).map(cell => cell.textContent));

            doc.autoTable({
                head: [['Pharmacist ID', 'Name', 'Email', 'Contact', 'Address', 'Qualifications', 'Specialist', 'Status']],
                body: data.slice(1) // Remove header row if already included in head
            });

            doc.save('pharmacists.pdf');
        });

        // Function to export table to Excel
        document.getElementById('download-excel').addEventListener('click', () => {
            const table = document.getElementById('pharmacists-table');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Pharmacists Entries" });
            XLSX.writeFile(wb, 'pharmacists.xlsx');
        });
    });

    // Show delete confirmation using SweetAlert
    function showDeleteConfirmation(pharmacistId) {
        Swal.fire({
            title: 'Confirm Deletion',
            text: 'Are you sure you want to delete this Pharmacist?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + pharmacistId).submit();
            }
        });
    }
</script>
@endsection
