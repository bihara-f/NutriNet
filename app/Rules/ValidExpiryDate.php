<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class ValidExpiryDate implements ValidationRule
{
    // Run the validation rule
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value, $matches)) {
            $fail('The :attribute must be in MM/YY format.');
            return;
        }

        $month = (int) $matches[1];
        $year = 2000 + (int) $matches[2]; // Convert YY to YYYY
        
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        // Check if card is expired
        if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
            $fail('The card has expired.');
            return;
        }
        
        // Check if year is more than 5 years in the future
        if ($year > $currentYear + 5) {
            $fail('The expiry year cannot be more than 5 years in the future.');
            return;
        }
    }
}