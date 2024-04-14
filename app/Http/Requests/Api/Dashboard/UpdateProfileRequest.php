<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Models\User;
use App\Models\Country;
use App\Rules\SupportedImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'email'    => ['required','email:rfc,dns',Rule::unique('users','email')->ignore($this->user->id)],
            'country_id'    => 'required|numeric|exists:countries,id',
            'phone'    => ['required',Rule::unique('users','phone')->ignore( $this->user->id),Rule::phone()->country(Country::query()->pluck('iso_code')->toArray())],
            'password' => ['sometimes','required', 'confirmed','string', Password::defaults()],
            'image' => ['nullable',new SupportedImage()],
            'role_id' => 'required|numeric|exists:roles,id',
        ];
    }
}
