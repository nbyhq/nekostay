<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdoptionRequest;
use App\Http\Resources\AdoptionResource;
use App\Models\Adoption;
use Illuminate\Http\Request;

class AdoptionApiController extends Controller
{
    /**
     * GET /api/adoptions
     */
    public function index(Request $request)
    {
        $query = Adoption::with('cat');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $adoptions = $query->latest()->paginate(10)->withQueryString();

        return AdoptionResource::collection($adoptions);
    }

    /**
     * GET /api/adoptions/{adoption}
     */
    public function show(Adoption $adoption)
    {
        $adoption->load('cat');

        return new AdoptionResource($adoption);
    }

    /**
     * POST /api/adoptions
     */
    public function store(StoreAdoptionRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'pending';

        $adoption = Adoption::create($data);
        $adoption->load('cat');

        return (new AdoptionResource($adoption))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * PUT/PATCH /api/adoptions/{adoption}
     */
    public function update(StoreAdoptionRequest $request, Adoption $adoption)
    {
        $adoption->update($request->validated());
        $adoption->load('cat');

        return new AdoptionResource($adoption);
    }

    /**
     * DELETE /api/adoptions/{adoption}
     */
    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

        return response()->json(['message' => 'Adoption request deleted successfully.'], 200);
    }
}
