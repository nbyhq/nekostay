<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">Adoption Request Detail</h2>
            </div>
            <a href="{{ route('adoptions.index') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-700 transition">
                &larr; Back to list
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Adopter Info -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-gray-800 text-lg">Adopter Information</h3>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ match($adoption->status) {
                        'approved' => 'bg-emerald-100 text-emerald-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-amber-100 text-amber-700',
                    } }}">
                    {{ strtoupper($adoption->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-400">Full Name</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ $adoption->adopter_name }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-400">Phone Number</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ $adoption->adopter_phone }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs uppercase tracking-wide text-gray-400">Address</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $adoption->adopter_address ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs uppercase tracking-wide text-gray-400">Notes</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $adoption->notes ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-400">Submitted On</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $adoption->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-400">Last Updated</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $adoption->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center gap-3">
                <a href="{{ route('adoptions.edit', $adoption) }}" class="text-sm font-medium text-gray-600 hover:text-emerald-700 transition">
                    Edit Request
                </a>
                @role('admin')
                    @if ($adoption->status === 'pending')
                        <form action="{{ route('adoptions.updateStatus', $adoption) }}" method="POST" onsubmit="return confirm('Setujui permohonan adopsi ini? Status kucing akan berubah menjadi Adopted.');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="text-sm font-medium text-emerald-700 hover:underline">Approve</button>
                        </form>
                        <form action="{{ route('adoptions.updateStatus', $adoption) }}" method="POST" onsubmit="return confirm('Tolak permohonan adopsi ini?');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Reject</button>
                        </form>
                    @endif
                @endrole
            </div>
        </div>

        <!-- Cat Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-40 bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">
                @if ($adoption->cat && $adoption->cat->photo)
                    <img src="{{ $adoption->cat->photo_url }}"
                         class="w-full h-full object-cover" loading="lazy">
                @else
                    <div class="text-6xl">🐱</div>
                @endif
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-800 text-lg">{{ $adoption->cat->name ?? 'Cat data not found' }}</h3>
                <p class="text-sm text-gray-500">{{ $adoption->cat->breed ?? '-' }}</p>

                <div class="grid grid-cols-2 gap-4 mt-5">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400">Age</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $adoption->cat->age_estimate ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400">Gender</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ ucfirst($adoption->cat->gender ?? '-') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs uppercase tracking-wide text-gray-400">Cat Status</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ match(optional($adoption->cat)->status) {
                                'ready_for_adoption' => 'bg-emerald-100 text-emerald-700',
                                'rescued' => 'bg-amber-100 text-amber-700',
                                'in_treatment' => 'bg-red-100 text-red-700',
                                'adopted' => 'bg-blue-100 text-blue-700',
                                default => 'bg-gray-100 text-gray-600',
                            } }}">
                            {{ strtoupper(str_replace('_', ' ', $adoption->cat->status ?? '-')) }}
                        </span>
                    </div>
                </div>

                @if ($adoption->cat)
                    <a href="{{ route('cats.edit', $adoption->cat) }}" class="inline-block mt-5 text-sm font-medium text-emerald-700 hover:underline">
                        View Full Cat Profile &rarr;
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
