<div class="bg-white rounded-2xl shadow-sm border border-gray-200 h-[calc(100vh-180px)] flex flex-col">

    <!-- Header -->
    <div class="p-5 border-b border-gray-100">

        <h2 class="text-xl font-bold text-gray-800">
            Cats
        </h2>

        <div class="relative mt-4">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
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
                class="w-full rounded-xl border-gray-300 pl-10 pr-4 py-2 focus:ring-emerald-500 focus:border-emerald-500">

        </div>

    </div>

    <!-- List -->
    <div id="catList" class="flex-1 overflow-y-auto">

        @foreach($cats as $cat)

        <a href="{{ route('medical-records.index',['cat'=>$cat->id]) }}"
            class="cat-item block"
            data-name="{{ strtolower($cat->name) }}"
            data-breed="{{ strtolower($cat->breed) }}">

            <div class="transition-all duration-200 hover:bg-gray-50 p-4 border-b border-gray-100

                {{ optional($selectedCat)->id == $cat->id
                    ? 'bg-emerald-50 border-l-4 border-emerald-600'
                    : '' }}">

                <div class="flex items-center gap-4">

                    @if($cat->photo)

                        <img
                            src="{{ str_starts_with($cat->photo, 'http') ? $cat->photo : asset('storage/'.$cat->photo) }}"
                            class="w-14 h-14 rounded-full object-cover border" loading="lazy">

                    @else

                        <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center text-2xl">

                            🐱

                        </div>

                    @endif

                    <div class="flex-1 min-w-0">

                        <h3 class="font-semibold text-gray-800 truncate">
                            {{ $cat->name }}
                        </h3>

                        <p class="text-sm text-gray-500 truncate">
                            {{ $cat->breed }}
                        </p>

                        <div class="mt-1 flex items-center gap-2 text-xs text-gray-400">

                            <span>
                                {{ ucfirst($cat->gender) }}
                            </span>

                            <span>•</span>

                            <span>
                                {{ $cat->age_estimate }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </a>

        @endforeach

    </div>

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
