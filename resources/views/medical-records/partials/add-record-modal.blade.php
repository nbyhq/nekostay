<div
    id="addRecordModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="flex items-center justify-between border-b px-6 py-4">

            <h2 class="text-xl font-bold text-gray-800">
                Add Medical Record
            </h2>

            <button
                type="button"
                onclick="closeModal()"
                class="text-gray-400 hover:text-gray-600 text-2xl">

                &times;

            </button>

        </div>

        @if ($errors->any())

            <div class="mx-6 mt-4 rounded-xl border border-red-200 bg-red-50 p-4">

                <ul class="list-disc list-inside text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('medical-records.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="cat_id"
                value="{{ $selectedCat?->id }}">

            <div class="p-6 grid grid-cols-2 gap-4">

                <!-- Visit Date -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Visit Date
                    </label>

                    <input
                        type="date"
                        name="visit_date"
                        value="{{ old('visit_date') }}"
                        class="w-full rounded-xl border-gray-300">

                </div>

                <!-- Doctor -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Doctor
                    </label>

                    <input
                        type="text"
                        name="doctor"
                        value="{{ old('doctor') }}"
                        placeholder="Doctor Name"
                        class="w-full rounded-xl border-gray-300">

                </div>

                <!-- Weight -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Weight (kg)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        name="weight"
                        value="{{ old('weight') }}"
                        class="w-full rounded-xl border-gray-300">

                </div>

                <!-- Temperature -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Temperature (°C)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        name="temperature"
                        value="{{ old('temperature') }}"
                        class="w-full rounded-xl border-gray-300">

                </div>

                <!-- Status -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border-gray-300">

                        <option value="">-- Select Status --</option>

                        <option value="Healthy"
                            {{ old('status') == 'Healthy' ? 'selected' : '' }}>
                            Healthy
                        </option>

                        <option value="Treatment"
                            {{ old('status') == 'Treatment' ? 'selected' : '' }}>
                            Treatment
                        </option>

                        <option value="Recovery"
                            {{ old('status') == 'Recovery' ? 'selected' : '' }}>
                            Recovery
                        </option>

                    </select>

                </div>

                <!-- Diagnosis -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Diagnosis
                    </label>

                    <textarea
                        name="diagnosis"
                        rows="3"
                        class="w-full rounded-xl border-gray-300">{{ old('diagnosis') }}</textarea>

                </div>

                <!-- Treatment -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Treatment
                    </label>

                    <textarea
                        name="treatment"
                        rows="3"
                        class="w-full rounded-xl border-gray-300">{{ old('treatment') }}</textarea>

                </div>

                <!-- Notes -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        rows="3"
                        class="w-full rounded-xl border-gray-300">{{ old('notes') }}</textarea>

                </div>

            </div>

            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="px-5 py-2 rounded-xl border">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-xl">

                    Save Record

                </button>

            </div>

        </form>

    </div>

</div>

@if ($errors->any())
<script>

document.addEventListener('DOMContentLoaded', function(){

    openModal();

});

</script>
@endif
