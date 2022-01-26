<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AssetController
 */
class AssetControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-asset');

        $response = $this->actingAs($user)->get(route('asset.create'));

        $response->assertOk();
        $response->assertViewIs('assets.create');
        $response->assertViewHas('asset_types');
        $response->assertViewHas('departments');
        $response->assertViewHas('parents');
        $response->assertViewHas('locations');
        $response->assertViewHas('vendors');
        $response->assertViewHas('uoms_electric');
        $response->assertViewHas('uoms_length');
        $response->assertViewHas('uoms_weight');
        $response->assertViewHas('uoms_capacity');
        $response->assertViewHas('uoms_time');
        $response->assertViewHas('depreciation_types');
        $response->assertSeeText('Create asset');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-asset');
        $asset = \App\Models\Asset::factory()->create();

        $response = $this->actingAs($user)->delete(route('asset.destroy', [$asset]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('AssetController@index'));
        $this->assertSoftDeleted($asset);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-asset');
        $asset = \App\Models\Asset::factory()->create();

        $response = $this->actingAs($user)->get(route('asset.edit', [$asset]));

        $response->assertOk();
        $response->assertViewIs('assets.edit');
        $response->assertViewHas('asset_types');
        $response->assertViewHas('departments');
        $response->assertViewHas('parents');
        $response->assertViewHas('locations');
        $response->assertViewHas('vendors');
        $response->assertViewHas('uoms_electric');
        $response->assertViewHas('uoms_length');
        $response->assertViewHas('uoms_weight');
        $response->assertViewHas('uoms_capacity');
        $response->assertViewHas('uoms_time');
        $response->assertViewHas('depreciation_types');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $asset->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('asset_type_id', $asset->asset_type_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $asset->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('manufacturer', $asset->manufacturer, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('model', $asset->model, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('serial_number', $asset->serial_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('year', $asset->year, 'text', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('location_id', $asset->location_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('department_id', $asset->department_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('parent_id', $asset->parent_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('status', $asset->status, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('remarks', $asset->remarks, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $asset->is_active, 'checkbox', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('manufacturer_id', $asset->manufacturer_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('vendor_id', $asset->vendor_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('power_line_voltage', $asset->power_line_voltage, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('power_line_voltage_uom_id', $asset->power_line_voltage_uom_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('power_phase_voltage', $asset->power_phase_voltage, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('power_phase_voltage_uom_id', $asset->power_phase_voltage_uom_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('power_phases', $asset->power_phases, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('power_amp', number_format($asset->power_amp, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('power_amp_uom_id', $asset->power_amp_uom_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('length', number_format($asset->length, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('length_uom_id', $asset->length_uom_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('width', number_format($asset->width, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('width_uom_id', $asset->width_uom_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('height', number_format($asset->height, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('height_uom_id', $asset->height_uom_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('weight', number_format($asset->weight, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('weight_uom_id', $asset->weight_uom_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('capacity', number_format($asset->capacity, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('capacity_uom_id', $asset->capacity_uom_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('purchase_date', $asset->purchase_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('purchase_price', number_format($asset->purchase_price, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('life_expectancy', number_format($asset->life_expectancy, 2), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('life_expectancy_uom_id', $asset->life_expectancy_uom_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('start_date', $asset->start_date, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('end_date', $asset->end_date, 'text', $response->getContent()));
        // TODO: investigate why this is failing
        // $this->assertTrue($this->findFieldValueInResponseContent('replacement_id', $asset->replacement_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('warranty_start_date', $asset->warranty_start_date, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('warranty_end_date', $asset->warranty_end_date, 'text', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_start_date', $asset->depreciation_start_date, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_end_date', $asset->depreciation_end_date, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_type_id', $asset->depreciation_type_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_rate', $asset->depreciation_rate, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_value', $asset->depreciation_value, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_time', $asset->depreciation_time, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('depreciation_time_uom_id', $asset->depreciation_time_uom_id, 'select', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');

        $response = $this->actingAs($user)->get(route('asset.index'));

        $response->assertOk();
        $response->assertViewIs('assets.index');
        $response->assertViewHas('assets');
        $response->assertViewHas('asset_types');
        $response->assertViewHas('locations');
        $response->assertSeeText('Assets');
    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');

        $asset = \App\Models\Asset::factory()->create();

        $number_assets = $this->faker->numberBetween(2, 10);
        $assets = \App\Models\Asset::factory()->count($number_assets)->create([
            'asset_type_id' => $asset->asset_type_id,
            'deleted_at' => null,
        ]);

        $response = $this->actingAs($user)->get('asset/type/'.$asset->asset_type_id);
        $results = $response->viewData('assets');
        $response->assertOk();
        $response->assertViewIs('assets.index');
        $response->assertViewHas('assets');
        $response->assertViewHas('asset_types');
        $response->assertViewHas('locations');
        $response->assertSeeText('Assets');
        $response->assertSeeText($asset->asset_type_name);
        $this->assertGreaterThan($number_assets, $results->count());
    }

    /**
     * @test
     */
    public function index_location_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');

        $asset = \App\Models\Asset::factory()->create();

        $number_assets = $this->faker->numberBetween(2, 10);
        $assets = \App\Models\Asset::factory()->count($number_assets)->create([
            'location_id' => $asset->location_id,
            'deleted_at' => null,
        ]);

        $response = $this->actingAs($user)->get('asset/location/'.$asset->location_id);
        $results = $response->viewData('assets');
        $response->assertOk();
        $response->assertViewIs('assets.index');
        $response->assertViewHas('assets');
        $response->assertViewHas('asset_types');
        $response->assertViewHas('locations');
        $response->assertSeeText('Assets');
        $response->assertSeeText($asset->location_name);
        $this->assertGreaterThan($number_assets, $results->count());
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');
        $asset = \App\Models\Asset::factory()->create();

        $response = $this->actingAs($user)->get(route('asset.show', [$asset]));

        $response->assertOk();
        $response->assertViewIs('assets.show');
        $response->assertViewHas('asset');
        $response->assertViewHas('files');
        $response->assertSeeText('Asset details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        //$this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-asset');

        $name = $this->faker->word;
        $description = $this->faker->sentence(7, true);
        $asset_type_id = $this->faker->numberBetween(1, 10);

        $response = $this->actingAs($user)->post(route('asset.store'), [
            'name' => $name,
            'asset_type_id' => $asset_type_id,
            'description' => $description,
            'is_active' => 1,
        ]);

        $response->assertRedirect(action('AssetController@index'));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('asset', [
            'name' => $name,
            'description' => $description,
            'asset_type_id' => $asset_type_id,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('update-asset');

        $asset = \App\Models\Asset::factory()->create();

        $original_asset_manufacuturer = $asset->manufacturer;
        $new_manufacturer = 'New '.$this->faker->words(2, true);
        $response = $this->actingAs($user)->put(route('asset.update', [$asset]), [
            'id' => $asset->id,
            'name' => $asset->name,
            'asset_type_id' => $asset->asset_type_id,
            'manufacturer' => $new_manufacturer,
        ]);
        $response->assertRedirect(action('AssetController@show', $asset->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\Models\Asset::findOrFail($asset->id);
        $this->assertEquals($updated->manufacturer, $new_manufacturer);
        $this->assertNotEquals($updated->manufacturer, $original_asset_manufacuturer);
    }

    /**
     * @test
     */
    public function results_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');

        $asset = \App\Models\Asset::factory()->create();

        $response = $this->actingAs($user)->get('asset/results?name='.$asset->name);

        $response->assertOk();
        $response->assertViewIs('assets.results');
        $response->assertViewHas('assets');
        $response->assertSeeText('results found');
        $response->assertSeeText($asset->name);
    }

    /**
     * @test
     */
    public function search_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');

        $response = $this->actingAs($user)->get('asset/search');

        $response->assertOk();
        $response->assertViewIs('assets.search');
        $response->assertViewHas('asset_types');
        $response->assertViewHas('departments');
        $response->assertViewHas('depreciation_types');
        $response->assertViewHas('locations');
        $response->assertViewHas('parents');
        $response->assertViewHas('uoms_capacity');
        $response->assertViewHas('uoms_electric');
        $response->assertViewHas('uoms_length');
        $response->assertViewHas('uoms_time');
        $response->assertViewHas('uoms_weight');
        $response->assertViewHas('vendors');
        $response->assertSeeText('Search Assets');
    }

    // test cases...
}
