<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserApiRequest extends FormRequest
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
        $rules= [
          'full_name' => 'required|string',
          'email' => 'required|string|email',
          'password' => 'required|string|confirmed',
          'password_confirmation' => 'required',
          'id_rol' => 'required',
          'user_photo' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
          'full_name.required' => __('validation.required', ['attribute' => 'full_name']),
          'email.required' => __('validation.required', ['attribute' => 'email']),
          'password.required' => __('validation.required', ['attribute' => 'password']),
          'password_confirmation.required' => __('validation.required', ['attribute' => 'password_confirmation']),
          'id_rol.required' => __('validation.required', ['attribute' => 'id_rol']),
          'user_photo.required' => __('validation.required', ['attribute' => 'user_photo']),
        ];
    }
}
