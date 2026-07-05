<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatRequest;
use App\Models\Adoption;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatController extends Controller
{
    public function index(Request $request)
    {
        $query = Cat::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $cats = $query->latest()->paginate(10)->withQueryString();

        $pendingCheckups = Cat::where('status', 'in_treatment')->count();
        $newApplications = Adoption::where('status', 'pending')->count();
        $shelterCapacity = Cat::whereIn('status', ['rescued', 'in_treatment', 'ready_for_adoption'])->count();

        return view('cats.index', compact('cats', 'pendingCheckups', 'newApplications', 'shelterCapacity'));
    }

    public function create()
    {
        return view('cats.create');
    }

    public function store(StoreCatRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('cats', 'public');
        }

        Cat::create($data);

        return redirect()->route('cats.index')->with('success', 'Data kucing berhasil ditambahkan.');
    }

    public function edit(Cat $cat)
    {
        return view('cats.edit', compact('cat'));
    }

    public function update(StoreCatRequest $request, Cat $cat)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($cat->photo) {
                Storage::disk('public')->delete($cat->photo);
            }
            $data['photo'] = $request->file('photo')->store('cats', 'public');
        }

        $cat->update($data);

        return redirect()->route('cats.index')->with('success', 'Data kucing berhasil diperbarui.');
    }

    public function destroy(Cat $cat)
    {
        if ($cat->photo) {
            Storage::disk('public')->delete($cat->photo);
        }

        $cat->delete();

        return redirect()->route('cats.index')->with('success', 'Data kucing berhasil dihapus.');
    }
}
