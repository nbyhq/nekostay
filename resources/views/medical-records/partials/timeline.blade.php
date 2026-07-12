<div class="bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col lg:h-[calc(100vh-180px)]">

    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-100">

        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                Medical History Log
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Total Records : {{ $medicalRecords->count() }}
            </p>

            <!-- Filter -->
            <div class="flex gap-2 mt-4">

            <a href="{{ route('medical-records.index', ['cat'=>$selectedCat?->id]) }}"
                class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition-all duration-200
                {{ request('status')==null ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">

                All

            </a>

            <a href="{{ route('medical-records.index',[
                'cat'=>$selectedCat?->id,
                'status'=>'Healthy'
            ]) }}"
                class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition-all duration-200
                {{ request('status')=='Healthy' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}">

                Healthy

            </a>

            <a href="{{ route('medical-records.index',[
                'cat'=>$selectedCat?->id,
                'status'=>'Treatment'
            ]) }}"
                class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition-all duration-200
                {{ request('status')=='Treatment' ? 'bg-red-600 text-white shadow-sm' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">

                Treatment

            </a>

            <a href="{{ route('medical-records.index',[
                'cat'=>$selectedCat?->id,
                'status'=>'Recovery'
            ]) }}"
                class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition-all duration-200
                {{ request('status')=='Recovery' ? 'bg-blue-600 text-white shadow-sm' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">

                Recovery

            </a>

        </div>

        </div>

    </div>

    <!-- Timeline -->
    <div class="flex-1 lg:overflow-y-auto p-6">

        @if($medicalRecords->count())

            <div class="relative border-l-2 border-gray-200 ml-5">

                @foreach($medicalRecords as $record)

                    <div class="relative pl-8 pb-8">

                        <div class="absolute -left-[11px] top-3 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white shadow"></div>

                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-5 hover:shadow-md transition">

                            <div class="flex justify-between">

                                <div>

                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}
                                    </p>

                                    <h3 class="text-lg font-bold text-gray-800 mt-1">
                                        {{ $record->diagnosis }}
                                    </h3>

                                </div>

                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset

                                    @if($record->status=='Healthy')
                                        bg-emerald-50 text-emerald-700 ring-emerald-200
                                    @elseif($record->status=='Treatment')
                                        bg-amber-50 text-amber-700 ring-amber-200
                                    @elseif($record->status=='Recovery')
                                        bg-sky-50 text-sky-700 ring-sky-200
                                    @else
                                        bg-gray-50 text-gray-700 ring-gray-200
                                    @endif">

                                    {{ $record->status }}

                                </span>

                            </div>

                            <div class="mt-5">

                                <p class="text-xs uppercase text-gray-400">
                                    Veterinarian
                                </p>

                                <p class="font-medium">
                                    {{ $record->doctor }}
                                </p>

                            </div>

                            <div class="mt-4">

                                <p class="text-xs uppercase text-gray-400">
                                    Diagnosis
                                </p>

                                <p class="text-gray-700">
                                    {{ $record->diagnosis }}
                                </p>

                            </div>

                            <div class="mt-4">

                                <p class="text-xs uppercase text-gray-400">
                                    Treatment
                                </p>

                                <p>
                                    {{ $record->treatment ?: '-' }}
                                </p>

                            </div>

                            <div class="mt-4">

                                <p class="text-xs uppercase text-gray-400">
                                    Notes
                                </p>

                                <p>
                                    {{ $record->notes ?: '-' }}
                                </p>

                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-5">

                                <div>

                                    <p class="text-xs uppercase text-gray-400">
                                        Weight
                                    </p>

                                    <p class="font-semibold">
                                        {{ $record->weight ?: '-' }} kg
                                    </p>

                                </div>

                                <div>

                                    <p class="text-xs uppercase text-gray-400">
                                        Temperature
                                    </p>

                                    <p class="font-semibold">
                                        {{ $record->temperature ?: '-' }} °C
                                    </p>

                                </div>

                            </div>

                            <div class="mt-6 flex justify-end gap-3">

                                <button
                                    onclick='openEditModal(@json($record))'
                                    class="px-4 py-2 rounded-lg bg-sky-50 text-sky-700 ring-sky-200 hover:bg-blue-200">
                                    Edit
                                </button>

                                <form
                                    action="{{ route('medical-records.destroy', $record->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this medical record?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="flex h-full items-center justify-center">

                <div class="text-center">

                    <div class="text-7xl">
                        🩺
                    </div>

                    <h3 class="text-2xl font-bold mt-4">
                        No Medical Records
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Click <strong>Add Record</strong> to create the first medical record.
                    </p>

                </div>

            </div>

        @endif

    </div>

</div>

@include('medical-records.partials.add-record-modal')
@include('medical-records.partials.edit-record-modal')

@push('scripts')
<script>

function openModal(){
    document.getElementById('addRecordModal').classList.remove('hidden');
    document.getElementById('addRecordModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('addRecordModal').classList.remove('flex');
    document.getElementById('addRecordModal').classList.add('hidden');
}

function openEditModal(record){

    document.getElementById('editRecordForm').action = '/medical-records/' + record.id;

    document.getElementById('edit_visit_date').value = record.visit_date;
    document.getElementById('edit_doctor').value = record.doctor;
    document.getElementById('edit_diagnosis').value = record.diagnosis;
    document.getElementById('edit_treatment').value = record.treatment ?? '';
    document.getElementById('edit_notes').value = record.notes ?? '';
    document.getElementById('edit_weight').value = record.weight ?? '';
    document.getElementById('edit_temperature').value = record.temperature ?? '';
    document.getElementById('edit_status').value = record.status;

    document.getElementById('editRecordModal').classList.remove('hidden');
    document.getElementById('editRecordModal').classList.add('flex');
}

function closeEditModal(){

    document.getElementById('editRecordModal').classList.remove('flex');
    document.getElementById('editRecordModal').classList.add('hidden');

}

</script>
@endpush
