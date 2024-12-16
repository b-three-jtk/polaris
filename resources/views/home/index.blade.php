@extends('layouts.app')

@section('title', 'Polaris | Portal Layanan Ajuan Aplikasi SAtu Pintu')

@section('content')
    <div class="flex flex-col justify-center items-center mb-10">
        <div class="p-16 pb-3">
            <div class="ornament absolute -left-1/4 md:left-0 top-32 -z-10"><img
                    src="{{ asset('images/ornament_landing_1.svg') }}" alt=""></div>
            <h1 data-aos="fade-up" class="text-center text-3xl md:text-4xl max-w-[650px]">Bring <span class="font-semibold">
                    Project Based Learning  </span>to the
                <span class="text-accent-600 font-semibold">#NextLevel</span>
            </h1>
        </div>
        <div class="p-10">
            <div class="ornament absolute -right-1/4 md:right-0 top-1/2 md:top-72 -z-10"><img
                    src="{{ asset('images/ornament_landing_2.svg') }}" alt=""></div>
            <div class="flex gap-2 flex-col md:flex-row">
                <a href="{{ route('submissions.create') }}" class="rounded-lg bg-primary-900 text-white px-5 py-3">Ajukan
                    Sekarang</a>
                <a href="{{ route('submissions.index') }}" class="rounded-lg bg-gray-300 text-black px-5 py-3">Lihat Daftar
                    Ajuan</a>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-5 md:items-end">
            <div data-aos="fade-right" class="h-64 md:h-96 md:w-56 rounded-2xl overflow-hidden relative group">
                <h1 class="absolute inset-0 flex justify-end items-end text-white text-md p-5 z-20">
                    Platform Terintegrasi untuk Mendukung Project Based Learning di Lingkungan Kampus
                </h1>
                <div class="w-full h-full inset-0 bg-custom-gradient rounded-md absolute z-10"></div>
                <img class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110 z-0"
                    src="{{ asset('images/Landing-2.svg') }}" alt="">
            </div>
            <div data-aos="fade-right" class="md:h-60 md:w-56 bg-light-blue-400 p-5 rounded-2xl">
                <h1 class="text-xl font-semibold text-white text-center md:text-left font-manrope">Transformasi Digital
                    <br>Polban</h1>
            </div>
            <div class="md:h-36 md:w-56 bg-white border-gray-300 border-2 rounded-2xl p-5">

                <ul class="avatars flex list-none mx-auto">
                    <li
                        class="avatars_item shadow-md rounded-full block h-[45px] w-[45px] leading-[45px] transition-all duration-100 ease-in-out overflow-hidden first:z-5 nth-child-2:z-4 nth-child-3:z-3 nth-child-4:z-2 nth-child-5:z-1 last:z-0">
                        <img src="https://images.unsplash.com/photo-1506863530036-1efeddceb993?q=80&w=1944&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            class="w-full h-full object-cover rounded-full" alt="Avatar">
                    </li>
                    <li
                        class="avatars_item shadow-md rounded-full block h-[45px] w-[45px] leading-[45px] transition-all duration-100 ease-in-out overflow-hidden -ml-[10px] first:z-5 nth-child-2:z-4 nth-child-3:z-3 nth-child-4:z-2 nth-child-5:z-1 last:z-0">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fHByb2ZpbGV8ZW58MHx8MHx8fDA%3D"
                            class="w-full h-full object-cover rounded-full" alt="Avatar">
                    </li>
                    <li
                        class="avatars_item shadow-md rounded-full block h-[45px] w-[45px] leading-[45px] transition-all duration-100 ease-in-out overflow-hidden -ml-[10px] first:z-5 nth-child-2:z-4 nth-child-3:z-3 nth-child-4:z-2 nth-child-5:z-1 last:z-0">
                        <img src="https://images.unsplash.com/photo-1600180758890-6b94519a8ba6?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            class="w-full h-full object-cover rounded-full" alt="Avatar">
                    </li>
                    <li
                        class="avatars_item bg-gray-200 text-center rounded-full block h-[45px] w-[45px] leading-[45px] transition-all duration-100 ease-in-out overflow-hidden -ml-[10px] first:z-5 nth-child-2:z-4 nth-child-3:z-3 nth-child-4:z-2 nth-child-5:z-1 last:z-0">
                        <p class="font-semibold">+1</p>
                    </li>
                </ul>
                <h1 class="font-semibold text-2xl mt-2">{{ $count_pengajuan }}+</h1>
                <h1 class="text-lg">Total Pengajuan</h1>
            </div>
            <div data-aos="fade-left" class="h-52 md:h-60 md:w-56 rounded-2xl overflow-hidden relative group">
                <div class="absolute inset-0 flex flex-col justify-center items-center z-20 p-5 text-center">
                    <h1 class="text-xl text-white font-semibold">Tidak tahu mau apa?<br><br></h1>
                    <a href="{{ route('home.help') }}" class="text-base text-white ">Pelajari tata cara pengajuan kebutuhan aplikasi <span
                            class="underline">di sini</span></a>
                </div>
                <div class="w-full h-full inset-0 bg-accent-600 opacity-65 rounded-md absolute z-10"></div>
                <img class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-125 z-0"
                    src="{{ asset('images/Landing-1.svg') }}" alt="">
            </div>

            <div data-aos="fade-left"
                class="h-64 md:h-96 md:w-56 rounded-2xl flex flex-col justify-between bg-secondary-900 p-5">
                <div class="">
                    @if ($newest_pengajuan)
                    <h1 class="text-white">{{ $newest_pengajuan->submission_title }}</h1>
                    <h3 class="text-white mt-2 items-center flex"><span class="material-symbols-outlined">
                            schedule
                        </span><span class="text-xs ml-1 font-normal">{{ $time_ago }}</span></h3>
                    @else
                    <h1 class="text-white">Ajukan Aplikasi Sekarang!</h1>
                    @endif
                </div>

                <div>
                    <hr class="h-[0.2px] border-t-0 bg-white dark:bg-white/10" />
                    @if ($newest_pengajuan)
                    <a href="{{ route('submissions.show', ['submission_code' => $newest_pengajuan->submission_code]) }}"
                        class="text-white text-sm flex justify-between mt-2 transform transition-transform duration-300 hover:scale-105 hover:text-light-blue-200">
                        Pelajari lebih lanjut
                        <span
                            class="material-symbols-outlined text-lg transform transition-transform duration-300 hover:translate-x-1 hover:scale-110">
                            arrow_outward
                        </span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
