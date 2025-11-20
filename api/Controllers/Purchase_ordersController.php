<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Purchase_ordersController extends BaseController {

    /**
     * Display a listing of purchase_orders
     */
    public function index(Request $request): JsonResponse {
        $query = Purchase_orders::query();

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
     * Store a newly created purchase_orders
     */
    public function store(StorePurchase_ordersRequest $request): JsonResponse {
        try {
            $purchase_orders = Purchase_orders::create($request->validated());
            return $this->success($purchase_orders, 'Purchase_orders created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create purchase_orders: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified purchase_orders
     */
    public function show($id): JsonResponse {
        $purchase_orders = Purchase_orders::find($id);

        if (!purchase_orders) {
            return $this->error('Purchase_orders not found', null, 404);
        }

        return $this->success($purchase_orders);
    }

    /**
     * Update the specified purchase_orders
     */
    public function update(UpdatePurchase_ordersRequest $request, $id): JsonResponse {
        try {
            $purchase_orders = Purchase_orders::find($id);

            if (!purchase_orders) {
                return $this->error('Purchase_orders not found', null, 404);
            }

            $purchase_orders->update($request->validated());
            return $this->success($purchase_orders, 'Purchase_orders updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update purchase_orders: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified purchase_orders
     */
    public function destroy($id): JsonResponse {
        try {
            $purchase_orders = Purchase_orders::find($id);

            if (!purchase_orders) {
                return $this->error('Purchase_orders not found', null, 404);
            }

            $purchase_orders->delete();
            return $this->success(null, 'Purchase_orders deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete purchase_orders: ' . $e->getMessage(), null, 500);
        }
    }
}