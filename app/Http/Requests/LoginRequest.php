<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    // Determine if the user is authorized to make this request
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ];
    }

    // Custom validation messages
    public function messages()
    {
        return [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
        ];
    }
}