<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\InstrumentSet;
use App\Models\ScanActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScanWorkflowTest extends TestCase
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
    public function scanning_an_instrument_set_creates_scan_activities_for_the_set_and_its_assets()
    {
        // 1. Arrange
        $assets = Asset::factory()->count(3)->create();
        $instrumentSet = InstrumentSet::factory()
            ->hasAttached($assets)
            ->create();

        $scanData = [
            'qr_code' => $instrumentSet->qr_code,
            'action' => 'Sterilization Start',
            'location' => 'CSSD Area 1',
        ];

        // 2. Act
        $response = $this->postJson('/api/scan', $scanData);

        // 3. Assert
        $response->assertStatus(200)
            ->assertJson(['message' => 'Scan recorded successfully']);

        // Assert that a scan activity was created for the InstrumentSet
        $this->assertDatabaseHas('scan_activities', [
            'scannable_id' => $instrumentSet->id,
            'scannable_type' => InstrumentSet::class,
            'action' => 'Sterilization Start',
        ]);

        // Assert that a scan activity was created for each Asset in the set
        foreach ($assets as $asset) {
            $this->assertDatabaseHas('scan_activities', [
                'scannable_id' => $asset->id,
                'scannable_type' => Asset::class,
                'action' => 'Sterilization Start',
            ]);
        }

        // Total of 4 activities: 1 for the set + 3 for the assets
        $this->assertEquals(4, ScanActivity::count());
    }
}
