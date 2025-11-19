<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\InstrumentSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->artisan('migrate');
    }

    /** @test */
    public function scanning_an_asset_updates_its_status()
    {
        $asset = Asset::factory()->create(['status' => Asset::STATUS_READY]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Start Washing',
            'location' => 'Decontamination Area',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_WASHING,
        ]);
    }

    /** @test */
    public function scanning_an_instrument_set_updates_the_status_of_the_set_and_all_its_assets()
    {
        $assets = Asset::factory()->count(3)->create(['status' => Asset::STATUS_READY]);
        $instrumentSet = InstrumentSet::factory()
            ->hasAttached($assets)
            ->create(['status' => InstrumentSet::STATUS_READY]);

        $scanData = [
            'qr_code' => $instrumentSet->qr_code,
            'action' => 'Start Sterilizing',
            'location' => 'Sterilization Dept',
        ];

        $this->postJson('/api/scan', $scanData);

        // Assert the set's status was updated
        $this->assertDatabaseHas('instrument_sets', [
            'id' => $instrumentSet->id,
            'status' => InstrumentSet::STATUS_STERILIZING,
        ]);

        // Assert all assets within the set have had their status updated
        foreach ($assets as $asset) {
            $this->assertDatabaseHas('assets', [
                'id' => $asset->id,
                'status' => Asset::STATUS_STERILIZING,
            ]);
        }
    }
}
