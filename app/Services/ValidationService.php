<?php

namespace App\Services;

class ValidationService
{
    // Package validation options
    public static function getPackageValidationRules()
    {
        return [
            'diet_plan' => [
                'name' => 'Diet Plan',
                'amount' => 700,
                'description' => 'Personalized diet planning with nutritionist guidance',
                'features' => ['Custom meal plans', 'Nutritional analysis', 'Weekly consultations']
            ],
            'fitness_training' => [
                'name' => 'Fitness Training',
                'amount' => 700,
                'description' => 'Professional fitness training with certified trainers',
                'features' => ['Personal training sessions', 'Workout plans', 'Progress tracking']
            ],
            'nutritional_guidelines' => [
                'name' => 'Nutritional Guidelines',
                'amount' => 700,
                'description' => 'Expert nutritional advice and guidelines',
                'features' => ['Nutrition education', 'Supplement advice', 'Health monitoring']
            ],
            'diet_fitness' => [
                'name' => 'Diet Plan + Fitness Training',
                'amount' => 1000,
                'description' => 'Combined diet and fitness package for optimal results',
                'features' => ['All diet plan features', 'All fitness training features', 'Integrated approach']
            ],
            'nutritional_fitness' => [
                'name' => 'Nutritional Guidelines + Fitness Training',
                'amount' => 1200,
                'description' => 'Nutrition and fitness combo for complete wellness',
                'features' => ['All nutritional features', 'All fitness features', 'Wellness coaching']
            ],
            'all_in_one' => [
                'name' => 'All in One Package',
                'amount' => 1600,
                'description' => 'Complete health and fitness solution with all features',
                'features' => ['All available features', 'Priority support', 'Monthly health assessments']
            ]
        ];
    }

    // Get package amount by key
    public static function getPackageAmount(string $packageKey): ?int
    {
        $packages = self::getPackageValidationRules();
        return $packages[$packageKey]['amount'] ?? null;
    }

    // Validate package selection
    public static function isValidPackage(string $packageKey): bool
    {
        return array_key_exists($packageKey, self::getPackageValidationRules());
    }

    // Get all valid package keys
    public static function getValidPackageKeys(): array
    {
        return array_keys(self::getPackageValidationRules());
    }

    // Get all valid amounts
    public static function getValidAmounts(): array
    {
        return array_unique(array_column(self::getPackageValidationRules(), 'amount'));
    }

    // User validation rules
    public static function getUserValidationRules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Za-zÀ-ÿĀ-žА-я\s]+$/u'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],
            'username' => [
                'required',
                'string',
                'min:4',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'contact_number' => [
                'required',
                'digits_between:10,15',
                'regex:/^[0-9]+$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'gender' => [
                'required',
                'in:male,female,other'
            ]
        ];
    }

    // Payment validation rules
    public static function getPaymentValidationRules(): array
    {
        return [
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Za-zÀ-ÿĀ-žА-я\s]+$/u'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],
            'card_number' => [
                'required',
                'digits:16',
                'regex:/^[0-9]{16}$/'
            ],
            'cvv' => [
                'required',
                'digits:3',
                'regex:/^[0-9]{3}$/'
            ]
        ];
    }

    // Custom validation messages
    public static function getValidationMessages(): array
    {
        return [
            'name.regex' => 'Name can only contain letters and spaces.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'contact_number.digits_between' => 'Contact number must be between 10 and 15 digits.',
            'contact_number.regex' => 'Contact number can only contain digits.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            'card_number.digits' => 'Card number must be exactly 16 digits.',
            'card_number.regex' => 'Card number must contain only digits.',
            'cvv.digits' => 'CVV must be exactly 3 digits.',
            'cvv.regex' => 'CVV must contain only digits.',
            'full_name.regex' => 'Full name can only contain letters and spaces.',
        ];
    }
}