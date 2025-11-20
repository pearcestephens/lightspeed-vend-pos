<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends BaseController {

    /**
     * Display a listing of analytics
     */
    public function index(Request $request): JsonResponse {
        $query = Analytics::query();

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
     * Store a newly created analytics
     */
    public function store(StoreAnalyticsRequest $request): JsonResponse {
        try {
            $analytics = Analytics::create($request->validated());
            return $this->success($analytics, 'Analytics created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create analytics: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified analytics
     */
    public function show($id): JsonResponse {
        $analytics = Analytics::find($id);

        if (!analytics) {
            return $this->error('Analytics not found', null, 404);
        }

        return $this->success($analytics);
    }

    /**
     * Update the specified analytics
     */
    public function update(UpdateAnalyticsRequest $request, $id): JsonResponse {
        try {
            $analytics = Analytics::find($id);

            if (!analytics) {
                return $this->error('Analytics not found', null, 404);
            }

            $analytics->update($request->validated());
            return $this->success($analytics, 'Analytics updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update analytics: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified analytics
     */
    public function destroy($id): JsonResponse {
        try {
            $analytics = Analytics::find($id);

            if (!analytics) {
                return $this->error('Analytics not found', null, 404);
            }

            $analytics->delete();
            return $this->success(null, 'Analytics deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete analytics: ' . $e->getMessage(), null, 500);
        }
    }
}