<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends BaseController {

    /**
     * Display a listing of inventory
     */
    public function index(Request $request): JsonResponse {
        $query = Inventory::query();

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
     * Store a newly created inventory
     */
    public function store(StoreInventoryRequest $request): JsonResponse {
        try {
            $inventory = Inventory::create($request->validated());
            return $this->success($inventory, 'Inventory created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create inventory: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified inventory
     */
    public function show($id): JsonResponse {
        $inventory = Inventory::find($id);

        if (!inventory) {
            return $this->error('Inventory not found', null, 404);
        }

        return $this->success($inventory);
    }

    /**
     * Update the specified inventory
     */
    public function update(UpdateInventoryRequest $request, $id): JsonResponse {
        try {
            $inventory = Inventory::find($id);

            if (!inventory) {
                return $this->error('Inventory not found', null, 404);
            }

            $inventory->update($request->validated());
            return $this->success($inventory, 'Inventory updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update inventory: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified inventory
     */
    public function destroy($id): JsonResponse {
        try {
            $inventory = Inventory::find($id);

            if (!inventory) {
                return $this->error('Inventory not found', null, 404);
            }

            $inventory->delete();
            return $this->success(null, 'Inventory deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete inventory: ' . $e->getMessage(), null, 500);
        }
    }
}