<?php

namespace App\Http\Requests\Api\Site;

use App\Models\Country;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'source_id' => 'required|integer|exists:sources,id',
            'category_id' => 'required|integer|exists:categories,id',
            'branch_id'=>'required|integer|exists:branches,id',
            'phone'=>['required',Rule::phone()->country(Country::query()->pluck('iso_code')->toArray())],
            'email'=>['required', 'email:rfc,dns']
        ];
    }
}
