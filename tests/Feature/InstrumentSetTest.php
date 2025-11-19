<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\InstrumentSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstrumentSetTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        // It's a good practice to run migrations in the setup for feature tests
        // if they are not being run automatically by the test suite config.
        $this->artisan('migrate');
    }

    /** @test */
    public function a_user_can_view_the_instrument_set_index_page()
    {
        InstrumentSet::factory()->create();

        $response = $this->get(route('dashboard.instrument-sets.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.instrument-sets.index');
        $response->assertViewHas('instrumentSets');
    }

    /** @test */
    public function a_user_can_create_an_instrument_set_with_assets()
    {
        $assets = Asset::factory()->count(3)->create();
        $setData = [
            'name' => 'Basic Surgery Set',
            'description' => 'A set for basic surgical procedures.',
            'assets' => $assets->pluck('id')->toArray(),
        ];

        $response = $this->post(route('dashboard.instrument-sets.store'), $setData);

        $response->assertRedirect(route('dashboard.instrument-sets.index'));
        $this->assertDatabaseHas('instrument_sets', ['name' => 'Basic Surgery Set']);
        $this->assertCount(3, InstrumentSet::first()->assets);
    }

    /** @test */
    public function a_user_can_update_an_instrument_set()
    {
        $instrumentSet = InstrumentSet::factory()->create();
        $assets = Asset::factory()->count(2)->create();
        $updateData = [
            'name' => 'Advanced Surgery Set',
            'description' => 'An updated description.',
            'assets' => $assets->pluck('id')->toArray(),
        ];

        $response = $this->put(route('dashboard.instrument-sets.update', $instrumentSet), $updateData);

        $response->assertRedirect(route('dashboard.instrument-sets.index'));
        $this->assertDatabaseHas('instrument_sets', ['name' => 'Advanced Surgery Set']);
        $this->assertCount(2, $instrumentSet->fresh()->assets);
    }

    /** @test */
    public function a_user_can_delete_an_instrument_set()
    {
        $instrumentSet = InstrumentSet::factory()->create();

        $response = $this->delete(route('dashboard.instrument-sets.destroy', $instrumentSet));

        $response->assertRedirect(route('dashboard.instrument-sets.index'));
        $this->assertDatabaseMissing('instrument_sets', ['id' => $instrumentSet->id]);
    }
}
