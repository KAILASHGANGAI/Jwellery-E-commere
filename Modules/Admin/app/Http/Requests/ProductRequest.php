<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // dd($this->title);
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files-data' => 'nullable|file', // Assuming it's a file upload
            'price' => 'nullable|numeric', // Validate as a numeric value
            'compare_price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'name' => 'nullable|array',
            'name.*' => 'nullable|string|max:255', // Validate each element in the name array
            'sku' => 'required|array',
            'sku.*' => 'nullable|string|max:255', // Validate each element in the SKU array
            'barcode' => 'nullable|array',
            'barcode.*' => 'nullable|string|max:255', // Validate each element in the barcode array
            'inventory' => 'nullable|array',
            'inventory.*' => 'nullable|integer|min:0', // Validate each element in the inventory array
            'status' => 'required|string|in:active,archived', // Assuming 'active' and 'archived' are valid statuses
            'display' => 'required|string|in:on,off', // Assuming 'on' and 'off' are valid options
            'vendor' => 'nullable|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'collections' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
