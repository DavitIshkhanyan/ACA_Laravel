<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        return
            [
                'first_name' => 'required|max:255|min:3',
                'last_name' => 'required|max:255|min:3',
                'email' => 'required|email:rfc|unique:users,email',
                'type' => ['required', Rule::in([User::TYPE_BUYER, User::TYPE_SELLER])],
                'gender' => ['required', Rule::in(['male', 'female'])],
                'username' => 'required|unique:users,username|max:255|min:3',
                'password' => 'required|max:255|min:3'
            ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
