<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomersController extends BaseController {

    /**
     * Display a listing of customers
     */
    public function index(Request $request): JsonResponse {
        $query = Customers::query();

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
     * Store a newly created customers
     */
    public function store(StoreCustomersRequest $request): JsonResponse {
        try {
            $customers = Customers::create($request->validated());
            return $this->success($customers, 'Customers created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create customers: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified customers
     */
    public function show($id): JsonResponse {
        $customers = Customers::find($id);

        if (!customers) {
            return $this->error('Customers not found', null, 404);
        }

        return $this->success($customers);
    }

    /**
     * Update the specified customers
     */
    public function update(UpdateCustomersRequest $request, $id): JsonResponse {
        try {
            $customers = Customers::find($id);

            if (!customers) {
                return $this->error('Customers not found', null, 404);
            }

            $customers->update($request->validated());
            return $this->success($customers, 'Customers updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update customers: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified customers
     */
    public function destroy($id): JsonResponse {
        try {
            $customers = Customers::find($id);

            if (!customers) {
                return $this->error('Customers not found', null, 404);
            }

            $customers->delete();
            return $this->success(null, 'Customers deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete customers: ' . $e->getMessage(), null, 500);
        }
    }
}