<?php

namespace App\Http\Controllers\Api;

use App\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistersController extends BaseController {

    /**
     * Display a listing of registers
     */
    public function index(Request $request): JsonResponse {
        $query = Registers::query();

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
     * Store a newly created registers
     */
    public function store(StoreRegistersRequest $request): JsonResponse {
        try {
            $registers = Registers::create($request->validated());
            return $this->success($registers, 'Registers created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create registers: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified registers
     */
    public function show($id): JsonResponse {
        $registers = Registers::find($id);

        if (!registers) {
            return $this->error('Registers not found', null, 404);
        }

        return $this->success($registers);
    }

    /**
     * Update the specified registers
     */
    public function update(UpdateRegistersRequest $request, $id): JsonResponse {
        try {
            $registers = Registers::find($id);

            if (!registers) {
                return $this->error('Registers not found', null, 404);
            }

            $registers->update($request->validated());
            return $this->success($registers, 'Registers updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update registers: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Delete the specified registers
     */
    public function destroy($id): JsonResponse {
        try {
            $registers = Registers::find($id);

            if (!registers) {
                return $this->error('Registers not found', null, 404);
            }

            $registers->delete();
            return $this->success(null, 'Registers deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete registers: ' . $e->getMessage(), null, 500);
        }
    }
}