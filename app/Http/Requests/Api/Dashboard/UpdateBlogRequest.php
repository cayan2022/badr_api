<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBlogRequest extends FormRequest
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
                                     '%title%' => ['required', 'string', 'max:255'],
                                     '%short_description%' => ['required', 'string', 'max:255'],
                                     '%long_description%' => ['required', 'string'],
                                     'image' => ['nullable', new SupportedImage()],
                                     'reference_link' => 'nullable|url',
                                     'date' => 'required|date'
                                 ]);
    }
}
