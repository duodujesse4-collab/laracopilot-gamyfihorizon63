<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['name' => 'John Smith', 'email' => 'john@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Mike Wilson', 'email' => 'mike@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Emily Davis', 'email' => 'emily@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Chris Brown', 'email' => 'chris@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Amanda White', 'email' => 'amanda@example.com', 'password' => Hash::make('password123')],
            ['name' => 'David Martinez', 'email' => 'david@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Lisa Thompson', 'email' => 'lisa@example.com', 'password' => Hash::make('password123')],
            ['name' => 'James Anderson', 'email' => 'james@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Jennifer Taylor', 'email' => 'jennifer@example.com', 'password' => Hash::make('password123')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}