<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HashAllPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:hash-passwords {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash all plain text passwords in the users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for plain text passwords...');
        
        $users = User::all();
        $plainTextUsers = [];
        
        foreach ($users as $user) {
            // Check if password looks like plain text (not starting with $2y$)
            if (!str_starts_with($user->password, '$2y$')) {
                $plainTextUsers[] = $user;
            }
        }
        
        if (empty($plainTextUsers)) {
            $this->info('All passwords are already hashed!');
            return 0;
        }
        
        $this->warn("Found " . count($plainTextUsers) . " users with plain text passwords:");
        
        foreach ($plainTextUsers as $user) {
            $this->line("- {$user->email} (ID: {$user->id})");
        }
        
        if ($this->option('dry-run')) {
            $this->info('Dry run mode - no changes made.');
            return 0;
        }
        
        if (!$this->confirm('Do you want to hash these passwords?')) {
            $this->info('Operation cancelled.');
            return 0;
        }
        
        $this->info('Hashing passwords...');
        $bar = $this->output->createProgressBar(count($plainTextUsers));
        $bar->start();
        
        foreach ($plainTextUsers as $user) {
            // Store the plain text password temporarily
            $plainPassword = $user->password;
            
            // Hash the password using the mutator
            $user->password = $plainPassword;
            $user->save();
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('All passwords have been hashed successfully!');
        
        return 0;
    }
} 