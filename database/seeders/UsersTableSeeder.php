<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a default user (optional)
        $userAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@starwars.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'active' => true,
        ]);

        JWTAuth::fromUser($userAdmin);
        $userAdmin->createToken('api-token')->plainTextToken;

        // Generate dummy users with tokens
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->createToken('api-token')->plainTextToken;
        });
    }
}
