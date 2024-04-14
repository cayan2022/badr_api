<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Support\Facades\Auth;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
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
                                     '%full_description%' => ['required', 'string'],
                                     '%city%' => 'required|string|max:255',
                                     '%address%' => 'required|string|max:255',
                                     'telephone' => 'required|string|max:255',
                                     'whatsapp' => 'required|string|max:255',
                                     'map' => 'required|url',
                                     'image' => ['nullable', new SupportedImage()]
                                 ]);
    }
}
