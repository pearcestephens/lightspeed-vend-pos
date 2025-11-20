<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuppliersController extends BaseController {

    /**
     * Display a listing of suppliers
     */
    public function index(Request $request): JsonResponse {
        $query = Suppliers::query();

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
     * Store a newly created suppliers
     */
    public function store(StoreSuppliersRequest $request): JsonResponse {
        try {
            $suppliers = Suppliers::create($request->validated());
            return $this->success($suppliers, 'Suppliers created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create suppliers: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified suppliers
     */
    public function show($id): JsonResponse {
        $suppliers = Suppliers::find($id);

        if (!suppliers) {
            return $this->error('Suppliers not found', null, 404);
        }

        return $this->success($suppliers);
    }

    /**
     * Update the specified suppliers
     */
    public function update(UpdateSuppliersRequest $request, $id): JsonResponse {
        try {
            $suppliers = Suppliers::find($id);

            if (!suppliers) {
                return $this->error('Suppliers not found', null, 404);
            }

            $suppliers->update($request->validated());
            return $this->success($suppliers, 'Suppliers updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update suppliers: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified suppliers
     */
    public function destroy($id): JsonResponse {
        try {
            $suppliers = Suppliers::find($id);

            if (!suppliers) {
                return $this->error('Suppliers not found', null, 404);
            }

            $suppliers->delete();
            return $this->success(null, 'Suppliers deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete suppliers: ' . $e->getMessage(), null, 500);
        }
    }
}