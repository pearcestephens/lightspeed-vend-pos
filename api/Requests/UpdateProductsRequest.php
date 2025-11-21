<?php

namespace App\Http\Requests;

use App\Api\BaseRequest;

class UpdateProductsRequest extends BaseRequest {

    public function authorize(): bool {
        return auth()->check();
    }

    public function rules(): array {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}