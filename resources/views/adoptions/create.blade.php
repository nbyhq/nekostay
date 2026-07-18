<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">New Adoption Request</h2>
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

            @if ($cats->isEmpty())
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
                    Tidak ada kucing dengan status <strong>Ready for Adoption</strong> saat ini. Perbarui status kucing terlebih dahulu di halaman
                    <a href="{{ route('cats.index') }}" class="underline font-medium">Cat Management</a>.
                </div>
            @else
                <form method="POST" action="{{ route('adoptions.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cat</label>
                        <select name="cat_id" required
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">-- Select a cat --</option>
                            @foreach ($cats as $cat)
                                <option value="{{ $cat->id }}" @selected(old('cat_id', $selectedCatId) == $cat->id)>
                                    {{ $cat->name }} @if($cat->breed) ({{ $cat->breed }}) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adopter Name</label>
                        <input type="text" name="adopter_name" value="{{ old('adopter_name') }}" required
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Full name of the adopter">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="adopter_phone" value="{{ old('adopter_phone') }}" required
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="e.g. 0812-3456-7890">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="adopter_address" rows="3"
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Home address">{{ old('adopter_address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="3"
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Any additional notes about this application">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('adoptions.index') }}" class="px-5 py-2 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-lg">
                            Submit Request
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
