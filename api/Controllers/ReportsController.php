<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportsController extends BaseController {

    /**
     * Display a listing of reports
     */
    public function index(Request $request): JsonResponse {
        $query = Reports::query();

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
     * Store a newly created reports
     */
    public function store(StoreReportsRequest $request): JsonResponse {
        try {
            $reports = Reports::create($request->validated());
            return $this->success($reports, 'Reports created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create reports: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified reports
     */
    public function show($id): JsonResponse {
        $reports = Reports::find($id);

        if (!reports) {
            return $this->error('Reports not found', null, 404);
        }

        return $this->success($reports);
    }

    /**
     * Update the specified reports
     */
    public function update(UpdateReportsRequest $request, $id): JsonResponse {
        try {
            $reports = Reports::find($id);

            if (!reports) {
                return $this->error('Reports not found', null, 404);
            }

            $reports->update($request->validated());
            return $this->success($reports, 'Reports updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update reports: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified reports
     */
    public function destroy($id): JsonResponse {
        try {
            $reports = Reports::find($id);

            if (!reports) {
                return $this->error('Reports not found', null, 404);
            }

            $reports->delete();
            return $this->success(null, 'Reports deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete reports: ' . $e->getMessage(), null, 500);
        }
    }
}