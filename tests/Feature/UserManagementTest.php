<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create(['is_admin' => false]);
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('dashboard.users.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_user_management()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('dashboard.users.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_user()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('dashboard.users.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_admin' => false,
        ]);

        $response->assertRedirect(route('dashboard.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_admin_can_update_user()
    {
        $this->actingAs($this->admin);

        $response = $this->put(route('dashboard.users.update', $this->user), [
            'name' => 'Updated Name',
            'email' => $this->user->email,
        ]);

        $response->assertRedirect(route('dashboard.users.index'));
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function test_admin_can_delete_user()
    {
        $this->actingAs($this->admin);

        $response = $this->delete(route('dashboard.users.destroy', $this->user));

        $response->assertRedirect(route('dashboard.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    public function test_user_cannot_delete_themselves()
    {
        $this->actingAs($this->admin);

        $response = $this->delete(route('dashboard.users.destroy', $this->admin));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }
}
