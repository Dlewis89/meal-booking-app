<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MealsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // now de-register all the roles and permissions by clearing the permission cache
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $this->seed();
    }
    /**
     * A basic feature test example.
     */
    public function test_user_with_caterer_role_can_create_a_meal(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
            'web'
        );

        $user->assignRole('Caterer');

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/meals', [
            'name' => 'Meal 1',
            'image_url' => null,
            'instruction_url' => null,
            'html' => null
        ]);

        $response->assertStatus(201);
    }

    public function test_user_with_standard_role_can_not_create_a_meal(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
            'web'
        );

        $user->assignRole('standard');

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/meals', [
            'name' => 'Meal 1',
            'image_url' => null,
            'instruction_url' => null,
            'html' => null
        ]);

        $response->assertStatus(403);
    }
}
