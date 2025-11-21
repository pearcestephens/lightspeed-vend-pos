<?php

namespace App\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseControllerClass;

class BaseController extends BaseControllerClass {

    /**
     * Return success response
     */
    protected function success($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return error response
     */
    protected function error(string $message = 'Error', $data = null, int $statusCode = 400): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'error' => true,
        ], $statusCode);
    }

    /**
     * Return paginated response
     */
    protected function paginated($items, string $message = 'Success'): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $items->items(),
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    /**
     * Rate limiting check
     */
    protected function checkRateLimit(Request $request, int $limit = 100, int $minutes = 1): bool {
        return $request->user()->rateLimit($limit, $minutes);
    }
}