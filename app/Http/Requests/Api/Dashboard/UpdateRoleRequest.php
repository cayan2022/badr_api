<?php

namespace App\Http\Requests\Api\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => ['required','string', 'max:255',Rule::unique('roles','name')->ignore($this->id)],
            'requested_permissions'=>['required','array'],
            'requested_permissions.*'=>'required|numeric|exists:permissions,id,guard_name,api'
        ];
    }
}
