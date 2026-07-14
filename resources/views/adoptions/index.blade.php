<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-bold text-2xl text-gray-800">Adoption Requests</h2>
            <a href="{{ route('adoptions.create') }}" class="shrink-0 whitespace-nowrap bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-emerald-800 transition">
                + New Request
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
                    class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="all">All Statuses</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
            </select>
            <button type="submit" class="text-sm border border-gray-200 rounded-lg px-4 py-2 text-gray-600 hover:bg-gray-50">
                Search
            </button>
        </form>

        <!-- Table (desktop) -->
        <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
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
                                        <img src="{{ $adoption->cat->photo_url }}" class="h-10 w-10 rounded-lg object-cover" loading="lazy">
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
                                    @if ($adoption->status === 'pending')
                                        @role('admin')
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
                                        @endrole
                                    @endif
                                    <a href="{{ route('adoptions.show', $adoption) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-emerald-700 transition" title="View details">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('adoptions.edit', $adoption) }}" class="text-gray-600 hover:underline text-sm font-medium">Edit</a>
                                    @role('admin')
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

        <!-- Cards (mobile) -->
        <div class="md:hidden space-y-3">
            @forelse ($adoptions as $adoption)
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-start gap-3">
                        @if ($adoption->cat && $adoption->cat->photo)
                            <img src="{{ $adoption->cat->photo_url }}" class="h-12 w-12 rounded-lg object-cover shrink-0" loading="lazy">
                        @else
                            <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300 text-xs shrink-0">N/A</div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <div class="font-semibold text-gray-800 truncate">{{ $adoption->cat->name ?? 'Cat deleted' }}</div>
                                <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-semibold
                                    {{ match($adoption->status) {
                                        'approved' => 'bg-emerald-100 text-emerald-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    } }}">
                                    {{ strtoupper($adoption->status) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">{{ $adoption->adopter_name }} &middot; {{ $adoption->adopter_phone }}</div>
                            @if ($adoption->adopter_address)
                                <div class="text-xs text-gray-400 truncate mt-0.5">{{ $adoption->adopter_address }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                        <span class="text-xs text-gray-400 shrink-0">{{ $adoption->created_at->format('d M Y') }}</span>

                        <div class="flex items-center gap-1">
                            @if ($adoption->status === 'pending')
                                @role('admin')
                                    <form action="{{ route('adoptions.updateStatus', $adoption) }}" method="POST" onsubmit="return confirm('Setujui permohonan adopsi ini? Status kucing akan berubah menjadi Adopted.');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-medium">Approve</button>
                                    </form>
                                    <form action="{{ route('adoptions.updateStatus', $adoption) }}" method="POST" onsubmit="return confirm('Tolak permohonan adopsi ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-2 py-1 rounded-md bg-red-50 text-red-700 text-xs font-medium">Reject</button>
                                    </form>
                                @endrole
                            @endif

                            <a href="{{ route('adoptions.show', $adoption) }}" class="inline-flex items-center justify-center h-7 w-7 rounded-md text-gray-500 hover:bg-gray-100 hover:text-emerald-700" title="View">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>

                            <a href="{{ route('adoptions.edit', $adoption) }}" class="inline-flex items-center justify-center h-7 w-7 rounded-md text-gray-500 hover:bg-gray-100 hover:text-emerald-700" title="Edit">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            @role('admin')
                                <form action="{{ route('adoptions.destroy', $adoption) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permohonan adopsi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center h-7 w-7 rounded-md text-gray-500 hover:bg-red-50 hover:text-red-600" title="Delete">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endrole
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-8 text-center text-gray-400">Belum ada permohonan adopsi.</div>
            @endforelse

            <div class="pt-2">
                {{ $adoptions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
