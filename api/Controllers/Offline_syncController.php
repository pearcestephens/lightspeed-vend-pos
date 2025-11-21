<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Offline_syncController extends BaseController {

    /**
     * Display a listing of offline_sync
     */
    public function index(Request $request): JsonResponse {
        $query = Offline_sync::query();

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
     * Store a newly created offline_sync
     */
    public function store(StoreOffline_syncRequest $request): JsonResponse {
        try {
            $offline_sync = Offline_sync::create($request->validated());
            return $this->success($offline_sync, 'Offline_sync created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create offline_sync: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified offline_sync
     */
    public function show($id): JsonResponse {
        $offline_sync = Offline_sync::find($id);

        if (!offline_sync) {
            return $this->error('Offline_sync not found', null, 404);
        }

        return $this->success($offline_sync);
    }

    /**
     * Update the specified offline_sync
     */
    public function update(UpdateOffline_syncRequest $request, $id): JsonResponse {
        try {
            $offline_sync = Offline_sync::find($id);

            if (!offline_sync) {
                return $this->error('Offline_sync not found', null, 404);
            }

            $offline_sync->update($request->validated());
            return $this->success($offline_sync, 'Offline_sync updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update offline_sync: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified offline_sync
     */
    public function destroy($id): JsonResponse {
        try {
            $offline_sync = Offline_sync::find($id);

            if (!offline_sync) {
                return $this->error('Offline_sync not found', null, 404);
            }

            $offline_sync->delete();
            return $this->success(null, 'Offline_sync deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete offline_sync: ' . $e->getMessage(), null, 500);
        }
    }
}