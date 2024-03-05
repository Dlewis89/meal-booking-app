<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_can_register_an_account_successfully(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@doe.com',
            'password' => Hash::make('password')
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_not_register_without_name_field(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'johndoe@doe.com',
            'password' => Hash::make('password')
        ]);

        $response
            ->assertStatus(422);
    }

    public function test_user_can_not_register_without_email_field(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'password' => Hash::make('password')
        ]);

        $response
            ->assertStatus(422);
    }

    public function test_user_can_not_register_without_password_field(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@doe.com',
        ]);

        $response
            ->assertStatus(422);
    }

    public function test_user_can_not_register_with_duplicate_email(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => $user->email,
            'password' => Hash::make('password')
        ]);

        $response
            ->assertStatus(422);
    }

    /**
     * User Login Tests
     */

    public function test_user_can_log_in_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_not_log_in_with_bad_email(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/auth/login', [
            'email' => 'wrongemail@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(400);
    }

    public function test_user_can_not_log_in_with_missing_email_field(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/auth/login', [
            'password' => 'password'
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_not_log_in_with_bad_password(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'wrongPasswordAttempt'
        ]);

        $response->assertStatus(400);
    }

    public function test_user_can_not_log_in_with_missing_password_field(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
        ]);

        $response->assertStatus(422);
    }
}
