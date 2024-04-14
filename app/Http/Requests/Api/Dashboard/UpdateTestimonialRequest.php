<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTestimonialRequest extends FormRequest
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
            'user_name'=>'required|string|max:255',
            'comment'=>'required|string|max:255',
            'job'=>'required|string|max:255',
            'image' => ['nullable',new SupportedImage()]
        ];
    }
}
