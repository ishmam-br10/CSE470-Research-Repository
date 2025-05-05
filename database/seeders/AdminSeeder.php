<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin already exists
        if (!User::where('email', 'admin.research@bracu.ac.bd')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin.research@bracu.ac.bd',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => Carbon::now(),
            ]);

            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}