<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
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
        return RuleFactory::make([
             '%name%' => [
                 'required',
                 'string',
                 'max:255'
             ],
             '%description%' => ['required', 'string','max:255'],
             'category_id' => 'required|numeric|exists:categories,id',
             'image' => ['nullable', new SupportedImage()]
         ]);
    }
}
