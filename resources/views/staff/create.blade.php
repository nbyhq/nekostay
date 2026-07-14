<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Add New Staff</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm p-6 max-w-lg">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('staff.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Select role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('staff.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-emerald-800">
                    Create Staff Account
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
