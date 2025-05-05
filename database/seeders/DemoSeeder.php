<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Researcher;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email'=> 'admin@example.com',
            'password'=> Hash::make('password'),
        ]);

        Researcher::create([
            'user_id'=>$user->id,
            'name'=>'Admin User',
            'department'=>'CSE',
            'contact'=>'012345678',
        ]);
    }
}
