<?php

namespace App\Api;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [];
    }

    public function messages(): array {
        return [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            'confirmed' => 'The :attribute confirmation does not match.',
        ];
    }
}