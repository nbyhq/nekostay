<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">Edit Adoption Request</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm p-6">
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('adoptions.update', $adoption) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cat</label>
                    <select name="cat_id" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @foreach ($cats as $cat)
                            <option value="{{ $cat->id }}" @selected(old('cat_id', $adoption->cat_id) == $cat->id)>
                                {{ $cat->name }} @if($cat->breed) ({{ $cat->breed }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adopter Name</label>
                    <input type="text" name="adopter_name" value="{{ old('adopter_name', $adoption->adopter_name) }}" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="adopter_phone" value="{{ old('adopter_phone', $adoption->adopter_phone) }}" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="adopter_address" rows="3"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('adopter_address', $adoption->adopter_address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="pending" @selected(old('status', $adoption->status) === 'pending')>Pending</option>
                        <option value="approved" @selected(old('status', $adoption->status) === 'approved')>Approved</option>
                        <option value="rejected" @selected(old('status', $adoption->status) === 'rejected')>Rejected</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Setting status to "Approved" automatically marks the cat as adopted.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes', $adoption->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('adoptions.index') }}" class="px-5 py-2 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
