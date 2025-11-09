<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test {--email=admin@demo.com} {--password=admin} {--name=Admin} {--role=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');
        $role = $this->option('role');

        // Validate role
        if (!in_array($role, ['admin', 'moderator'])) {
            $this->error("Role must be 'admin' or 'moderator'");
            return 1;
        }

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            $this->warn("User with email {$email} already exists.");
            if ($this->confirm('Do you want to update the password and role?', false)) {
                $existingUser->password = Hash::make($password);
                $existingUser->role = $role;
                $existingUser->name = $name;
                $existingUser->save();
                $this->info("User updated: {$email}");
                $this->line("Role: {$role}");
            }
            return 0;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $this->info("Test user created successfully!");
        $this->line("Email: {$email}");
        $this->line("Password: {$password}");
        $this->line("Name: {$name}");
        $this->line("Role: {$role}");

        return 0;
    }
}
