@if($selectedCat)

<div class="bg-white rounded-2xl shadow-sm border flex-1">

    {{-- Header --}}
    <div class="relative">

        <div class="h-64 bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">

            @if($selectedCat->photo)

                <img
                    src="{{ $selectedCat->photo_url }}"
                    alt="{{ $selectedCat->name }}"
                    class="w-full h-full object-cover">

            @else

                <div class="text-8xl">
                    🐱
                </div>

            @endif

        </div>

        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">

            <h2 class="text-3xl font-bold text-white">

                {{ $selectedCat->name }}

            </h2>

            <p class="text-emerald-100 text-sm">

                REF #CAT{{ str_pad($selectedCat->id,4,'0',STR_PAD_LEFT) }}

            </p>

        </div>

    </div>

    {{-- Body --}}
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">

            <h3 class="font-bold text-gray-800">

                Cat Information

            </h3>

            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                {{ match($selectedCat->status) {
                    'ready_for_adoption' => 'bg-emerald-100 text-emerald-700',
                    'rescued' => 'bg-amber-100 text-amber-700',
                    'in_treatment' => 'bg-red-100 text-red-700',
                    'adopted' => 'bg-blue-100 text-blue-700',
                    default => 'bg-gray-100 text-gray-600',
                } }}">
                {{ strtoupper(str_replace('_', ' ', $selectedCat->status)) }}
            </span>

        </div>

        <div class="grid grid-cols-2 gap-5">

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Breed
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $selectedCat->breed ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Age
                </p>

                <p class="font-semibold">
                    {{ $selectedCat->age_estimate ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Gender
                </p>

                <p class="font-semibold">
                    {{ ucfirst($selectedCat->gender) }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Weight
                </p>

                <p class="font-semibold">

                    {{ $latestRecord->weight ?? '-' }}

                    @if(!empty($latestRecord->weight))
                        kg
                    @endif

                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Color
                </p>

                <p class="font-semibold">
                    {{ $selectedCat->color ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Rescue ID
                </p>

                <p class="font-semibold">
                    CAT-{{ str_pad($selectedCat->id,4,'0',STR_PAD_LEFT) }}
                </p>
            </div>

        </div>

        <hr class="my-6">

        <div>

            <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">

                Rescue Location

            </p>

            <p class="font-medium text-gray-700">

                {{ $selectedCat->rescue_location ?? '-' }}

            </p>

        </div>

    </div>

</div>

@else

<div class="bg-white rounded-2xl shadow border p-12 text-center">

    <div class="text-7xl">

        🐱

    </div>

    <h2 class="mt-4 text-2xl font-bold">

        No Cat Selected

    </h2>

    <p class="mt-2 text-gray-500">

        Please choose a cat from the left panel.

    </p>

</div>

@endif
