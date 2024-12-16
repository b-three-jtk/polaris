@extends('layouts.dashboard')

@section('title', 'Daftar Riwayat Review')

@push('styles')
    <style>
        .no-shadow {
            box-shadow: none;
        }

        table {
            border-color: #ffffffc7 !important;
        }

        .header-container {
            justify-content: space-between;
        }

        th,
        td {
            text-align: center;
            padding: 15px !important;
            border-bottom: 2px solid #ffffff6f !important;
        }

        .dt-buttons .dt-button {
            border: none !important;
            /* Hilangkan border */
            border-radius: 8px !important;
            /* Buat sudut tombol melengkung */
            padding: 8px 12px !important;
            /* Sesuaikan padding */
            margin: 5px !important;
            /* Jarak antar tombol */
            font-size: 14px !important;
            /* Sesuaikan ukuran font */
            font-weight: bold !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .dt-buttons .btn-copy {
            background-color: #e86d00 !important;
            /* Warna background */
            color: white
        }

        .dt-buttons .btn-pdf {
            background-color: #f2382e !important;
            /* Warna background */
            color: white
        }

        .dt-buttons .btn-excel {
            background-color: #1d6f42 !important;
            /* Warna background */
            color: white
        }

        .dataTables_filter input {
            border-radius: 10px !important;
        }

        .dataTables_length {
            margin-bottom: 10px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
@endpush

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

@section('content')
    <div class="pl-32">
        <a href="{{ route('dashboard.submissions.index') }}">
            <span class="text-2xl material-symbols-outlined">
                arrow_back
                </span>
        </a>
    </div>
    <h1 class="text-2xl font-bold mb-8 pl-32 pt-10">
        <span class="text-black">Riwayat</span>
        <span class="text-accent-600">Review Pengajuan</span>
    </h1>
    @if (auth()->user()->role == 4)
    <a href="{{ route('admin.create') }}" class="mr-auto float-left bg-white ml-32 py-2 px-4 rounded-xl flex items-center border gap-5">
        <span class="material-symbols-outlined text-lg">
            history
            </span>
            History
            <span class="bg-primary-700 rounded-full py-0.5 px-2 text-white text-xs">0</span>
    </a>        
    @elseif (auth()->user()->role == 1)
    <a href="{{ route('submissions.create') }}" class="mr-auto float-left mb-3 bg-secondary-800 text-white ml-32 py-2 px-4 rounded-xl flex items-center border gap-2">
        <span class="material-symbols-outlined text-lg">
            add
            </span>
            Tambah Pengajuan
    </a>
    @endif

    <!-- Table -->
    <div class="table-container datatable-dark data-tables mx-auto" style="max-width: 1300px; padding: 1rem;">
        <table id="mauexport"
            class="w-full text-sm text-left text-black-700 border border-gray-400 border-collapse rounded-xl overflow-hidden shadow-lg">
            <thead class="text-md text-nowrap text-black-900 bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Judul Aplikasi</th>
                    @if (auth()->user()->role != 1)
                        <th scope="col" class="px-5 py-4 font-semibold">Pengaju</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Asal Organisasi</th>
                    @else
                        <th scope="col" class="px-5 py-4 font-semibold">Hasil Review</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Tanggal Review</th>
                    @endif
                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal Pengajuan</th>
                    <th scope="col" class="px-6 py-4 text-center font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="text-md">
                @forelse($submissions as $pengajuan)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $pengajuan->submission_title }}</td>
                        @if (auth()->user()->role != 1)
                            <td class="px-6 py-4">
                                {{ auth()->user()->role == 3
                                    ? $pengajuan->submitter_name ?? 'Tidak diketahui'
                                    : $pengajuan->submitter->user->name ?? 'Tidak diketahui' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ auth()->user()->role == 3
                                    ? $pengajuan->organization_name ?? 'Tidak diketahui'
                                    : $pengajuan->submitter->organization->organization_name ?? 'Tidak diketahui' }}
                            </td>
                        @else
                            <td class="px-6 py-4">
                                {{ $pengajuan->review_description ?? 'Belum di-review' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $pengajuan->review_date ? Carbon::parse($pengajuan->review_date)->toFormattedDateString() : 'Belum di-review' }}
                            </td>
                        @endif
                        <td class="px-6 py-4">
                            {{ $pengajuan->created_at ? Carbon::parse($pengajuan->created_at)->toFormattedDateString() : 'Tanggal tidak tersedia' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($pengajuan->status == 'terverifikasi')
                                <span
                                    class="inline-block min-w-40 px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full">Diverifikasi</span>
                            @elseif ($pengajuan->status == 'belum_direview')
                                <span
                                    class="inline-block min-w-40 px-3 py-1 text-sm font-semibold text-white bg-gray-400 rounded-full">Belum
                                    Diverifikasi</span>
                            @elseif ($pengajuan->status == 'ditolak')
                                <span
                                    class="inline-block min-w-40 px-3 py-1 text-sm font-semibold text-white bg-red-500 rounded-full">
                                    Ditolak</span>
                            @elseif ($pengajuan->status == 'diarsipkan')
                                <span
                                    class="inline-block min-w-40 px-3 py-1 text-sm font-semibold text-white bg-gray-300 rounded-full">
                                    Diarsipkan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">Tidak ada pengajuan yang sudah Anda review.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
            $('#mauexport').DataTable({
                
            });
        });
    </script>
@endpush
