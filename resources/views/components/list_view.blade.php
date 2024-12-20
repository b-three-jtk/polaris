<div class="list-view">
    @forelse($submissions as $p)
        <div data-aos="fade-up" class="flex flex-col md:flex-row items-center justify-between gap-5 mb-3 p-6 bg-primary-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col">
                <h5 class="mb-2 text-lg font-semibold tracking-tight text-gray-900 dark:text-white">{{ $p->submission_title }}</h5>
                <p class="mb-5 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $p->problem_description }}</p>
                <div class="flex justify-start">
                    <span class="bg-primary-800 opacity-85 text-white text-xs font-medium me-2 px-7 py-1 rounded-xl dark:bg-blue-900 dark:text-blue-300">{{ $p->platform }}</span>
                    <span class="bg-light-blue-400 mr-auto flex justify-center items-center opacity-85 text-white text-xs font-medium me-2 px-7 py-1 rounded-xl dark:bg-blue-900 dark:text-blue-300">
                        @if ($p->project_type == 1)
                            proyek yang sudah ada
                        @else
                            proyek baru
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="flex flex-col h-full justify-between">
                <a href="{{ route('submissions.show', ['submission_code' => $p->submission_code]) }}">
                    <button type="button" class="text-white bg-dark-800 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-12 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Detail</button>
                </a>
                <p class="text-xs text-end">{{ $p->created_at }}</p>
            </div>
        </div>
    @empty
        <div class="text-center py-20 bg-gray-100 rounded-lg">
            <p class="text-gray-500">Tidak ada data pengajuan yang ditemukan.</p>
        </div>
    @endforelse
</div>
