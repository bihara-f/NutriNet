<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class PaymentRequest extends FormRequest
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
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Za-zÀ-ÿĀ-žА-я\s]+$/u' // Only letters and spaces
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],
            'card_number' => [
                'required',
                'digits:16',
                'regex:/^[0-9]{16}$/' // Exactly 16 digits
            ],
            'expiry_date' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/', // MM/YY format
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value, $matches)) {
                        $month = (int) $matches[1];
                        $year = 2000 + (int) $matches[2]; // Convert YY to YYYY
                        
                        $currentYear = Carbon::now()->year;
                        $currentMonth = Carbon::now()->month;
                        
                        // Check if card is expired
                        if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                            $fail('The card has expired.');
                        }
                        
                        // Check if year is more than 5 years in the future
                        if ($year > $currentYear + 5) {
                            $fail('The expiry year cannot be more than 5 years in the future.');
                        }
                    }
                }
            ],
            'cvv' => [
                'required',
                'digits:3',
                'regex:/^[0-9]{3}$/' // Exactly 3 digits
            ],
            'package' => [
                'required',
                'in:diet_plan,fitness_training,nutritional_guidelines,diet_fitness,nutritional_fitness,all_in_one'
            ],
            'amount' => [
                'required',
                'numeric',
                'in:700,1000,1200,1600'
            ]
        ];
    }

    // Custom validation messages
    public function messages()
    {
        return [
            'full_name.required' => 'Full name on card is required.',
            'full_name.string' => 'Full name must be a valid string.',
            'full_name.min' => 'Full name must be at least 3 characters long.',
            'full_name.max' => 'Full name cannot exceed 100 characters.',
            'full_name.regex' => 'Full name can only contain letters and spaces.',
            
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            
            'card_number.required' => 'Card number is required.',
            'card_number.digits' => 'Card number must be exactly 16 digits.',
            'card_number.regex' => 'Card number must contain only digits.',
            
            'expiry_date.required' => 'Expiration date is required.',
            'expiry_date.regex' => 'Expiration date must be in MM/YY format.',
            
            'cvv.required' => 'CVV is required.',
            'cvv.digits' => 'CVV must be exactly 3 digits.',
            'cvv.regex' => 'CVV must contain only digits.',
            
            'package.required' => 'Package selection is required.',
            'package.in' => 'Please select a valid package option.',
            
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.in' => 'Please select a valid package amount (700, 1000, 1200, or 1600 LKR).',
        ];
    }

    // Define package options and their corresponding amounts
    public static function getPackageOptions()
    {
        return [
            'diet_plan' => [
                'name' => 'Diet Plan',
                'amount' => 700,
                'description' => 'Personalized diet planning'
            ],
            'fitness_training' => [
                'name' => 'Fitness Training',
                'amount' => 700,
                'description' => 'Professional fitness training'
            ],
            'nutritional_guidelines' => [
                'name' => 'Nutritional Guidelines',
                'amount' => 700,
                'description' => 'Expert nutritional advice'
            ],
            'diet_fitness' => [
                'name' => 'Diet Plan + Fitness Training',
                'amount' => 1000,
                'description' => 'Combined diet and fitness package'
            ],
            'nutritional_fitness' => [
                'name' => 'Nutritional Guidelines + Fitness Training',
                'amount' => 1200,
                'description' => 'Nutrition and fitness combo'
            ],
            'all_in_one' => [
                'name' => 'All in One Package',
                'amount' => 1600,
                'description' => 'Complete health and fitness solution'
            ]
        ];
    }
}