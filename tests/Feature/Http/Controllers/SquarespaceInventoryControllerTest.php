<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SquarespaceInventoryController
 */
class SquarespaceInventoryControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-squarespace-inventory');

        $response = $this->actingAs($user)->get(route('inventory.create'));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.inventory.create');
        $response->assertSeeText('Create Squarespace Inventory');
        $response->assertViewHas('custom_forms');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-squarespace-inventory');
        $inventory = \App\Models\SquarespaceInventory::factory()->create();

        $response = $this->actingAs($user)->delete(route('inventory.destroy', [$inventory]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceInventoryController::class, 'index']));
        $this->assertSoftDeleted($inventory);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-inventory');
        $inventory = \App\Models\SquarespaceInventory::factory()->create();

        $response = $this->actingAs($user)->get(route('inventory.edit', [$inventory]));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.inventory.edit');
        $response->assertViewHas('inventory');
        $response->assertViewHas('custom_forms');
        $response->assertSeeText('Edit');
        
        $this->assertTrue($this->findFieldValueInResponseContent('name', $inventory->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('custom_form_id', $inventory->custom_form_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('variant_options', $inventory->variant_options, 'number', $response->getContent()));
        
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-inventory');

        $response = $this->actingAs($user)->get(route('inventory.index'));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.inventory.index');
        $response->assertViewHas('inventory_items');
        $response->assertSeeText('Squarespace Inventory Index');
    }


    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-inventory');
        $inventory = \App\Models\SquarespaceInventory::factory()->create();

        $response = $this->actingAs($user)->get(route('inventory.show', [$inventory]));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.inventory.show');
        $response->assertViewHas('inventory');
        $response->assertSeeText('Squarespace Inventory details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   //$this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-squarespace-inventory');

        $name = $this->faker->word();
        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();
        $variant_options = $this->faker->numberBetween(2,5);
        $response = $this->actingAs($user)->post(route('inventory.store'), [
            'name' => $name,
            'custom_form_id' => $custom_form->id,
            'variant_options' => $variant_options,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceInventoryController::class, 'index']));
        $response->assertSessionHas('flash_notification');
        
        $this->assertDatabaseHas('squarespace_inventory', [
            'name' => $name,
            'custom_form_id' => $custom_form->id,
            'variant_options' => $variant_options,
        ]);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceInventoryController::class,
            'store',
            \App\Http\Requests\StoreSquarespaceInventoryRequest::class
        );
    }


    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-inventory');

        $inventory = \App\Models\SquarespaceInventory::factory()->create();

        $original_name = $inventory->name;
        $new_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('inventory.update', [$inventory]), [
            'id' => $inventory->id,
            'name' => $new_name,
            'custom_form_id' => $inventory->custom_form_id,
            'variant_options' => $this->faker->numberBetween(6,8),
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceInventoryController::class, 'show'], $inventory->id));

        $updated = \App\Models\SquarespaceInventory::findOrFail($inventory->id);

        $this->assertEquals($updated->name, $new_name);
        $this->assertNotEquals($updated->name, $original_name);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceInventoryController::class,
            'update',
            \App\Http\Requests\UpdateSquarespaceInventoryRequest::class
        );
    }

}
