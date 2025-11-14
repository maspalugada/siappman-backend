<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_asset_is_created_with_active_status_by_default()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $assetData = [
            'name' => 'Test Asset',
            'instrument_type' => 'STEAM',
            'unit' => 'L T 8, SUKAMAN/EBONY',
            'jumlah' => 1,
            'location' => 'Gedung VENTRICLE',
        ];

        $response = $this->post(route('dashboard.assets.store'), $assetData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $this->assertDatabaseHas('assets', [
            'name' => 'Test Asset',
            'status' => 'active',
        ]);
    }
}
