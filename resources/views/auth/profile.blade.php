@extends('layouts.dashboard')

@section('title', 'Profil Pengguna')

@section('content')
<div class="bg-white dark:bg-gray-900">
    <div class="container py-12 md:mx-auto lg:px-20">
        <h2 class="text-2xl font-bold text-black-800 mb-6">Pengaturan <span class="text-accent-600">Akun</span></h2>
        @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="mt-8 xl:mt-16 lg:flex lg:-mx-12">
            <!-- Left Column: Tabs -->
            <div class="lg:w-1/4 ml-12">
                <div class="space-y-4">
                    <a href="#" data-tab="profile" class="tab-link block text-xl font-semibold text-gray-800 dark:text-white py-5 px-4 shadow-md rounded-full">Profil Saya</a>
                    @if (auth()->user()->role == 1)
                    <a href="#" data-tab="organisasi" class="tab-link block text-xl font-semibold text-gray-800 dark:text-white py-5 px-4 shadow-md rounded-full">Organisasi</a>        
                    @endif
                </div>
            </div>

            <!-- Right Column: Tab Content -->
            <div class="lg:w-3/4 ml-16">
                <!-- General Content -->
                <form method="POST" action="{{ route('user.update', ['user' => $user]) }}" id="profile" class="tab-content" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h2 class="text-2xl font-bold text-black-800 mb-6">Profil <span class="text-accent-600">Saya</span></h2>

                    <div class="bg-white rounded-lg shadow-lg px-10 py-6">                
                        <div class="flex items-center gap-5">
                            <div class="w-28 h-28 bg-primary-800 rounded-full overflow-hidden">
                                <img id="avatar-preview" 
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/profile.png') }}" 
                                    alt="Profile Picture" 
                                    class="rounded-full w-full h-full object-cover border-2 border-gray-200" />
                            </div>
                            <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewAvatar(event)">
                            <label for="avatar" class="bg-white border-2 border-gray-200 text-black font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 cursor-pointer mb-2">
                                Ubah foto
                            </label>
                        </div>                        
                    </div>
                
                    <div class="bg-white p-10 rounded-lg shadow-md">
                        <div class="grid gap-4">
                            <p class="text-black-600 font-bold">Nama Lengkap</p>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="rounded-lg border-2 border-gray-300 py-4">
                            <p class="text-black-600 font-bold">Email</p>
                            <input type="text" name="email" id="email" value="{{ old('email', $user->email) }}" class="rounded-lg border-2 border-gray-300 py-4" disabled>
                            @if (auth()->user()->role == 1)
                                <p class="text-black-600 font-bold">Jabatan</p>
                                <input type="text" name="position_in_organization" id="position_in_organization" value="{{ old('position_in_organization', $user->submitter->position_in_organization) }}" required class="rounded-lg border-2 border-gray-300 py-4">
                            @endif
                            <p class="text-black-600 font-bold">Nomor Telepon</p>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="rounded-lg border-2 border-gray-300 py-4">
                        </div>
                    </div>
                        <button class="bg-primary-700 text-white font-semibold ml-auto mt-5 px-4 py-2 rounded-lg hover:bg-primary-600 mb-2">
                            Simpan Perubahan
                        </button>
                </form>
                @if (auth()->user()->role == 1)
                <!-- Trust & Safety Content -->
                    <form method="POST" action="{{ route('organization.update', ['organization' => $user->submitter->organization]) }}" id="organisasi" class="tab-content hidden" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h2 class="text-2xl font-bold text-black-800 mb-6">Organisasi <span class="text-accent-600">Saya</span></h2>

                        <div class="bg-white rounded-lg shadow-lg p-4">                
                            <div class="rounded-lg px-10 pt-10 pb-4 space-y-3 flex flex-col">
                                <p class="text-black-600 font-bold">Logo Organisasi</p>
                                <!-- Profile Image -->
                                <div class="flex items-center gap-5">
                                    <div class="w-28 h-28 bg-primary-800 rounded-full overflow-hidden">
                                        <img id="logo-preview" 
                                            src="{{ $user->submitter->organization->logo ? asset('storage/' . $user->submitter->organization->logo) : asset('images/profile.png') }}" 
                                            alt="Profile Picture" 
                                            class="rounded-full w-full h-full object-cover border-2 border-gray-200" />
                                    </div>
                                    <input type="file" name="logo" id="logo" class="hidden" onchange="previewLogo(event)">
                                    <label for="logo" class="bg-white border-2 border-gray-200 text-black font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 cursor-pointer mb-2">
                                        Ubah foto
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                        <div class="bg-white p-10 rounded-lg shadow-md">
                            <div class="grid gap-4">
                                <p class="text-black-600 font-bold">Nama</p>
                                <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name', $user->submitter->organization->organization_name) }}" required class="rounded-lg border-2 border-gray-300 py-4">
                                <p class="text-black-600 font-bold">Deskripsi Perusahaan</p>
                                <textarea type="text" name="company_description" id="company_description" value="{{ old('company_description', $user->submitter->organization->company_description) }}" class="rounded-lg border-2 border-gray-300 py-4">{{ $user->submitter->organization->company_description }}</textarea>
                                <p class="text-black-600 font-bold">Bidang Usaha</p>
                                <input type="text" name="business_field" id="business_field" value="{{ old('business_field', $user->submitter->organization->business_field) }}" class="rounded-lg border-2 border-gray-300 py-4">
                                <p class="text-black-600 font-bold">Alamat</p>
                                <input type="text" name="address" id="address" value="{{ old('address', $user->submitter->organization->address) }}" class="rounded-lg border-2 border-gray-300 py-4">
                                <p class="text-black-600 font-bold">Website Resmi</p>
                                <input type="text" name="website" id="website" value="{{ old('website', $user->submitter->organization->website ) }}" class="rounded-lg border-2 border-gray-300 py-4">
                            </div>
                        </div>
                            <button class="bg-primary-700 text-white font-semibold ml-auto mt-5 px-4 py-2 rounded-lg hover:bg-primary-600 mb-2">
                                Simpan Perubahan
                            </button>
                    </form>
                @endif

                <!-- Service Content -->
                <div id="settings" class="tab-content hidden">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Services</h2>
                    <p class="text-gray-500 dark:text-gray-300 mt-4">Here are some of the most common questions in the Services category.</p>
                    <hr class="my-4 border-gray-200 dark:border-gray-700">

                    <!-- FAQ Items for Service -->
                    <div class="space-y-8">
                        <!-- Service Item 1 -->
                        <div class="relative w-[800px]">
                            <input type="checkbox" id="s1" class="absolute opacity-0 peer">
                            <label for="s1" class="flex items-center cursor-pointer">
                                <span class="material-symbols-outlined text-blue-500 pr-2 icon-rotate">arrow_forward_ios</span>
                                <span class="text-xl text-gray-700 dark:text-white">Is my information secure?</span>
                            </label>
                            <div class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out peer-checked:max-h-[200px]">
                                <p class="px-4 mt-2 text-gray-500 dark:text-gray-300">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, eum quae. Harum officiis reprehenderit ex quia ducimus minima id provident molestias optio nam vel, quidem iure voluptatem, repellat et ipsa.
                                </p>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        <!-- Service Item 2 -->
                        <div class="relative w-[800px]">
                            <input type="checkbox" id="s2" class="absolute opacity-0 peer">
                            <label for="s2" class="flex items-center cursor-pointer">
                                <span class="material-symbols-outlined text-blue-500 pr-2 icon-rotate">arrow_forward_ios</span>
                                <span class="text-xl text-gray-700 dark:text-white">What can i expect at my first consultation ?</span>
                            </label>
                            <div class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out peer-checked:max-h-[200px]">
                                <p class="px-4 mt-2 text-gray-500 dark:text-gray-300">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, eum quae. Harum officiis reprehenderit ex quia ducimus minima id provident molestias optio nam vel, quidem iure voluptatem, repellat et ipsa.
                                </p>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        <!-- Service Item 3 -->
                        <div class="relative w-[800px]">
                            <input type="checkbox" id="s3" class="absolute opacity-0 peer">
                            <label for="s3" class="flex items-center cursor-pointer">
                                <span class="material-symbols-outlined text-blue-500 pr-2 icon-rotate">arrow_forward_ios</span>
                                <span class="text-xl text-gray-700 dark:text-white">What are your opening house ?</span>
                            </label>
                            <div class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out peer-checked:max-h-[200px]">
                                <p class="px-4 mt-2 text-gray-500 dark:text-gray-300">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, eum quae. Harum officiis reprehenderit ex quia ducimus minima id provident molestias optio nam vel, quidem iure voluptatem, repellat et ipsa.
                                </p>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        <!-- Service Item 4 -->
                        <div class="relative w-[800px]">
                            <input type="checkbox" id="s4" class="absolute opacity-0 peer">
                            <label for="s4" class="flex items-center cursor-pointer">
                                <span class="material-symbols-outlined text-blue-500 pr-2 icon-rotate">arrow_forward_ios</span>
                                <span class="text-xl text-gray-700 dark:text-white">Do i need a referral ?</span>
                            </label>
                            <div class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out peer-checked:max-h-[200px]">
                                <p class="px-4 mt-2 text-gray-500 dark:text-gray-300">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, eum quae. Harum officiis reprehenderit ex quia ducimus minima id provident molestias optio nam vel, quidem iure voluptatem, repellat et ipsa.
                                </p>
                            </div>
                        </div>

                            <hr class="my-8 border-gray-200 dark:border-gray-700">

                        <!-- Service Item 5 -->
                        <div class="relative w-[800px]">
                            <input type="checkbox" id="s5" class="absolute opacity-0 peer">
                            <label for="s5" class="flex items-center cursor-pointer">
                                <span class="material-symbols-outlined text-blue-500 pr-2 icon-rotate">arrow_forward_ios</span>
                                <span class="text-xl text-gray-700 dark:text-white">Is the cost of the appoinment covered by private health insurance ?</span>
                            </label>
                            <div class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out peer-checked:max-h-[200px]">
                                <p class="px-4 mt-2 text-gray-500 dark:text-gray-300">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, eum quae. Harum officiis reprehenderit ex quia ducimus minima id provident molestias optio nam vel, quidem iure voluptatem, repellat et ipsa.
                                </p>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const tabLinks = document.querySelectorAll(".tab-link");
        const tabContents = document.querySelectorAll(".tab-content");
    
        tabLinks.forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const targetId = link.getAttribute("data-tab");
    
                // Hide all tab content sections
                tabContents.forEach(content => content.classList.add("hidden"));
    
                // Show the selected tab content
                document.getElementById(targetId).classList.remove("hidden");
    
                // Update active link styling
                tabLinks.forEach(link => link.classList.remove("text-blue-500"));
                link.classList.add("text-blue-500");
            });
        });
    });
    function previewAvatar(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('avatar-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result; // Set preview image source
            };
            reader.readAsDataURL(file); // Read file as data URL
        }
    }

    function previewLogo(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logo-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result; // Set preview image source
            };
            reader.readAsDataURL(file); // Read file as data URL
        }
    }
    </script>
@endpush