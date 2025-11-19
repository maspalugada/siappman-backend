<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_search_for_assets_by_name()
    {
        Asset::factory()->create(['name' => 'Asset Alpha']);
        Asset::factory()->create(['name' => 'Asset Beta']);
        Asset::factory()->create(['name' => 'Another Asset']);

        $response = $this->get(route('dashboard.assets.index', ['search' => 'Alpha']));

        $response->assertStatus(200);
        $response->assertSee('Asset Alpha');
        $response->assertDontSee('Asset Beta');
        $response->assertDontSee('Another Asset');
    }
}
