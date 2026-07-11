<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">Manage Rescued Cats</h2>
                <p class="text-sm text-gray-500 mt-1">Overview and status of all felines currently in care.</p>
            </div>
            <a href="{{ route('cats.create') }}" class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-emerald-800 transition">
                + Add New Cat
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('cats.index') }}" class="bg-white rounded-xl shadow-sm p-4 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, breed or ID..."
                    class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="all">All Statuses</option>
                <option value="rescued" @selected(request('status') === 'rescued')>Rescued</option>
                <option value="in_treatment" @selected(request('status') === 'in_treatment')>In Treatment</option>
                <option value="ready_for_adoption" @selected(request('status') === 'ready_for_adoption')>Ready for Adoption</option>
                <option value="adopted" @selected(request('status') === 'adopted')>Adopted</option>
            </select>

            <button type="submit" class="text-sm border border-gray-200 rounded-lg px-4 py-2 text-gray-600 hover:bg-gray-50">
                Search
            </button>
        </form>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-400 uppercase border-b border-gray-100 bg-gray-50">
                        <th class="px-5 py-3">Cat Photo</th>
                        <th class="px-5 py-3">Name & Breed</th>
                        <th class="px-5 py-3">Age & Gender</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cats as $cat)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-5 py-3">
                                @if ($cat->photo)
                                    <img src="{{ str_starts_with($cat->photo, "http") ? $cat->photo : Storage::url($cat->photo) }}" class="h-12 w-12 rounded-lg object-cover" loading="lazy">
                                @else
                                    <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300 text-xs">No Photo</div>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-semibold text-gray-800">{{ $cat->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cat->breed ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-blue-50 text-blue-600 mr-1">{{ $cat->age_estimate ?? '-' }}</span>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-pink-50 text-pink-600">{{ ucfirst($cat->gender ?? '-') }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ match($cat->status) {
                                        'ready_for_adoption' => 'bg-emerald-100 text-emerald-700',
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'in_treatment' => 'bg-red-100 text-red-700',
                                        'adopted' => 'bg-blue-100 text-blue-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    } }}">
                                    {{ strtoupper(str_replace('_', ' ', $cat->status)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                @if ($cat->status === 'ready_for_adoption')
                                    <a href="{{ route('adoptions.create', ['cat' => $cat->id]) }}" class="text-emerald-700 hover:underline text-sm font-medium">Adopt</a>
                                @endif
                                <a href="{{ route('cats.edit', $cat) }}" class="text-emerald-700 hover:underline text-sm font-medium">Edit</a>
                                @role('admin')
                                    <form action="{{ route('cats.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data kucing ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Hapus</button>
                                    </form>
                                @endrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada data kucing.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-5 py-4 border-t border-gray-100">
                {{ $cats->links() }}
            </div>
        </div>

        <!-- Bottom stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-emerald-50 rounded-xl p-5">
                <div class="text-sm font-semibold text-emerald-700">Pending Checkups</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingCheckups }}</div>
                <div class="text-xs text-gray-500 mt-1">Cats requiring vet review this week.</div>
            </div>
            <div class="bg-amber-50 rounded-xl p-5">
                <div class="text-sm font-semibold text-amber-700">New Apps</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $newApplications }}</div>
                <div class="text-xs text-gray-500 mt-1">Adoption requests awaiting screening.</div>
            </div>
            <div class="bg-blue-50 rounded-xl p-5">
                <div class="text-sm font-semibold text-blue-700">Shelter Capacity</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $shelterCapacity }}</div>
                <div class="text-xs text-gray-500 mt-1">Cats currently in shelter.</div>
            </div>
        </div>
    </div>
</x-app-layout>
