<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends BaseController {

    /**
     * Display a listing of products
     */
    public function index(Request $request): JsonResponse {
        $query = Products::query();

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
     * Store a newly created products
     */
    public function store(StoreProductsRequest $request): JsonResponse {
        try {
            $products = Products::create($request->validated());
            return $this->success($products, 'Products created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create products: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified products
     */
    public function show($id): JsonResponse {
        $products = Products::find($id);

        if (!products) {
            return $this->error('Products not found', null, 404);
        }

        return $this->success($products);
    }

    /**
     * Update the specified products
     */
    public function update(UpdateProductsRequest $request, $id): JsonResponse {
        try {
            $products = Products::find($id);

            if (!products) {
                return $this->error('Products not found', null, 404);
            }

            $products->update($request->validated());
            return $this->success($products, 'Products updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update products: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified products
     */
    public function destroy($id): JsonResponse {
        try {
            $products = Products::find($id);

            if (!products) {
                return $this->error('Products not found', null, 404);
            }

            $products->delete();
            return $this->success(null, 'Products deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete products: ' . $e->getMessage(), null, 500);
        }
    }
}