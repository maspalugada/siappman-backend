<?php

namespace Tests\Feature;

use App\Models\InstrumentSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalAssetLoadingTest extends TestCase
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
    public function it_loads_the_qrcode_library_from_a_local_source()
    {
        $instrumentSet = InstrumentSet::factory()->create();

        $response = $this->get(route('dashboard.instrument-sets.show', $instrumentSet));

        $response->assertStatus(200);
        $response->assertSee(asset('js/qrcode.min.js'), false);
        $response->assertDontSee('https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js', false);
    }
}
