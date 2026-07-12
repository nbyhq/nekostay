<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">Manage Staff</h2>
            </div>
            <a href="{{ route('staff.create') }}" class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-emerald-800 transition">
                + Add New Staff
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" action="{{ route('staff.index') }}" class="bg-white rounded-xl shadow-sm p-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                class="w-full max-w-sm px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </form>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-400 uppercase border-b border-gray-100 bg-gray-50">
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Joined</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                    <span class="text-xs text-gray-400">(You)</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $user->email }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $user->hasRole('admin') ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ strtoupper($user->getRoleNames()->first() ?? '-') }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <a href="{{ route('staff.edit', $user) }}" class="text-emerald-700 hover:underline text-sm font-medium">Edit</a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('staff.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada data staff.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-5 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
