<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoresController extends BaseController {

    /**
     * Display a listing of stores
     */
    public function index(Request $request): JsonResponse {
        $query = Stores::query();

        // Filtering
        if ($request->has('filter')) {
            $query->where('status', $request->input('filter'));
        }

        // Searching
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->input('search') . '%');
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 15);
        $items = $query->paginate($perPage);

        return response()->json($this->paginated($items));
    }

    /**
     * Store a newly created stores
     */
    public function store(StoreStoresRequest $request): JsonResponse {
        try {
            $stores = Stores::create($request->validated());
            return $this->success($stores, 'Stores created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create stores: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified stores
     */
    public function show($id): JsonResponse {
        $stores = Stores::find($id);

        if (!stores) {
            return $this->error('Stores not found', null, 404);
        }

        return $this->success($stores);
    }

    /**
     * Update the specified stores
     */
    public function update(UpdateStoresRequest $request, $id): JsonResponse {
        try {
            $stores = Stores::find($id);

            if (!stores) {
                return $this->error('Stores not found', null, 404);
            }

            $stores->update($request->validated());
            return $this->success($stores, 'Stores updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update stores: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified stores
     */
    public function destroy($id): JsonResponse {
        try {
            $stores = Stores::find($id);

            if (!stores) {
                return $this->error('Stores not found', null, 404);
            }

            $stores->delete();
            return $this->success(null, 'Stores deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete stores: ' . $e->getMessage(), null, 500);
        }
    }
}