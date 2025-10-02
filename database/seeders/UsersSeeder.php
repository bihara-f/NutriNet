<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    // Run the database seeder
    public function run(): void
    {
        // Create first user
        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice.johnson@dietplan.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create second user
        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob.wilson@dietplan.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('2 users have been created successfully!');
        $this->command->info('User 1: alice.johnson@dietplan.com (password: password123)');
        $this->command->info('User 2: bob.wilson@dietplan.com (password: password123)');
    }
}