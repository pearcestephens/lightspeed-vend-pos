<?php

namespace App\Api;

class APIResponse {

    public static function success($data = null, string $message = 'Success', int $code = 200): array {
        return [
            'success' => true,
            'message' => $message,
            'code' => $code,
            'data' => $data,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public static function error(string $message = 'Error', ?array $errors = null, int $code = 400): array {
        return [
            'success' => false,
            'message' => $message,
            'code' => $code,
            'errors' => $errors,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public static function paginated($items, string $message = 'Success'): array {
        return [
            'success' => true,
            'message' => $message,
            'data' => $items->items(),
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'has_more' => $items->hasMorePages(),
            ],
            'timestamp' => now()->toIso8601String(),
        ];
    }
}