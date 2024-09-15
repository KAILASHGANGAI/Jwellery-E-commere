<?php

namespace Modules\AuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required |max:255',
            'phone' => 'required |max:255',
            'email' => 'required|email |max:255|unique:admin_users,email',
            'password' => 'required |min:6 |confirmed',
            'status' => 'required',
            'is_super_admin' => 'nullable',
       
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
