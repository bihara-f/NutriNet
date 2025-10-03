<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Za-zÀ-ÿĀ-žА-я\s]+$/u' // Only letters and spaces
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users,email'
            ],
            'contact_number' => [
                'required',
                'digits_between:10,15',
                'regex:/^[0-9]+$/' // Digits only
            ],
            'username' => [
                'required',
                'string',
                'min:4',
                'max:50',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/' // Alphanumeric and underscore only
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8'
            ],
            'gender' => [
                'required',
                'in:male,female,other'
            ],
            'terms' => [
                'required',
                'accepted'
            ]
        ];
    }

    // Custom validation messages
    public function messages()
    {
        return [
            'name.required' => 'Full name is required.',
            'name.string' => 'Full name must be a valid string.',
            'name.min' => 'Full name must be at least 3 characters long.',
            'name.max' => 'Full name cannot exceed 100 characters.',
            'name.regex' => 'Full name can only contain letters and spaces.',
            
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            'email.unique' => 'This email address is already registered.',
            
            'contact_number.required' => 'Contact number is required.',
            'contact_number.digits_between' => 'Contact number must be between 10 and 15 digits.',
            'contact_number.regex' => 'Contact number can only contain digits.',
            
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 4 characters long.',
            'username.max' => 'Username cannot exceed 50 characters.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            
            'password_confirmation.required' => 'Password confirmation is required.',
            'password_confirmation.min' => 'Password confirmation must be at least 8 characters long.',
            
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Please select a valid gender option (male, female, or other).',
            
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must accept the terms and conditions to register.',
        ];
    }
}