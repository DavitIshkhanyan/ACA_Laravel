<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'gender' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'type' => 'required|in:' . implode(',', array_keys(User::TYPE_SLUGS)),
//            'username' => 'required|string|unique:users,username|min:3|max:255', // avelacnel
            'password' => 'required|string|confirmed|min:6',
        ];
    }
}
