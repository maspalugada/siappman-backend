<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\InstrumentType;
use App\Models\Unit;
use App\Models\Location;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_view_admin_dashboard()
    {
        InstrumentType::factory()->count(3)->create();
        Unit::factory()->count(5)->create();
        Location::factory()->count(2)->create();

        $response = $this->get(route('dashboard.admin'));

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
        $response->assertSee('<p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;">3</p>', false);
        $response->assertSee('<p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;">5</p>', false);
        $response->assertSee('<p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;">2</p>', false);
    }
}
