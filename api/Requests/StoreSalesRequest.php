<?php

namespace App\Http\Requests;

use App\Api\BaseRequest;

class StoreSalesRequest extends BaseRequest {

    public function authorize(): bool {
        return auth()->check();
    }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}