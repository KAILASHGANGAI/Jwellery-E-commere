<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        
        return [
            'title' => 'required|string|max:255',
            'status' => 'default:0',
            'country' => 'nullable',
            'status' => 'required|string|in:1,0', // Assuming 'active' and 'archived' are valid statuses
            'city' => 'required',
            'zipcode' => 'required',
            'amount' => 'required|numeric'
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
