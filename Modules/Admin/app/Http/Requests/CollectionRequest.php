<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
     
        // dd($this->all());
        unset($this->all()['files-data']);
        return [
            'title'=> 'required|min:3|max:255',
            'slug'=> 'nullable|min:3|max:255',
            'description'=> 'nullable|min:3',
            'status'=> 'required|string|in:active,archived', // Assuming 'active' and 'archived' are valid statuses
            'tags'=> 'nullable|string',
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
