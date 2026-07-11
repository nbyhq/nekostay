<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">Adoption Requests</h2>
                <p class="text-sm text-gray-500 mt-1">Review, approve, or reject applications from prospective adopters.</p>
            </div>
            <a href="{{ route('adoptions.create') }}" class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-emerald-800 transition">
                + New Adoption Request
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-amber-50 rounded-xl p-5">
                <div class="text-sm font-semibold text-amber-700">Pending Review</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingCount }}</div>
                <div class="text-xs text-gray-500 mt-1">Applications waiting for a decision.</div>
            </div>
            <div class="bg-emerald-50 rounded-xl p-5">
                <div class="text-sm font-semibold text-emerald-700">Approved</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $approvedCount }}</div>
                <div class="text-xs text-gray-500 mt-1">Successful adoptions to date.</div>
            </div>
            <div class="bg-red-50 rounded-xl p-5">
                <div class="text-sm font-semibold text-red-700">Rejected</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $rejectedCount }}</div>
                <div class="text-xs text-gray-500 mt-1">Applications that did not proceed.</div>
            </div>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('adoptions.index') }}" class="bg-white rounded-xl shadow-sm p-4 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by adopter name, phone, or cat..."
                    class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="all" @selected(!request('status') || request('status') === 'all')>All Statuses</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
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
                        <th class="px-5 py-3">Cat</th>
                        <th class="px-5 py-3">Adopter</th>
                        <th class="px-5 py-3">Contact</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Submitted</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($adoptions as $adoption)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($adoption->cat && $adoption->cat->photo)
                                        <img src="{{ str_starts_with($adoption->cat->photo, 'http') ? $adoption->cat->photo : Storage::url($adoption->cat->photo) }}" class="h-10 w-10 rounded-lg object-cover" loading="lazy">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300 text-xs">N/A</div>
                                    @endif
                                    <div class="font-semibold text-gray-800">{{ $adoption->cat->name ?? 'Cat deleted' }}</div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-medium text-gray-800">{{ $adoption->adopter_name }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-[220px]">{{ $adoption->adopter_address ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $adoption->adopter_phone }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ match($adoption->status) {
                                        'approved' => 'bg-emerald-100 text-emerald-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    } }}">
                                    {{ strtoupper($adoption->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $adoption->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2 flex-wrap">
                                    <a href="{{ route('adoptions.show', $adoption) }}" class="text-gray-500 hover:text-emerald-700" title="View">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @role('admin')
                                        @if ($adoption->status === 'pending')
                                            <form action="{{ route('adoptions.updateStatus', $adoption) }}" method="POST" onsubmit="return confirm('Setujui permohonan adopsi ini? Status kucing akan berubah menjadi Adopted.');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="text-emerald-700 hover:underline text-sm font-medium">Approve</button>
                                            </form>
                                            <form action="{{ route('adoptions.updateStatus', $adoption) }}" method="POST" onsubmit="return confirm('Tolak permohonan adopsi ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Reject</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('adoptions.edit', $adoption) }}" class="text-gray-600 hover:underline text-sm font-medium">Edit</a>
                                        <form action="{{ route('adoptions.destroy', $adoption) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus permohonan adopsi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Delete</button>
                                        </form>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada permohonan adopsi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-5 py-4 border-t border-gray-100">
                {{ $adoptions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
