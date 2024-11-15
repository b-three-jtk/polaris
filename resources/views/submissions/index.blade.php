@extends('layouts.app')

@section('title', 'Daftar Pengajuan')

@section('content')
    <div class="w-full justify-center">
        <div class="bg-white">
            <div>
                {{-- buat mobile --}}
                <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
                    <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
                    <div class="fixed inset-0 z-40 flex">
                        <div
                            class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                            <div class="flex items-center justify-between px-4">
                                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                                <button type="button"
                                    class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400">
                                    <span class="sr-only">Close menu</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Filters -->
                            <form class="mt-4 border-t border-gray-200">
                                <h3 class="sr-only">Categories</h3>
                                <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                                    <li class="font-medium text-black">Tipe Proyek</li>
                                    <li>
                                        <button type="button" id="filter-existing" class="block px-2 py-3">Aplikasi yang
                                            sudah ada</button>
                                    </li>
                                    <li>
                                        <button type="button" id="filter-new" class="block px-2 py-3">Aplikasi
                                            baru</button>
                                    </li>
                                </ul>

                                <div class="border-t border-gray-200 px-4 py-6">
                                    <h3 class="-mx-2 -my-3 flow-root">
                                        <!-- Expand/collapse section button -->
                                        <button type="button"
                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-mobile-0" aria-expanded="true">
                                            <span class="font-medium text-gray-900">Platform</span>
                                            <span class="ml-6 flex items-center">
                                                <!-- Expand icon, show/hide based on section open state. -->
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true" data-slot="icon">
                                                    <path
                                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                </svg>
                                                <!-- Collapse icon, show/hide based on section open state. -->
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-mobile-0">
                                        <div class="space-y-6">
                                            <div class="flex items-center">
                                                <input id="filter-platform-web" name="platform[]" value="web"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-web"
                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Web</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-platform-multi" name="platform[]" value="multi-platform"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-multi"
                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Multi-Platform</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-platform-mobile" name="platform[]" value="mobile"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-mobile"
                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Mobile</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-platform-desktop" name="platform[]" value="desktop"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-desktop"
                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Desktop</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 px-4 py-6">
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-mob-1">
                                        <section class="section wrapper wrapper-section">
                                            <div class="container wrapper-column">
                                                <div class="form-group">
                                                    <span class="form-arrow"><i class="bx bx-chevron-down"></i></span>
                                                    <select name="organization" id="organization"
                                                        class="select_org_mob  rounded-xl text-sm">
                                                        <option disabled>Pilih Organisasi</option>
                                                        <option value="">Semua Organisasi</option>
                                                        @foreach ($organization as $o)
                                                            <option value="{{ $o->organization_code }}">
                                                                {{ $o->organization_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-7">
                    <div class="text-center mb-5 w-2xl">
                        <h1 data-aos="fade-up" class="font-semibold text-2xl">Butuh Aplikasi?</h1>
                        <h2 data-aos="fade-up" data-aos-duration="300" class="text-xl">Ajukan Kebutuhan Anda terkait
                            aplikasi di organisasi Anda di sini</h2>
                    </div>
                    <div class=" max-w-2xl mx-auto">
                        <label for="search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="search"
                                class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Cari Data Pengajuan" required />
                            <button type="button" id="search-button"
                                class="text-white absolute end-0 bottom-0 bg-secondary-900 hover:bg-primary-900 focus:ring-4 focus:outline-none focus:ring-primary-900 font-medium rounded-lg text-sm px-7 py-2.5 dark:bg-blue-600 dark:hover:bg-primary-900 dark:focus:ring-primary-900">Cari</button>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-10">
                        <h2 class="text-sm md:text-base"><span id="pengajuan-count">{{ $submission->count() }}</span>
                            Pengajuan ditampilkan</h2>

                        <div class="flex items-center">
                            <div class="relative inline-block text-left">
                                <div>
                                    <button type="button" id="sort-button" data-dropdown-toggle="dropdownHover"
                                        data-dropdown-trigger="hover"
                                        class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                        aria-expanded="false" aria-haspopup="true">
                                        Sort
                                        <svg class="-mr-1 ml-1 h-5 w-5 shrink-0 text-gray-400 group-hover:text-gray-500"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd"
                                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="absolute right-0 z-10 mt-2 w-44 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" id="dropdownHover" aria-orientation="vertical"
                                    aria-labelledby="menu-button" tabindex="-1">
                                    <div class="py-1" role="none" aria-labelledby="dropdownHoverButton">
                                        <button id="sort-by-submission_title-asc" href="#"
                                            class="block text-left px-4 py-2 text-xs font-medium text-gray-500 hover:text-gray-900"
                                            role="menuitem" tabindex="-1" id="menu-item-0">Judul Pengajuan
                                            (A-Z)</button>
                                        <button id="sort-by-submission_title-desc" href="#"
                                            class="block text-left px-4 py-2 text-xs font-medium text-gray-500 hover:text-gray-900"
                                            role="menuitem" tabindex="-1" id="menu-item-1">Judul Pengajuan
                                            (Z-A)</button>
                                        <button id="sort-by-created_at-desc" href="#"
                                            class="block px-4 py-2 text-xs text-gray-500 hover:text-gray-900"
                                            role="menuitem" tabindex="-1" id="menu-item-2">Terbaru</button>
                                    </div>
                                </div>
                            </div>

                            <div class="relative inline-block text-left ml-4">
                                <label for="perPageDropdown">Items per page:</label>
                                <select id="perPageDropdown" class="rounded bg-white p-2 ml-2">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                </select>
                            </div>

                            <button type="button" class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7">
                                <span class="sr-only">View grid</span>
                                <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor"
                                    data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9A2.25 2.25 0 0 0 11 4.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 11 13.25v2.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="button"
                                class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden">
                                <span class="sr-only">Filters</span>
                                <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor"
                                    data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <section aria-labelledby="products-heading" class="pb-24 pt-6">
                        <h2 id="products-heading" class="sr-only">Tipe Proyek</h2>

                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                            <!-- Filters -->
                            <form class="hidden lg:block">
                                <h3 class="sr-only">Categories</h3>
                                <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm text-gray-900">
                                    <li class="font-medium text-black">Tipe Proyek</li>
                                    <li>
                                        <button type="button" id="filter-existing">Aplikasi yang sudah ada</button>
                                    </li>
                                    <li>
                                        <button type="button" id="filter-new">Aplikasi baru</button>
                                    </li>
                                </ul>

                                <div class="border-b border-gray-200 py-6">
                                    <h3 class="-my-3 flow-root">
                                        <!-- Expand/collapse section button -->
                                        <button type="button"
                                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-0" aria-expanded="true">
                                            <span class="font-medium text-gray-900">Platform</span>
                                            <span class="ml-6 flex items-center">
                                                <!-- Expand icon, show/hide based on section open state. -->
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true" data-slot="icon">
                                                    <path
                                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                </svg>
                                                <!-- Collapse icon, show/hide based on section open state. -->
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-0">
                                        <div class="space-y-4">
                                            <div class="flex items-center">
                                                <input id="filter-platform-web" name="platform[]" value="web"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-web"
                                                    class="ml-3 text-sm text-gray-600">Web</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-platform-multi" name="platform[]"
                                                    value="multi-platform" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-multi"
                                                    class="ml-3 text-sm text-gray-600">Multi-Platform</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-platform-mobile" name="platform[]" value="mobile"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-mobile"
                                                    class="ml-3 text-sm text-gray-600">Mobile</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-platform-desktop" name="platform[]" value="desktop"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-accent-light-400 focus:ring-accent-light-500">
                                                <label for="filter-platform-mobile"
                                                    class="ml-3 text-sm text-gray-600">Desktop</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-b border-gray-200 py-6">
                                    <h3 class="-my-3 flow-root">
                                        <div class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-1" aria-expanded="false">
                                            <span class="font-medium text-gray-900">Organisasi</span>
                                        </div>
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-1">
                                        <section class="section wrapper wrapper-section">
                                            <div class="container wrapper-column">
                                                <div class="form-group">
                                                    <span class="form-arrow"><i class="bx bx-chevron-down"></i></span>
                                                    <select name="organization" id="organization"
                                                        class="select_org  rounded-xl text-xs">
                                                        <option disabled>Pilih Organisasi</option>
                                                        <option value="">Semua Organisasi</option>
                                                        @foreach ($organization as $o)
                                                            <option value="{{ $o->organization_code }}">
                                                                {{ $o->organization_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>

                            </form>

                            <!-- Product grid -->
                            <div class="lg:col-span-3">

                                <div id="search-results" class="list-view">
                                    @if ($submission->count() == 0)
                                        <div class="text-center py-20 bg-gray-100 rounded-lg">
                                            <p class="text-gray-500">Tidak ada data pengajuan yang ditemukan.</p>
                                        </div>
                                    @else
                                        @include('components.list_view', ['pengajuan' => $submission])
                                    @endif
                                </div>
                                <div class="mb-10 flex justify-center items-center mx-auto mt-10" data-aos="fade-up"
                                    data-aos-duration="700">
                                    {!! $submission->appends(['sort_by' => request('sort_by')])->links('vendor.pagination.custom') !!}
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
    <script type="module">
        $(document).ready(function() {
            $(".select_org").select2();
            $(".select_org_mob").select2();

            const $searchResults = $('#search-results');
            const $pengajuanCount = $('#pengajuan-count');
            const $searchInput = $('#search');
            const $searchButton = $('#search-button');
            const $perPageDropdown = $('#perPageDropdown');
            let filterExisting = null;
            const initialHtml = $searchResults.html();
            const initialCount = $pengajuanCount.text();
            const toggleButton = document.querySelector('button[aria-controls="filter-section-0"]');
            const toggleButtonMob = document.querySelector('button[aria-controls="filter-section-mobile-0"]');
            const filterSection = document.getElementById('filter-section-0');
            const filterSectionMob = document.getElementById('filter-section-mobile-0');
            const icons = toggleButton.querySelectorAll('svg[data-slot="icon"]');
            let selectedOrganization = null;

            toggleButton.addEventListener('click', () => {
                const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
                toggleButton.setAttribute('aria-expanded', !isExpanded);

                filterSection.style.display = isExpanded ? 'none' : 'block';

                icons.forEach(icon => icon.classList.toggle('hidden'));
            });

            toggleButtonMob.addEventListener('click', () => {
                const isExpandedMob = toggleButtonMob.getAttribute('aria-expanded') === 'true';
                toggleButtonMob.setAttribute('aria-expanded', !isExpandedMob);

                filterSectionMob.style.display = isExpandedMob ? 'none' : 'block';

                icons.forEach(icon => icon.classList.toggle('hidden'));
            });

            // Initialize as expanded (visible)
            filterSection.style.display = 'block';
            icons[0].classList.add('hidden'); // Hide expand icon initially

            filterSectionMob.style.display = 'block';
            icons[0].classList.add('hidden'); // Hide expand icon initially

            const resetSearch = () => {
                $searchResults.html(initialHtml);
                $pengajuanCount.text(initialCount);
            };

            const performSearchOrSort = (sortBy = null, sortDirection = null) => {
                const query = $searchInput.val().trim();
                let platform = [];
                const perPage = $perPageDropdown.val();

                // Ambil nilai checkbox platform yang dicentang
                $('input[name="platform[]"]:checked').each(function() {
                    platform.push($(this).val());
                });

                if (!query && !sortBy && filterExisting === null && platform.length === 0 && !
                    selectedOrganization) {
                    resetSearch();
                    return;
                }

                const requestData = {
                    'search': query,
                    'platform': platform,
                    'per_page': perPage
                };
                if (sortBy && sortDirection) {
                    requestData.sort_by = sortBy;
                    requestData.sort_direction = sortDirection;
                }
                if (filterExisting !== null) {
                    requestData.existing_app = filterExisting; // Tambahkan filter sebagai boolean
                }
                if (selectedOrganization) {
                    requestData.organization = selectedOrganization;
                }

                $.ajax({
                    url: "{{ route('submissions.search') }}",
                    type: "GET",
                    data: requestData,
                    success: (data) => {
                        $searchResults.html(data.html);
                        $pengajuanCount.text(data.count);
                        if (sortBy && sortDirection) {
                            window.history.pushState("", "",
                                `?search=${query}&sort_by=${sortBy}&existing_app=${filterExisting}&platform=${platform.join(',')}&organization=${selectedOrganization}&perPage=${perPage}`
                            );
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        console.error("AJAX error: ", textStatus, errorThrown);
                    }
                });
            };

            $searchButton.on('click', () => performSearchOrSort());
            $searchInput.on('input', () => {
                if (!$searchInput.val().trim()) resetSearch();
            });
            $searchInput.on('keypress', (e) => {
                if (e.which == 13) performSearchOrSort();
            });

            $('input[name="platform[]"]').on('change', () => performSearchOrSort());

            $('#sort-by-submission_title-asc, #sort-by-submission_title-desc, #sort-by-created_at-desc').on('click',
                (e) => {
                    const [sortBy, sortDirection] = e.currentTarget.id.split('-').slice(2);
                    performSearchOrSort(sortBy, sortDirection);
                });

            $perPageDropdown.on('change', () => {
                performSearchOrSort();
            });

            // Event handler untuk tombol filter
            $('#filter-existing').on('click', () => {
                filterExisting = true;
                performSearchOrSort();
            });
            $('#filter-new').on('click', () => {
                filterExisting = false;
                performSearchOrSort();
            });
            $('#organization').on('change', function() {
                selectedOrganization = $(this).val(); // Set nilai organisasi yang dipilih
                performSearchOrSort();
            });
        });
    </script>
@endsection
