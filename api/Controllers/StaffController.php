<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaffController extends BaseController {

    /**
     * Display a listing of staff
     */
    public function index(Request $request): JsonResponse {
        $query = Staff::query();

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
     * Store a newly created staff
     */
    public function store(StoreStaffRequest $request): JsonResponse {
        try {
            $staff = Staff::create($request->validated());
            return $this->success($staff, 'Staff created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create staff: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified staff
     */
    public function show($id): JsonResponse {
        $staff = Staff::find($id);

        if (!staff) {
            return $this->error('Staff not found', null, 404);
        }

        return $this->success($staff);
    }

    /**
     * Update the specified staff
     */
    public function update(UpdateStaffRequest $request, $id): JsonResponse {
        try {
            $staff = Staff::find($id);

            if (!staff) {
                return $this->error('Staff not found', null, 404);
            }

            $staff->update($request->validated());
            return $this->success($staff, 'Staff updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update staff: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified staff
     */
    public function destroy($id): JsonResponse {
        try {
            $staff = Staff::find($id);

            if (!staff) {
                return $this->error('Staff not found', null, 404);
            }

            $staff->delete();
            return $this->success(null, 'Staff deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete staff: ' . $e->getMessage(), null, 500);
        }
    }
}