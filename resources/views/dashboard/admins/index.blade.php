@extends('layouts.dashboard')

@section('title', 'Daftar Admin')

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        background-color: white!important;
    }

    .table thead th {
        color: #000;
    }

    .table tbody tr {
        background-color: white;
        border-bottom: 1px solid #dee2e6;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-warning {
        color: #1d3b6c;
    }

    .table-custom {
        margin-left: 20px;
    }

    th,
    td {
        text-align: center;
        padding: 15px!important;
        border-bottom: 2px solid #ffffff6f!important;
    }

    table {
            border-color: #ffffffc7!important;
            border-bottom: 1px solid #ffffffc7!important;
        }

    .header-container {
        justify-content: space-between;
    }

    .dataTables_length { 
        margin-bottom: 20px!important;
    }

    .dataTables_length label {
        color: #fff;
    }

    .dataTables_length select {
        color: #000;
        border-radius: 10px;
    }

    .dataTables_filter label {
        color: #fff;
    }

    .dataTables_filter input {
        color: #000;
        border-radius: 10px;
    }

    .dataTables_info {
        color: #fff!important;
    }

    .dataTables_paginate .paginate_button {
        color: #fff!important;
    }

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
@endpush

@section('content')
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6 pl-32 pt-10">
        Data
        <span class="text-accent-600">Admin</span>
    </h1>

    <div class="mt-4 flex justify-center">
        <div class="py-16 mx-32 w-full rounded-lg bg-primary-900 px-16"> <!-- Blue container -->
            <a href="{{ route('admin.create') }}"
                class="mr-auto bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-600">
                <span class="material-symbols-outlined mr-2">add</span>
                Tambah Admin
            </a>
            <div class="table-container mx-auto mt-7">
                <table id="admin-table" class="table table-hover row-border text-black w-full rounded-lg">
                    <thead class="text-lg text-nowrap text-black-900 bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="px-4 py-4 font-semibold">Nama</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Role</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="px-6 py-4">{{ $admin->name }}</td>
                                <td class="px-6 py-4">{{ $admin->email }}</td>
                                <td class="px-6 py-4 text-center">{{ $admin->role == 2 ? 'Admin' : 'Reviewer' }}</td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <a href="{{ route('admin.show', ['admin' => $admin]) }}"
                                        class="flex items-center text-black-600">
                                        <span
                                            class="inline-flex items-center px-4 py-1 text-sm font-semibold text-white bg-blue-500 rounded-full">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </span>
                                    </a>
                                    <a href="{{ route('admin.edit', ['admin' => $admin]) }}"
                                        class="flex items-center text-black-600">
                                        <span
                                            class="inline-flex items-center px-4 py-1 text-sm font-semibold text-white bg-accent-500 rounded-full">
                                            <span class="material-symbols-outlined text-base">edit</span>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#admin-table').DataTable();
});
</script>
@endpush
