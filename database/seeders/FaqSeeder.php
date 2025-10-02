<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'What is a personalized diet plan?',
                'answer' => 'A personalized diet plan is a customized nutrition program tailored specifically to your individual needs, health goals, dietary preferences, and lifestyle. Our expert nutritionists analyze your current health status, BMI, food preferences, and fitness goals to create a meal plan that works best for you.'
            ],
            [
                'question' => 'How long does it take to see results?',
                'answer' => 'Results vary from person to person depending on various factors such as starting weight, adherence to the plan, physical activity level, and individual metabolism. Generally, you can expect to see initial changes within 2-4 weeks, with more significant results becoming apparent after 8-12 weeks of consistent following of your personalized plan.'
            ],
            [
                'question' => 'Can I modify my diet plan?',
                'answer' => 'Absolutely! Your diet plan is flexible and can be adjusted based on your progress, changing preferences, or lifestyle modifications. We encourage regular check-ins with our nutritionists to ensure your plan remains effective and enjoyable. You can request modifications through your user profile or by contacting our support team.'
            ],
            [
                'question' => 'Are the meal plans suitable for vegetarians/vegans?',
                'answer' => 'Yes, we offer comprehensive meal plans for all dietary preferences including vegetarian, vegan, keto, paleo, Mediterranean, and more. When creating your profile, simply specify your dietary restrictions and preferences, and our nutritionists will ensure your plan aligns with your lifestyle choices while meeting all your nutritional needs.'
            ],
            [
                'question' => 'What support do I get with my plan?',
                'answer' => 'With your diet plan, you receive comprehensive support including: weekly check-ins with certified nutritionists, 24/7 customer support, access to our mobile app for meal tracking, recipe suggestions, shopping lists, progress monitoring tools, and a community forum where you can connect with others on similar journeys.'
            ],
            [
                'question' => 'How much does a diet plan cost?',
                'answer' => 'We offer various packages to suit different needs and budgets. Our basic diet plan starts at 700 LKR, fitness training at 700 LKR, and nutritional guidelines at 700 LKR. We also have combination packages like Diet Plan + Fitness Training for 1000 LKR, and our comprehensive All-in-One package for 1600 LKR. All plans include ongoing support and regular updates.'
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}