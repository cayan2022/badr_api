<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\NotBlockedUser;
use Doctrine\Inflector\Rules\NorwegianBokmal\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            'username' => ['required','email:rfc,dns',Rule::exists('users','email'),new NotBlockedUser],
            'password'=>['required','string']
        ];
    }

    public function attributes()
    {
        return [
            'username'=>trans('auth.attributes.email'),
            'password'=>trans('auth.attributes.password'),
        ];
    }
}
