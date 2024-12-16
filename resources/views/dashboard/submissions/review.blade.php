@extends('layouts.dashboard')

@section('title', 'Review Pengajuan')

@section('content')
    <script src="https://cdn.tiny.cloud/1/47nw0qlhrh8muk22r37wq3jkboeh6f1s37vhnj54knr72ukl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: 'textarea#review_description',
    plugins: 'table lists',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
});
</script>

    <h1 class="text-2xl font-bold mb-6 pl-32 pt-10">
        Review
        <span class="text-accent-600">Pengajuan</span>
    </h1>

    <div class="flex gap-10 mx-auto px-24">
        <div class="w-full my-10 rounded-xl font-manrope">
            <!-- Judul -->
            <h1 class="text-3xl font-semibold mb-10 text-center text-gray-800">
                {{ $submission->submission_title }}
            </h1>

            <!-- Nama Organisasi -->
            <div class="flex justify-left items-center mb-3">
                <img src="{{ asset('images/organization.png') }}" alt="Logo Organisasi" class="h-8 w-8">
                <h2 class="text-xl font-bold text-gray-700 px-6">
                    {{ $submission->submitter->organization->organization_name }}</h2>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-primary-900 py-4 px-6 rounded-t-xl shadow-md relative">
                <ul class="flex justify-center space-x-10 text-center text-white font-semibold" id="tabs">
                    <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="deskripsi">DESKRIPSI</li>
                    <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="kebutuhan">KEBUTUHAN
                        APLIKASI</li>
                    <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="detail">DETAIL APLIKASI</li>
                    <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="referensi">REFERENSI</li>
                    @auth
                        <li class="tab-item cursor-pointer pb-2 hover:text-accent-600" data-target="kontak">KONTAK</li>
                    @endauth
                </ul>
                <!-- Orange underline -->
                <div id="underline" class="absolute bottom-0 left-0 h-1 w-0 bg-accent-600 transition-all duration-300">
                </div>
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

        <div class="py-8 w-full">
            <form id="submissionForm" method="POST"
                action="{{ route('review.update', ['review' => $submission->submission_code]) }}"
                class="max-w-4xl mx-auto">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="text" class="hidden" name="submission_code" value="{{ $submission->submission_code }}"
                    id="">
                <div class="bg-white rounded-xl overflow-hidden shadow-md w-full h-900 p-4">
                    <h2 class="text-xl font-semibold mb-4">Review Pengajuan</h2>
                    <p class="font-sans text-gray-400 text-xxs">Isi form review pengajuan dengan detail dan lengkap</p>
                    <hr class="border-gray-950 border-t-1 w-full mx-auto my-5">

                    <div class="mb-4">
                        <label for="review_description" class="block mb-2">Review Pengajuan</label>
                        <textarea id="review_description" name="review_description" rows="4"
                            class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block mb-2">Status</label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="0" class="form-radio">
                            <span class="ml-2">Tolak</span>
                        </label>
                        <label class="inline-flex items-center ml-5">
                            <input type="radio" name="status" value="1" class="form-radio">
                            <span class="ml-2">Verifikasi</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button type="submit" id="submitterBtn"
                        class="bg-accent-light-500 text-white px-4 py-2 rounded hidden"></button>
                    <button type="button" id="submitBtn"
                        class="bg-accent-light-500 text-white px-4 py-2 rounded hover:bg-accent-light-600">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-item');
            const contents = document.querySelectorAll('.tab-content');
            const underline = document.getElementById('underline');

            function setUnderline(target) {
                underline.style.width = `${target.offsetWidth}px`;
                underline.style.left = `${target.offsetLeft}px`;
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('font-bold', 'text-accent-600'));
                    contents.forEach(c => c.classList.add('hidden'));

                    this.classList.add('font-bold', 'text-accent-600');
                    document.getElementById(this.getAttribute('data-target')).classList.remove(
                        'hidden');
                    setUnderline(this);
                });
            });

            // Initial state
            tabs[0].classList.add('font-bold', 'text-accent-600');
            contents[0].classList.remove('hidden');
            setUnderline(tabs[0]);

            document.getElementById('submitBtn').addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah form langsung disubmit

                // Menampilkan konfirmasi SweetAlert2
                Swal.fire({
                    title: 'Yakin Mau Submit?',
                    text: "Pastikan data yang dimasukkan sudah benar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Submit!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna klik 'Ya, Submit!', form disubmit
                        submitterBtn.click();
                    }
                });
            });
        });
    </script>
@endpush
