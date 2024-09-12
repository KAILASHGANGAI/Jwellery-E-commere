<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftCardRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required |min:3|max:255',
            'code' => 'required |min:3|max:255',
            'expiry_date' => 'required |date',
            'description' => 'nullable |min:3|max:255',
            'value' => 'required |numeric',
            'product_id' => 'nullable |numeric',
            'collection_id' => 'nullable |numeric',
            'customer_id' => 'nullable |numeric',
        ];
    }

    //
    public function messages(): array
    {
        return [
            'customer_id.required' => 'Customer is required',
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
