<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AssetQrCodeUniquenessTest extends TestCase
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
    public function it_generates_unique_qr_codes()
    {
        $assetData1 = [
            'name' => 'Test Asset 1',
            'instrument_type' => 'STEAM',
            'unit' => 'Unit 1',
            'jumlah' => 1,
            'location' => 'Location 1',
        ];

        $assetData2 = [
            'name' => 'Test Asset 2',
            'instrument_type' => 'EO',
            'unit' => 'Unit 2',
            'jumlah' => 1,
            'location' => 'Location 2',
        ];

        $this->post(route('dashboard.assets.store'), $assetData1);
        $this->post(route('dashboard.assets.store'), $assetData2);

        $assets = Asset::all();
        $this->assertCount(2, $assets);

        $qrCodes = $assets->pluck('qr_code');
        $this->assertCount(2, $qrCodes->unique());
    }
}
