<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">Adoption Request Detail</h2>
            <p class="text-sm text-gray-500 mt-1">Read-only view of this adoption request.</p>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                @if ($adoption->cat && $adoption->cat->photo)
                    <img src="{{ str_starts_with($adoption->cat->photo, 'http') ? $adoption->cat->photo : Storage::url($adoption->cat->photo) }}" class="h-16 w-16 rounded-lg object-cover">
                @else
                    <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300 text-xs">No Photo</div>
                @endif
                <div>
                    <div class="font-semibold text-gray-800">{{ $adoption->cat->name ?? '-' }}</div>
                    <div class="text-xs text-gray-500">{{ $adoption->cat->breed ?? '-' }}</div>
                </div>
                <span class="ml-auto px-2 py-0.5 rounded-full text-xs font-semibold
                    {{ match($adoption->status) {
                        'approved' => 'bg-emerald-100 text-emerald-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-amber-100 text-amber-700',
                    } }}">
                    {{ strtoupper($adoption->status) }}
                </span>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Adopter Name</label>
                <p class="text-sm text-gray-800">{{ $adoption->adopter_name }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Phone Number</label>
                <p class="text-sm text-gray-800">{{ $adoption->adopter_phone }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Address</label>
                <p class="text-sm text-gray-800">{{ $adoption->adopter_address ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Notes</label>
                <p class="text-sm text-gray-800">{{ $adoption->notes ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Submitted On</label>
                <p class="text-sm text-gray-800">{{ $adoption->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                <a href="{{ route('adoptions.index') }}" class="px-5 py-2 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
