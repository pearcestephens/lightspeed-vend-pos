<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HardwareController extends BaseController {

    /**
     * Display a listing of hardware
     */
    public function index(Request $request): JsonResponse {
        $query = Hardware::query();

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
     * Store a newly created hardware
     */
    public function store(StoreHardwareRequest $request): JsonResponse {
        try {
            $hardware = Hardware::create($request->validated());
            return $this->success($hardware, 'Hardware created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create hardware: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified hardware
     */
    public function show($id): JsonResponse {
        $hardware = Hardware::find($id);

        if (!hardware) {
            return $this->error('Hardware not found', null, 404);
        }

        return $this->success($hardware);
    }

    /**
     * Update the specified hardware
     */
    public function update(UpdateHardwareRequest $request, $id): JsonResponse {
        try {
            $hardware = Hardware::find($id);

            if (!hardware) {
                return $this->error('Hardware not found', null, 404);
            }

            $hardware->update($request->validated());
            return $this->success($hardware, 'Hardware updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update hardware: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified hardware
     */
    public function destroy($id): JsonResponse {
        try {
            $hardware = Hardware::find($id);

            if (!hardware) {
                return $this->error('Hardware not found', null, 404);
            }

            $hardware->delete();
            return $this->success(null, 'Hardware deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete hardware: ' . $e->getMessage(), null, 500);
        }
    }
}