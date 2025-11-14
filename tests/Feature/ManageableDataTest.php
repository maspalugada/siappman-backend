<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\InstrumentType;
use App\Models\Unit;
use App\Models\Location;

class ManageableDataTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_create_instrument_type()
    {
        $response = $this->post(route('dashboard.instrument-types.store'), [
            'name' => 'Test Type',
        ]);

        $response->assertRedirect(route('dashboard.instrument-types.index'));
        $this->assertDatabaseHas('instrument_types', ['name' => 'Test Type']);
    }

    public function test_can_update_instrument_type()
    {
        $type = InstrumentType::factory()->create();

        $response = $this->put(route('dashboard.instrument-types.update', $type), [
            'name' => 'Updated Type',
        ]);

        $response->assertRedirect(route('dashboard.instrument-types.index'));
        $this->assertDatabaseHas('instrument_types', ['name' => 'Updated Type']);
    }

    public function test_can_delete_instrument_type()
    {
        $type = InstrumentType::factory()->create();

        $response = $this->delete(route('dashboard.instrument-types.destroy', $type));

        $response->assertRedirect(route('dashboard.instrument-types.index'));
        $this->assertDatabaseMissing('instrument_types', ['id' => $type->id]);
    }

    public function test_can_create_unit()
    {
        $response = $this->post(route('dashboard.units.store'), [
            'name' => 'Test Unit',
        ]);

        $response->assertRedirect(route('dashboard.units.index'));
        $this->assertDatabaseHas('units', ['name' => 'Test Unit']);
    }

    public function test_can_update_unit()
    {
        $unit = Unit::factory()->create();

        $response = $this->put(route('dashboard.units.update', $unit), [
            'name' => 'Updated Unit',
        ]);

        $response->assertRedirect(route('dashboard.units.index'));
        $this->assertDatabaseHas('units', ['name' => 'Updated Unit']);
    }

    public function test_can_delete_unit()
    {
        $unit = Unit::factory()->create();

        $response = $this->delete(route('dashboard.units.destroy', $unit));

        $response->assertRedirect(route('dashboard.units.index'));
        $this->assertDatabaseMissing('units', ['id' => $unit->id]);
    }

    public function test_can_create_location()
    {
        $response = $this->post(route('dashboard.locations.store'), [
            'name' => 'Test Location',
        ]);

        $response->assertRedirect(route('dashboard.locations.index'));
        $this->assertDatabaseHas('locations', ['name' => 'Test Location']);
    }

    public function test_can_update_location()
    {
        $location = Location::factory()->create();

        $response = $this->put(route('dashboard.locations.update', $location), [
            'name' => 'Updated Location',
        ]);

        $response->assertRedirect(route('dashboard.locations.index'));
        $this->assertDatabaseHas('locations', ['name' => 'Updated Location']);
    }

    public function test_can_delete_location()
    {
        $location = Location::factory()->create();

        $response = $this->delete(route('dashboard.locations.destroy', $location));

        $response->assertRedirect(route('dashboard.locations.index'));
        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_asset_creation_form_has_correct_dropdowns()
    {
        $type = InstrumentType::factory()->create();
        $unit = Unit::factory()->create();
        $location = Location::factory()->create();

        $response = $this->get(route('dashboard.assets.create'));

        $response->assertSee($type->name);
        $response->assertSee($unit->name);
        $response->assertSee($location->name);
    }
}
