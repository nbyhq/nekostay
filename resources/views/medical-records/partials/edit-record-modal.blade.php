<div
    id="editRecordModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="flex items-center justify-between border-b px-6 py-4">

            <h2 class="text-xl font-bold text-gray-800">
                Edit Medical Record
            </h2>

            <button
                type="button"
                onclick="closeEditModal()"
                class="text-gray-400 hover:text-gray-600 text-2xl">

                &times;

            </button>

        </div>

        <form
            id="editRecordForm"
            method="POST">

            @csrf
            @method('PUT')

            <input
                type="hidden"
                id="edit_cat_id"
                name="cat_id">

            <div class="p-6 grid grid-cols-2 gap-4">

                <!-- Visit Date -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Visit Date
                    </label>

                    <input
                        type="date"
                        id="edit_visit_date"
                        name="visit_date"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Doctor -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Doctor
                    </label>

                    <input
                        type="text"
                        id="edit_doctor"
                        name="doctor"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Weight -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Weight (kg)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        id="edit_weight"
                        name="weight"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Temperature -->
                <div>

                    <label class="block text-sm font-medium mb-1">
                        Temperature (°C)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        id="edit_temperature"
                        name="temperature"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Status -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Status
                    </label>

                    <select
                        id="edit_status"
                        name="status"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                        <option value="Routine">Routine</option>
                        <option value="Treatment">Treatment</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Vaccination">Vaccination</option>

                    </select>

                </div>

                <!-- Diagnosis -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Diagnosis
                    </label>

                    <textarea
                        id="edit_diagnosis"
                        name="diagnosis"
                        rows="3"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"></textarea>

                </div>

                <!-- Treatment -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Treatment
                    </label>

                    <textarea
                        id="edit_treatment"
                        name="treatment"
                        rows="3"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"></textarea>

                </div>

                <!-- Notes -->
                <div class="col-span-2">

                    <label class="block text-sm font-medium mb-1">
                        Notes
                    </label>

                    <textarea
                        id="edit_notes"
                        name="notes"
                        rows="3"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"></textarea>

                </div>

            </div>

            <!-- Footer -->
            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl transition">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>
