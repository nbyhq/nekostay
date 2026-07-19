<div
    id="editRecordModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="flex items-center justify-between border-b px-6 py-4">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Edit Medical Record
                </h2>
                <p class="text-sm text-gray-500">
                    Update the selected medical record.
                </p>
            </div>

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

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Visit Date -->
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Visit Date <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        id="edit_visit_date"
                        name="visit_date"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Doctor -->
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Doctor <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="edit_doctor"
                        name="doctor"
                        required
                        placeholder="Enter doctor's name"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Weight -->
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Weight (kg)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        id="edit_weight"
                        name="weight"
                        placeholder="Example: 4.2"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Temperature -->
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Temperature (°C)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        id="edit_temperature"
                        name="temperature"
                        placeholder="Example: 38.5"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <!-- Status -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="edit_status"
                        name="status"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                        <option value="">Select Status</option>
                        <option value="Healthy">Healthy</option>
                        <option value="Treatment">Treatment</option>
                        <option value="Recovery">Recovery</option>

                    </select>

                </div>

                <!-- Diagnosis -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Diagnosis <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="edit_diagnosis"
                        name="diagnosis"
                        rows="3"
                        required
                        placeholder="Enter diagnosis..."
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 resize-none"></textarea>

                </div>

                <!-- Treatment -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Treatment
                    </label>

                    <textarea
                        id="edit_treatment"
                        name="treatment"
                        rows="3"
                        placeholder="Enter treatment..."
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 resize-none"></textarea>

                </div>

                <!-- Notes -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Notes
                    </label>

                    <textarea
                        id="edit_notes"
                        name="notes"
                        rows="3"
                        placeholder="Additional notes..."
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 resize-none"></textarea>

                </div>

            </div>

            <!-- Footer -->
            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2 rounded-xl transition">

                    Update Record

                </button>

            </div>

        </form>

    </div>

</div>
