@extends('layouts.app')

@section('title', 'Detail Data Pengajuan')

@section('content')
<div class="px-60 my-10 p-6 font-manrope">
    <!-- Judul -->
    <h1 class="text-3xl font-semibold mb-10 text-center text-gray-800">
        {{ $submission->submission_title }}
    </h1>

    <!-- Nama Organisasi -->
    <div class="flex justify-left items-center mb-3">
        <img src="{{ asset('images/organization.png') }}" alt="Logo Organisasi" class="h-8 w-8">
        <h2 class="text-xl font-bold text-gray-700 px-6">{{ $submission->submitter->organization->organization_name }}</h2>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-primary-900 py-4 px-6 rounded-t-xl shadow-md relative">
        <ul class="flex justify-center space-x-10 text-center text-white font-semibold" id="tabs">
            <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="deskripsi">DESKRIPSI</li>
            <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="kebutuhan">KEBUTUHAN APLIKASI</li>
            <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="detail">DETAIL APLIKASI</li>
            <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="referensi">REFERENSI</li>
            @auth
            <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="hasil-review">HASIL REVIEW</li>                
            <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="kontak">KONTAK</li>
            @endauth
        </ul>
        <!-- Orange underline -->
        <div id="underline" class="absolute bottom-0 left-0 h-1 w-0 bg-accent-600 transition-all duration-300"></div>
    </div>

    <!-- Tabs Content -->
    <div id="tab-contents" class="mt-4">
        <!-- Deskripsi -->
        <div id="deskripsi" class="tab-content transition-opacity duration-300 text-left">
            <div class="bg-white p-6 shadow-xl rounded-lg h-[300px] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Deskripsi Masalah</h2>
                <p class="text-md text-gray-600 mb-6">{{ $submission->problem_description }}</p>

                <h2 class="text-lg font-bold mb-4">Tujuan Aplikasi</h2>
                <p class="text-md text-gray-600 mb-6">{{ $submission->application_purpose }}</p>
            </div>
        </div>

        <!-- Kebutuhan Aplikasi -->
        <div id="kebutuhan" class="tab-content hidden transition-opacity duration-300 text-left">
            <div class="bg-white p-6 shadow-xl rounded-lg h-[300px] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Kebutuhan Aplikasi</h2>
                <h3 class="text-md font-semibold mb-2">Proses Bisnis:</h3>
                <p class="text-md text-gray-600 mb-6">{!! $submission->business_process !!}</p>

                <h3 class="text-md font-semibold mt-4">Aturan Bisnis:</h3>
                <p class="text-md text-gray-600 mb-6">{!! $submission->business_rules !!}</p>
            </div>
        </div>

        <!-- Detail Aplikasi -->
        <div id="detail" class="tab-content hidden transition-opacity duration-300 text-left">
            <div class="bg-white p-6 shadow-xl rounded-lg h-[300px] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Detail Aplikasi</h2>
                <h3 class="text-md font-semibold mb-2">Stakeholder:</h3>
                <p class="text-md text-gray-600 mb-6">{{ $submission->stakeholders }}</p>

                <h3 class="text-md font-semibold mt-4 mb-2">Jenis Proyek:</h3>
                <p class="text-md text-gray-600 mb-6">
                    {{ $submission->project_type ? 'Proyek yang sudah ada' : 'Proyek Baru' }}
                </p>

                <h3 class="text-md font-semibold mt-4 mb-2">Platform:</h3>
                <p class="text-md text-gray-600 mb-6">{{ $submission->platform }}</p>
            </div>
        </div>

        <!-- Referensi -->
        <div id="referensi" class="tab-content hidden transition-opacity duration-300 text-left">
            <div class="bg-white p-6 shadow-xl rounded-lg h-[300px] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Referensi</h2>
                @foreach ($submission->reference as $ref)
                <p class="text-lg text-gray-600 mb-2">{{ $ref->description }}</p>
                @if ($ref->type == 'file')
                    @php
                        $filePath = storage_path('app/public/' . $ref->path);
                        $fileExtension = pathinfo($ref->path, PATHINFO_EXTENSION);
                    @endphp
                    @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/' . $ref->path) }}" alt="Referensi Image" class="mb-2"
                            style="width: 100%; max-width: 300px;">
                    @elseif (strtolower($fileExtension) == 'pdf')
                        <embed src="{{ asset('storage/' . $ref->path) }}" type="application/pdf" class="mb-2"
                            width="100%" height="600px">
                    @endif
                @else
                    <a href="{{ $ref->path }}" class="text-lg text-gray-600 mb-2">{{ $ref->path }}</a>
                @endif
            @endforeach
            </div>
        </div>

        <!-- Hasil Review -->
        <div id="hasil-review" class="tab-content hidden transition-opacity duration-300 text-left">
            <div class="bg-white p-6 shadow-xl rounded-lg h-[300px] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Hasil Review</h2>
                <p class="text-md text-gray-600 mb-6">{{ $submission->review_description }}</p>
            </div>
        </div>

        <!-- Kontact -->
        <div id="kontak" class="tab-content hidden transition-opacity duration-300 text-left">
            <div class="bg-white p-6 shadow-xl rounded-lg h-[300px] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Kontak</h2>
                <h3 class="text-md font-semibold mb-2">Nama Pengaju:</h3>
                <p class="text-md text-gray-600 mb-6">{{ $submission->submitter->user->name }}</p>

                <h3 class="text-md font-semibold mb-2">No. Telp:</h3>
                <p class="text-md text-gray-600 mb-6">{{ $submission->submitter->user->phone_number }}</p>

                <h3 class="text-md font-semibold mb-2">Email:</h3>
                <p class="text-md text-gray-600 mb-6">{{ $submission->submitter->user->email }}</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tab-item');
        const contents = document.querySelectorAll('.tab-content');
        const underline = document.getElementById('underline');

        function setUnderline(target) {
            underline.style.width = `${target.offsetWidth}px`;
            underline.style.left = `${target.offsetLeft}px`;
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('font-bold', 'text-accent-600'));
                contents.forEach(c => c.classList.add('hidden'));

                this.classList.add('font-bold', 'text-accent-600');
                document.getElementById(this.getAttribute('data-target')).classList.remove('hidden');
                setUnderline(this);
            });
        });

        // Initial state
        tabs[0].classList.add('font-bold', 'text-accent-600');
        contents[0].classList.remove('hidden');
        setUnderline(tabs[0]);
    });
</script>
@endsection