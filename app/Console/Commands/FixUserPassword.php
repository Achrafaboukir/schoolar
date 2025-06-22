<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:fix-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix a user password and test authentication';

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

        $this->info("Found user: {$user->firstname} {$user->lastname}");
        $this->info("Current status: {$user->status}");
        $this->info("Is active: " . ($user->isActive() ? 'Yes' : 'No'));

        // Test current password
        $currentValid = Hash::check($password, $user->password);
        $this->info("Current password valid: " . ($currentValid ? 'Yes' : 'No'));

        if (!$currentValid) {
            $this->warn("Current password is not valid. Updating password...");
            
            // Update password
            $user->password = $password;
            $user->save();

            // Test new password
            $user->refresh();
            $newValid = Hash::check($password, $user->password);
            $this->info("New password valid: " . ($newValid ? 'Yes' : 'No'));

            if ($newValid) {
                $this->info("Password updated successfully!");
            } else {
                $this->error("Failed to update password!");
                return 1;
            }
        } else {
            $this->info("Password is already correct!");
        }

        // Test authentication
        $this->info("\nTesting authentication...");
        $credentials = ['email' => $email, 'password' => $password];
        
        if (auth()->attempt($credentials)) {
            $this->info("Authentication successful!");
            auth()->logout();
        } else {
            $this->error("Authentication failed!");
            return 1;
        }

        return 0;
    }
} 