<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdoptionRequest;
use App\Models\Adoption;
use App\Models\Cat;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    /**
     * Display a listing of adoption requests with search & status filter.
     */
    public function index(Request $request)
    {
        $query = Adoption::with('cat');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('adopter_name', 'like', "%{$search}%")
                  ->orWhere('adopter_phone', 'like', "%{$search}%")
                  ->orWhereHas('cat', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $adoptions = $query->latest()->paginate(10)->withQueryString();

        $pendingCount = Adoption::where('status', 'pending')->count();
        $approvedCount = Adoption::where('status', 'approved')->count();
        $rejectedCount = Adoption::where('status', 'rejected')->count();

        return view('adoptions.index', compact(
            'adoptions',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Show the form for submitting a new adoption request.
     */
    public function create(Request $request)
    {
        $cats = Cat::where('status', 'ready_for_adoption')->orderBy('name')->get();
        $selectedCatId = $request->integer('cat') ?: null;

        return view('adoptions.create', compact('cats', 'selectedCatId'));
    }

    /**
     * Store a newly submitted adoption request.
     */
    public function store(StoreAdoptionRequest $request)
    {
        $data = $request->validated();

        $cat = Cat::findOrFail($data['cat_id']);

        if ($cat->status !== 'ready_for_adoption') {
            return back()
                ->withInput()
                ->withErrors(['cat_id' => 'Kucing ini sudah tidak tersedia untuk diadopsi.']);
        }

        $data['status'] = 'pending';

        Adoption::create($data);

        return redirect()->route('adoptions.index')
            ->with('success', 'Permohonan adopsi berhasil diajukan dan menunggu peninjauan.');
    }

    /**
     * Show the form for editing an adoption request.
     */
    public function edit(Adoption $adoption)
    {
        $cats = Cat::where('status', 'ready_for_adoption')
            ->orWhere('id', $adoption->cat_id)
            ->orderBy('name')
            ->get();

        return view('adoptions.edit', compact('adoption', 'cats'));
    }

    /**
     * Update adopter details and/or the request status.
     */
    public function update(StoreAdoptionRequest $request, Adoption $adoption)
    {
        $data = $request->validated();
        $data['status'] = $data['status'] ?? $adoption->status;

        $previousStatus = $adoption->status;

        $adoption->update($data);

        $this->syncCatStatus($adoption, $previousStatus);

        return redirect()->route('adoptions.index')
            ->with('success', 'Data permohonan adopsi berhasil diperbarui.');
    }

    /**
     * Quick approve/reject action used from the index list.
     */
    public function updateStatus(Request $request, Adoption $adoption)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected,pending'],
        ]);

        $previousStatus = $adoption->status;

        $adoption->update(['status' => $request->status]);

        $this->syncCatStatus($adoption, $previousStatus);

        $message = match ($request->status) {
            'approved' => 'Permohonan adopsi disetujui. Status kucing diperbarui menjadi "adopted".',
            'rejected' => 'Permohonan adopsi ditolak.',
            default => 'Status permohonan adopsi diperbarui.',
        };

        return redirect()->route('adoptions.index')->with('success', $message);
    }

    /**
     * Remove an adoption request (admin only, see routes/web.php).
     */
    public function destroy(Adoption $adoption)
    {
        $wasApproved = $adoption->status === 'approved';
        $cat = $adoption->cat;

        $adoption->delete();

        if ($wasApproved && $cat && $cat->status === 'adopted') {
            $cat->update(['status' => 'ready_for_adoption']);
        }

        return redirect()->route('adoptions.index')
            ->with('success', 'Permohonan adopsi berhasil dihapus.');
    }

    /**
     * Keep the related cat's status in sync whenever an adoption's
     * status changes (approved -> adopted, otherwise -> ready_for_adoption).
     */
    private function syncCatStatus(Adoption $adoption, string $previousStatus): void
    {
        $cat = $adoption->cat;

        if (! $cat) {
            return;
        }

        if ($adoption->status === 'approved' && $previousStatus !== 'approved') {
            $cat->update(['status' => 'adopted']);

            // Any other pending requests for the same cat are no longer relevant.
            Adoption::where('cat_id', $cat->id)
                ->where('id', '!=', $adoption->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        if ($previousStatus === 'approved' && $adoption->status !== 'approved' && $cat->status === 'adopted') {
            $cat->update(['status' => 'ready_for_adoption']);
        }
    }
}
