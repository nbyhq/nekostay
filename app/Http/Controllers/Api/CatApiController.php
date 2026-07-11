<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCatRequest;
use App\Http\Resources\CatResource;
use App\Models\Cat;
use Illuminate\Http\Request;

class CatApiController extends Controller
{
    /**
     * GET /api/cats
     */
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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cats = $query->latest()->paginate(10)->withQueryString();

        return CatResource::collection($cats);
    }

    /**
     * GET /api/cats/{cat}
     */
    public function show(Cat $cat)
    {
        return new CatResource($cat);
    }

    /**
     * POST /api/cats
     */
    public function store(StoreCatRequest $request)
    {
        $cat = Cat::create($request->validated());

        return (new CatResource($cat))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * PUT/PATCH /api/cats/{cat}
     */
    public function update(StoreCatRequest $request, Cat $cat)
    {
        $cat->update($request->validated());

        return new CatResource($cat);
    }

    /**
     * DELETE /api/cats/{cat}
     */
    public function destroy(Cat $cat)
    {
        $cat->delete();

        return response()->json(['message' => 'Cat deleted successfully.'], 200);
    }
}
