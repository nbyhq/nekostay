<div class="bg-white rounded-2xl shadow-sm border border-gray-200 h-[calc(100vh-180px)] flex flex-col">
    <!-- Header -->
    <div class="p-5 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">
            Cats
        </h2>
        <div class="relative mt-4">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                id="searchCat"
                type="text"
                placeholder="Search cat..."
                class="w-full rounded-full border border-gray-200 pl-12 pr-4 py-3 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
    </div>

    <!-- List -->
    <div id="catList" class="flex-1 overflow-y-auto divide-y divide-gray-100">
        @forelse($cats as $cat)
            <a href="{{ route('medical-records.index',['cat'=>$cat->id]) }}"
                class="cat-item block"
                data-name="{{ strtolower($cat->name) }}"
                data-breed="{{ strtolower($cat->breed) }}">
                <div class="transition-colors duration-150 hover:bg-gray-50 px-5 py-4
                    {{ optional($selectedCat)->id == $cat->id
                        ? 'bg-emerald-50 border-l-4 border-emerald-600'
                        : 'border-l-4 border-transparent' }}">
                    <div class="flex items-center gap-3">
                        @if($cat->photo)
                            <img
                                src="{{ str_starts_with($cat->photo, 'http') ? $cat->photo : asset('storage/'.$cat->photo) }}"
                                class="w-12 h-12 rounded-full object-cover border border-gray-100 shrink-0" loading="lazy">
                        @else
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-xl shrink-0">
                                🐱
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-semibold text-gray-800 truncate text-sm">
                                    {{ $cat->name }}
                                </h3>
                                <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-semibold
                                    {{ match($cat->status) {
                                        'ready_for_adoption' => 'bg-emerald-100 text-emerald-700',
                                        'in_treatment' => 'bg-red-100 text-red-700',
                                        'adopted' => 'bg-blue-100 text-blue-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    } }}">
                                    {{ strtoupper(str_replace('_', ' ', $cat->status)) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 truncate mt-0.5">
                                {{ $cat->breed }}
                            </p>
                            <div class="mt-1 flex items-center gap-1.5 text-[11px] text-gray-400">
                                <span>{{ ucfirst($cat->gender) }}</span>
                                <span>•</span>
                                <span>{{ $cat->age_estimate }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">
                Belum ada data kucing.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($cats->hasPages())
        <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 text-xs">
            @if ($cats->onFirstPage())
                <span class="text-gray-300 font-medium">‹ Previous</span>
            @else
                <a href="{{ $cats->previousPageUrl() }}" class="text-emerald-700 font-medium hover:underline">‹ Previous</a>
            @endif

            <span class="text-gray-400">Page {{ $cats->currentPage() }} of {{ $cats->lastPage() }}</span>

            @if ($cats->hasMorePages())
                <a href="{{ $cats->nextPageUrl() }}" class="text-emerald-700 font-medium hover:underline">Next ›</a>
            @else
                <span class="text-gray-300 font-medium">Next ›</span>
            @endif
        </div>
    @endif
</div>

@push('scripts')
<script>
const searchInput = document.getElementById('searchCat');
const cats = document.querySelectorAll('.cat-item');
searchInput.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    cats.forEach(cat => {
        const name = cat.dataset.name;
        const breed = cat.dataset.breed;
        if (name.includes(keyword) || breed.includes(keyword)) {
            cat.style.display = '';
        } else {
            cat.style.display = 'none';
        }
    });
});
</script>
@endpush
