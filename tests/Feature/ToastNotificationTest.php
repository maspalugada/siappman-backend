<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToastNotificationTest extends TestCase
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
    public function a_success_message_triggers_the_toastify_script()
    {
        $assetData = [
            'name' => 'Test Asset for Toast',
            'instrument_type' => 'STEAM',
            'unit' => 'Unit',
            'jumlah' => 1,
            'location' => 'Test Location',
        ];

        $response = $this->from(route('dashboard.assets.create'))
            ->post(route('dashboard.assets.store'), $assetData);

        $response->assertRedirect(route('dashboard.assets.index'));

        $followResponse = $this->get($response->headers->get('Location'));

        $followResponse->assertStatus(200);
        $followResponse->assertSee('Toastify({', false);
        $followResponse->assertSee('text: "Asset created successfully."', false);
        $followResponse->assertDontSee('<div class="alert alert-success">', false);
    }
}
