<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Edit Cat: {{ $cat->name }}</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm p-6 max-w-4xl">
        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 text-lg">Update Cat Information</h3>
            <p class="text-sm text-gray-500">Perbarui data profil atau status kucing ini.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cats.update', $cat) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cat Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $cat->name) }}" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                    <input type="text" name="breed" value="{{ old('breed', $cat->breed) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Age</label>
                    <input type="text" name="age_estimate" value="{{ old('age_estimate', $cat->age_estimate) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Select gender</option>
                        <option value="male" @selected(old('gender', $cat->gender) === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $cat->gender) === 'female')>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="rescued" @selected(old('status', $cat->status) === 'rescued')>Rescued</option>
                        <option value="in_treatment" @selected(old('status', $cat->status) === 'in_treatment')>In Treatment</option>
                        <option value="ready_for_adoption" @selected(old('status', $cat->status) === 'ready_for_adoption')>Ready for Adoption</option>
                        <option value="adopted" @selected(old('status', $cat->status) === 'adopted')>Adopted</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="text" name="color" value="{{ old('color', $cat->color) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rescue Location</label>
                    <input type="text" name="rescue_location" value="{{ old('rescue_location', $cat->rescue_location) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $cat->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cat Photo</label>
                @if ($cat->photo)
                    <img src="{{ $cat->photo_url }}" class="h-24 w-24 rounded-lg object-cover mb-3">
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 text-center">
                    <input type="file" name="photo" accept="image/*" class="text-sm text-gray-500">
                    <p class="text-xs text-gray-400 mt-2">Kosongkan jika tidak ingin mengganti foto. Supports JPG, PNG (Max 5MB)</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('cats.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-emerald-800">
                    Update Cat Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>