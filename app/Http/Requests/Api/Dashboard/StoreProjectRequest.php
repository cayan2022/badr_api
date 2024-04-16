<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class StoreProjectRequest extends FormRequest
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
            '%name%' => ['required', 'string', 'max:255'],
            '%title%' => ['nullable', 'array'],
            '%title.*%' => ['required', 'string', 'max:255'],
            '%classification%' => ['required', 'string', 'max:255'],
            '%short_description%' => ['required', 'string'],
            '%full_description%' => ['required', 'string'],
            'image' => ['nullable', new SupportedImage()],
            'developer_name' => 'required|string|max:255',
            'developer_image' => ['nullable', new SupportedImage()],
            'owner_name' => 'required|string|max:255',
            'owner_image' => ['nullable', new SupportedImage()],
            'area' => 'required|numeric',
            'building_area' => 'required|numeric',
            'buildings_number' => 'required|integer',
            'project_sliders' => ['nullable', 'array'],
            'project_sliders.*' => ['required', 'image', new SupportedImage()],
        ]);
    }
}
