<nav class="sticky border-gray-200 py-3 dark:bg-gray-900 px-10">
    <div class="flex items-center justify-between w-full">
        <!-- Navbar Links -->
        <div class="flex items-center justify-center space-x-8">
            <div class="pl-2">
                <a href="{{ route('home') }}">
                    <span class="text-2xl material-symbols-outlined">
                        arrow_back
                        </span>
                </a>
            </div>
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img class="max-h-12" src="{{ asset('images/Logo.png') }}" alt="Logo">
            </a>
            
            <!-- Navbar Links -->
            <ul class="hidden md:flex items-center font-medium space-x-8">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? 'border-b-2 border-accent-light-500 font-bold' : 'text-gray-900' }} block py-2 px-3 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-secondary-900 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.submissions.index') }}" class="{{ Route::is('dashboard.submissions.index') ? 'border-b-2 border-accent-light-500 font-bold' : 'text-gray-900' }} block py-2 px-3 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-secondary-900 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                        Pengajuan
                    </a>
                </li>
                @if (auth()->user()->role != 1)
                <li>
                    <a href="{{ route('organization.index') }}" class="{{ Route::is('organization.index') ? 'border-b-2 border-accent-light-500 font-bold' : 'text-gray-900' }} block py-2 px-3 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-secondary-900 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                        Mitra
                    </a>
                </li>
                @endif
                @if (auth()->user()->role == 2)
                <li>
                <a href="{{ route('admin.index') }}"
                        class="{{ Route::is('admin.index') ? 'block py-2 px-3 md:p-0 border-b-2 border-accent-light-500 font-bold' : 'block py-2 px-3 md:p-0 text-gray-900' }} hover:bg-gray-100 md:hover:bg-transparent md:hover:text-secondary-900 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Admin</a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Kanan: Notifikasi dan User Avatar -->
        <div class="flex items-center space-x-6">
            <!-- Notifikasi Icon -->
            <div class="relative">
                <button id="notificationButton" data-dropdown-toggle="notificationDropdown" class="w-10 h-10 flex items-center justify-center text-gray-500 dark:text-gray-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a7.002 7.002 0 00-5-6.708V4a2 2 0 10-4 0v.292A7.002 7.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.437L2 17h5m5 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <!-- Jumlah Notifikasi -->
                    @php
                        $unreadCount = Auth::user()->notification()->where('isRead', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                        {{ $unreadCount }}
                    </span>
                    @endif

                </button>
                
                <!-- Dropdown Notifikasi -->
                <div id="notificationDropdown" class="z-10 bg-white hidden divide-y divide-gray-100 rounded-lg shadow-lg w-80 dark:bg-gray-700">
                    <div class="px-4 py-3 text-gray-900 dark:text-white">
                        <span class="font-bold">Notifikasi Terbaru</span>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        @forelse ($notifications->take(5) as $notification)
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                {{ $notification->message }}
                            </a>
                        </li>
                        @empty
                        <li class="px-4 py-2 text-gray-500 dark:text-gray-400">Tidak ada notifikasi.</li>
                        @endforelse
                    </ul>
                    <div class="px-4 py-2 border-t dark:border-gray-600">
                        <a href="{{ route('notifications') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500">Notifikasi Lainnya</a>
                    </div>
                </div>
            </div>

            <!-- User Avatar and Dropdown -->
            <div class="relative">
                <img id="avatarButton" data-dropdown-toggle="userDropdown" class="w-10 h-10 rounded-lg cursor-pointer object-cover" src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/Avatar.svg') }}" alt="User dropdown">
                
                <!-- Dropdown User -->
                <div id="userDropdown" class="z-10 hidden divide-y bg-white divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li>
                            <a href="{{ route('user.show', ['user' => auth()->user()]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
