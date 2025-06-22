<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TestPasswordHashing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test password hashing and authentication for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        $this->info("Testing password for user: {$user->firstname} {$user->lastname}");
        $this->info("Email: {$user->email}");
        $this->info("User ID: {$user->id}");
        $this->info("Status: {$user->status}");
        $this->info("Is Active: " . ($user->isActive() ? 'Yes' : 'No'));
        
        // Check password format
        $this->info("\nPassword Analysis:");
        $this->info("Password length: " . strlen($user->password));
        $this->info("Password starts with: " . substr($user->password, 0, 7));
        $this->info("Is hashed: " . (str_starts_with($user->password, '$2y$') ? 'Yes' : 'No'));
        
        // Test Hash::check
        $hashCheck = Hash::check($password, $user->password);
        $this->info("Hash::check result: " . ($hashCheck ? 'Valid' : 'Invalid'));
        
        // Test authentication
        $this->info("\nAuthentication Test:");
        $credentials = ['email' => $email, 'password' => $password];
        
        if (Auth::attempt($credentials)) {
            $this->info("Authentication successful!");
            Auth::logout();
        } else {
            $this->error("Authentication failed!");
            
            // Try to debug why authentication failed
            $this->info("\nDebugging authentication failure:");
            
            // Check if user is active
            if (!$user->isActive()) {
                $this->warn("User is not active (status: {$user->status})");
            }
            
            // Try manual password verification
            if (!$hashCheck) {
                $this->warn("Password hash verification failed");
            }
        }

        return 0;
    }
} 