<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function user_can_view_assets_index()
    {
        $response = $this->get(route('dashboard.assets.index'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.index');
    }

    /** @test */
    public function user_can_view_create_asset_form()
    {
        $response = $this->get(route('dashboard.assets.create'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.create');
    }

    /** @test */
    public function user_can_create_a_single_asset()
    {
        $instrumentType = \App\Models\InstrumentType::factory()->create();
        $unit = \App\Models\Unit::factory()->create();
        $location = \App\Models\Location::factory()->create();

        $assetData = [
            'name' => 'Test Pressure Gauge',
            'instrument_type' => $instrumentType->name,
            'unit' => $unit->name,
            'jumlah' => 1,
            'location' => $location->name,
            'description' => 'Test asset description',
        ];

        $response = $this->post(route('dashboard.assets.store'), $assetData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseCount('assets', 1);
        $this->assertDatabaseHas('assets', ['name' => 'Test Pressure Gauge']);
    }

    /** @test */
    public function user_can_create_multiple_assets_at_once()
    {
        $instrumentType = \App\Models\InstrumentType::factory()->create();
        $unit = \App\Models\Unit::factory()->create();
        $location = \App\Models\Location::factory()->create();

        $assetData = [
            'name' => 'Test Scalpel',
            'instrument_type' => $instrumentType->name,
            'unit' => $unit->name,
            'jumlah' => 5,
            'location' => $location->name,
        ];

        $response = $this->post(route('dashboard.assets.store'), $assetData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseCount('assets', 5);
        $this->assertEquals(5, Asset::where('name', 'Test Scalpel')->count());
    }


    /** @test */
    public function user_can_view_and_update_an_asset()
    {
        $asset = Asset::factory()->create();
        $newInstrumentType = \App\Models\InstrumentType::factory()->create();
        $newUnit = \App\Models\Unit::factory()->create();
        $newLocation = \App\Models\Location::factory()->create();

        // View
        $response = $this->get(route('dashboard.assets.edit', $asset));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.edit');

        // Update
        $updateData = [
            'name' => 'Updated Asset Name',
            'instrument_type' => $newInstrumentType->name,
            'unit' => $newUnit->name,
            'location' => $newLocation->name,
            'description' => 'Updated description',
        ];

        $response = $this->put(route('dashboard.assets.update', $asset), $updateData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseHas('assets', array_merge(['id' => $asset->id], $updateData));
    }

    /** @test */
    public function user_can_delete_asset()
    {
        $asset = Asset::factory()->create();
        $this->assertDatabaseCount('assets', 1);

        $response = $this->delete(route('dashboard.assets.destroy', $asset));

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseCount('assets', 0);
    }

    /** @test */
    public function guest_cannot_access_assets()
    {
        \Auth::logout();
        $response = $this->get(route('dashboard.assets.index'));
        $response->assertRedirect(route('login'));
    }
}
