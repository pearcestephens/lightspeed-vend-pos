<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntegrationsController extends BaseController {

    /**
     * Display a listing of integrations
     */
    public function index(Request $request): JsonResponse {
        $query = Integrations::query();

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
     * Store a newly created integrations
     */
    public function store(StoreIntegrationsRequest $request): JsonResponse {
        try {
            $integrations = Integrations::create($request->validated());
            return $this->success($integrations, 'Integrations created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create integrations: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified integrations
     */
    public function show($id): JsonResponse {
        $integrations = Integrations::find($id);

        if (!integrations) {
            return $this->error('Integrations not found', null, 404);
        }

        return $this->success($integrations);
    }

    /**
     * Update the specified integrations
     */
    public function update(UpdateIntegrationsRequest $request, $id): JsonResponse {
        try {
            $integrations = Integrations::find($id);

            if (!integrations) {
                return $this->error('Integrations not found', null, 404);
            }

            $integrations->update($request->validated());
            return $this->success($integrations, 'Integrations updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update integrations: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified integrations
     */
    public function destroy($id): JsonResponse {
        try {
            $integrations = Integrations::find($id);

            if (!integrations) {
                return $this->error('Integrations not found', null, 404);
            }

            $integrations->delete();
            return $this->success(null, 'Integrations deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete integrations: ' . $e->getMessage(), null, 500);
        }
    }
}