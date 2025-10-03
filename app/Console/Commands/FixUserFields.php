<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class FixUserFields extends Command
{
    // Command signature
    protected $signature = 'users:fix-fields';

    // Command description
    protected $description = 'Fix missing username, contact_number, and gender fields for existing users';

    // Execute the command
    public function handle()
    {
        $users = User::all();
        $updated = 0;

        foreach ($users as $user) {
            $needsUpdate = false;

            if (empty($user->username)) {
                $user->username = strtolower(str_replace(' ', '', $user->name)) . $user->id;
                $needsUpdate = true;
            }

            if (empty($user->contact_number)) {
                $user->contact_number = '1234567890';
                $needsUpdate = true;
            }

            if (empty($user->gender)) {
                $user->gender = 'other';
                $needsUpdate = true;
            }

            if ($needsUpdate) {
                $user->save();
                $updated++;
                $this->info("Updated user: {$user->name} (ID: {$user->id})");
            }
        }

        $this->info("Successfully updated {$updated} users.");
        return Command::SUCCESS;
    }
}