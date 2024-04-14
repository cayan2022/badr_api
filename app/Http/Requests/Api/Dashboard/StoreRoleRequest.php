<?php

namespace App\Http\Requests\Api\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','unique:roles','string', 'max:255'],
            'requested_permissions'=>['required','array'],
            'requested_permissions.*'=>'required|numeric|exists:permissions,id,guard_name,api'
        ];
    }
}
