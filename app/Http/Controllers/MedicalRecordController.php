<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
{
    $cats = Cat::orderBy('name')->get();

    $selectedCat = null;

    if ($request->filled('cat')) {
        $selectedCat = Cat::with('medicalRecords')->find($request->cat);
    }

    if (!$selectedCat && $cats->count()) {
        $selectedCat = Cat::with('medicalRecords')->find($cats->first()->id);
    }

    $latestRecord = null;
    $medicalRecords = collect();

    if ($selectedCat) {

        $latestRecord = $selectedCat->medicalRecords()
            ->latest('visit_date')
            ->first();

        $medicalRecords = $selectedCat->medicalRecords()
            ->when(
                $request->filled('status'),
                function ($query) use ($request) {
                    $query->where('status', $request->status);
                }
            )
            ->orderByDesc('visit_date')
            ->get();
    }

    return view(
        'medical-records.index',
        compact(
            'cats',
            'selectedCat',
            'latestRecord',
            'medicalRecords'
        )
    );

}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cat_id'      => 'required|exists:cats,id',
            'visit_date'  => 'required|date',
            'doctor'      => 'required|string|max:255',
            'diagnosis'   => 'required|string',
            'treatment'   => 'nullable|string',
            'notes'       => 'nullable|string',
            'weight'      => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'status'      => 'required|in:Healthy,Treatment,Recovery',
        ]);

        MedicalRecord::create($validated);

        return redirect()
            ->route('medical-records.index', [
                'cat' => $validated['cat_id']
            ])
            ->with('success', 'Medical record berhasil ditambahkan.');
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'visit_date'  => 'required|date',
            'doctor'      => 'required|string|max:255',
            'diagnosis'   => 'required|string',
            'treatment'   => 'nullable|string',
            'notes'       => 'nullable|string',
            'weight'      => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'status'      => 'required|in:Healthy,Treatment,Recovery',
        ]);

        $medicalRecord->update($validated);

        return redirect()
            ->route('medical-records.index', [
                'cat' => $medicalRecord->cat_id
            ])
            ->with('success', 'Medical record berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $catId = $medicalRecord->cat_id;

        $medicalRecord->delete();

        return redirect()
            ->route('medical-records.index', [
                'cat' => $catId
            ])
            ->with('success', 'Medical record berhasil dihapus.');
    }
}
