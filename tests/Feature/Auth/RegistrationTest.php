<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $admin = User::factory()->create([
            'role' => 0,
        ]);

        $this->actingAs($admin);

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $admin = User::factory()->create([
            'role' => 0,
        ]);

        $this->actingAs($admin);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 2,
            'phone' => '01700000000',
        ]);

        $response->assertRedirect(route('register', absolute: false));

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 2,
            'phone_number' => '01700000000',
        ]);
    }
}
