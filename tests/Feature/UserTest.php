<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    /**
     * test store.
     */

    public function login()
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $info = $this->post('api/login', ['email' => 'admin@example.com', 'password' => '12345678']);
        $content = json_decode($info->getContent());
        return $content->token;
    }

    public function test_index(): void
    {
        Artisan::call('migrate');
        $token = $this->login();

        $charge = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('api/users');
        $charge->assertStatus(200);

    }

    public function test_store(): void
    {
        Artisan::call('migrate');
        $token = $this->login();

        //Store Incorrect
        $storeIncorrect = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('api/users', ['email' => 'aaaa', 'password']);
        $storeIncorrect->assertStatus(422);

    }
}
