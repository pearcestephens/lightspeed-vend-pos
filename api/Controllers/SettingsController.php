<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends BaseController {

    /**
     * Display a listing of settings
     */
    public function index(Request $request): JsonResponse {
        $query = Settings::query();

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
     * Store a newly created settings
     */
    public function store(StoreSettingsRequest $request): JsonResponse {
        try {
            $settings = Settings::create($request->validated());
            return $this->success($settings, 'Settings created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create settings: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified settings
     */
    public function show($id): JsonResponse {
        $settings = Settings::find($id);

        if (!settings) {
            return $this->error('Settings not found', null, 404);
        }

        return $this->success($settings);
    }

    /**
     * Update the specified settings
     */
    public function update(UpdateSettingsRequest $request, $id): JsonResponse {
        try {
            $settings = Settings::find($id);

            if (!settings) {
                return $this->error('Settings not found', null, 404);
            }

            $settings->update($request->validated());
            return $this->success($settings, 'Settings updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update settings: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified settings
     */
    public function destroy($id): JsonResponse {
        try {
            $settings = Settings::find($id);

            if (!settings) {
                return $this->error('Settings not found', null, 404);
            }

            $settings->delete();
            return $this->success(null, 'Settings deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete settings: ' . $e->getMessage(), null, 500);
        }
    }
}