<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@nutrinet.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@nutrinet.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Create some sample packages if they don't exist
        \App\Models\Package::updateOrCreate(
            ['package_name' => 'Basic Diet Plan'],
            [
                'package_name' => 'Basic Diet Plan',
                'package_price' => 5000.00,
                'package_description' => 'A basic diet plan for beginners'
            ]
        );

        \App\Models\Package::updateOrCreate(
            ['package_name' => 'Premium Diet Plan'],
            [
                'package_name' => 'Premium Diet Plan',
                'package_price' => 10000.00,
                'package_description' => 'A comprehensive diet plan with personalized guidance'
            ]
        );

        \App\Models\Package::updateOrCreate(
            ['package_name' => 'Fitness & Diet Combo'],
            [
                'package_name' => 'Fitness & Diet Combo',
                'package_price' => 15000.00,
                'package_description' => 'Complete fitness and diet package'
            ]
        );

        // Create some sample FAQs if they don't exist
        \App\Models\Faq::updateOrCreate(
            ['question' => 'How do I get started with my diet plan?'],
            [
                'question' => 'How do I get started with my diet plan?',
                'answer' => 'After purchasing a package, you will receive a personalized diet plan within 24 hours. Our nutritionists will create a plan based on your health profile and goals.'
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'Can I modify my diet plan?'],
            [
                'question' => 'Can I modify my diet plan?',
                'answer' => 'Yes, you can request modifications to your diet plan. Our team will review your request and update your plan accordingly to better suit your needs and preferences.'
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'What payment methods do you accept?'],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards, debit cards, and online banking transfers. All payments are processed securely through our payment gateway.'
            ]
        );
    }
}