<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ShowUsers extends Command
{
    // Command signature for Artisan
    protected $signature = 'users:show';

    // Command description
    protected $description = 'Display all users in the database';

    // Execute the console command
    public function handle()
    {
        $users = User::all(['id', 'name', 'email', 'created_at']);
        
        $this->info('Total users in database: ' . $users->count());
        $this->line('');
        
        if ($users->count() > 0) {
            $this->table(
                ['ID', 'Name', 'Email', 'Created At'],
                $users->map(function ($user) {
                    return [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->created_at->format('Y-m-d H:i:s')
                    ];
                })->toArray()
            );
        } else {
            $this->warn('No users found in the database.');
        }
        
        return Command::SUCCESS;
    }
}