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

        // Create a user for authentication
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_assets_index()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('dashboard.assets.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.index');
        $response->assertViewHas('assets');
    }

    /** @test */
    public function user_can_view_create_asset_form()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('dashboard.assets.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.create');
        $response->assertViewHas(['instrumentTypes', 'units', 'locations']);
    }

    /** @test */
    public function user_can_create_asset()
    {
        $this->actingAs($this->user);

        $assetData = [
            'name' => 'Test Pressure Gauge',
            'instrument_type' => 'STEAM',
            'unit' => 'L T 8, SUKAMAN/EBONY',
            'jumlah' => 1,
            'location' => 'Gedung VENTRICLE',
            'description' => 'Test asset description',
        ];

        $response = $this->post(route('dashboard.assets.store'), $assetData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseHas('assets', $assetData);
    }

    /** @test */
    public function asset_creation_requires_name()
    {
        $this->actingAs($this->user);

        $assetData = [
            'instrument_type' => 'Pressure Gauge',
            'unit' => 'Bar',
            'location' => 'Workshop A',
        ];

        $response = $this->post(route('dashboard.assets.store'), $assetData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_can_view_asset_details()
    {
        $this->actingAs($this->user);

        $asset = Asset::factory()->create();

        $response = $this->get(route('dashboard.assets.show', $asset));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.show');
        $response->assertViewHas('asset');
    }

    /** @test */
    public function user_can_view_edit_asset_form()
    {
        $this->actingAs($this->user);

        $asset = Asset::factory()->create();

        $response = $this->get(route('dashboard.assets.edit', $asset));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.assets.edit');
        $response->assertViewHas(['asset', 'instrumentTypes', 'units', 'locations']);
    }

    /** @test */
    public function user_can_update_asset()
    {
        $this->actingAs($this->user);

        $asset = Asset::factory()->create();

        $updateData = [
            'name' => 'Updated Asset Name',
            'instrument_type' => 'EO',
            'unit' => 'L T 7, RAWAT ANAK',
            'jumlah' => 2,
            'location' => 'Gedung PERAWATAN',
            'description' => 'Updated description',
            'status' => 'maintenance',
        ];

        $response = $this->put(route('dashboard.assets.update', $asset), $updateData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseHas('assets', array_merge(['id' => $asset->id], $updateData));
    }

    /** @test */
    public function user_can_delete_asset()
    {
        $this->actingAs($this->user);

        $asset = Asset::factory()->create();

        $response = $this->delete(route('dashboard.assets.destroy', $asset));

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseMissing('assets', ['id' => $asset->id]);
    }

    /** @test */
    public function user_can_generate_qr_code()
    {
        $this->actingAs($this->user);

        $asset = Asset::factory()->create();

        $response = $this->get(route('dashboard.assets.qr', $asset));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'qr_data' => [
                'id',
                'name',
                'type',
                'location',
                'qr_code',
                'timestamp'
            ],
            'qr_string'
        ]);
    }

    /** @test */
    public function guest_cannot_access_assets()
    {
        $response = $this->get(route('dashboard.assets.index'));

        $response->assertRedirect(route('login'));
    }
}
