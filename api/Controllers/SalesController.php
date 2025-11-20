<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesController extends BaseController {

    /**
     * Display a listing of sales
     */
    public function index(Request $request): JsonResponse {
        $query = Sales::query();

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
     * Store a newly created sales
     */
    public function store(StoreSalesRequest $request): JsonResponse {
        try {
            $sales = Sales::create($request->validated());
            return $this->success($sales, 'Sales created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create sales: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified sales
     */
    public function show($id): JsonResponse {
        $sales = Sales::find($id);

        if (!sales) {
            return $this->error('Sales not found', null, 404);
        }

        return $this->success($sales);
    }

    /**
     * Update the specified sales
     */
    public function update(UpdateSalesRequest $request, $id): JsonResponse {
        try {
            $sales = Sales::find($id);

            if (!sales) {
                return $this->error('Sales not found', null, 404);
            }

            $sales->update($request->validated());
            return $this->success($sales, 'Sales updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update sales: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified sales
     */
    public function destroy($id): JsonResponse {
        try {
            $sales = Sales::find($id);

            if (!sales) {
                return $this->error('Sales not found', null, 404);
            }

            $sales->delete();
            return $this->success(null, 'Sales deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete sales: ' . $e->getMessage(), null, 500);
        }
    }
}