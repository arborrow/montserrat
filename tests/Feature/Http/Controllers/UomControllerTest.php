<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UomController
 */
final class UomControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    #[Test]
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-uom');

        $response = $this->actingAs($user)->get(route('uom.create'));

        $response->assertOk();
        $response->assertViewIs('admin.uoms.create');
        $response->assertSeeText('Create unit of measure');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-uom');
        $uom = \App\Models\Uom::factory()->create();

        $response = $this->actingAs($user)->delete(route('uom.destroy', [$uom]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\UomController::class, 'index']));
        $this->assertSoftDeleted($uom);
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-uom');
        $uom = \App\Models\Uom::factory()->create();

        $response = $this->actingAs($user)->get(route('uom.edit', [$uom]));

        $response->assertOk();
        $response->assertViewIs('admin.uoms.edit');
        $response->assertViewHas('uom');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('unit_name', $uom->unit_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('unit_symbol', $uom->unit_symbol, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $uom->description, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $uom->is_active, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('type', $uom->type, 'select', $response->getContent()));
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-uom');

        $response = $this->actingAs($user)->get(route('uom.index'));

        $response->assertOk();
        $response->assertViewIs('admin.uoms.index');
        $response->assertViewHas('uoms');
        $response->assertSeeText('Units of measure');
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-uom');
        $uom = \App\Models\Uom::factory()->create();

        $response = $this->actingAs($user)->get(route('uom.show', [$uom]));

        $response->assertOk();
        $response->assertViewIs('admin.uoms.show');
        $response->assertViewHas('uom');
        $response->assertSeeText('Unit of measure details');
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-uom');

        $uom_unit_name = $this->faker->word();
        $uom_description = $this->faker->sentence(7, true);
        $uom_is_active = $this->faker->boolean();
        $uom_type = $this->faker->randomElement(config('polanco.uom_types'));

        $response = $this->actingAs($user)->post(route('uom.store'), [
            'unit_name' => $uom_unit_name,
            'unit_symbol' => $uom_unit_name,
            'description' => $uom_description,
            'is_active' => $uom_is_active,
            'type' => $uom_type,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\UomController::class, 'index']));

        $this->assertDatabaseHas('uom', [
            'unit_name' => $uom_unit_name,
            'description' => $uom_description,
            'is_active' => $uom_is_active,
            'type' => $uom_type,
        ]);
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-uom');

        $uom = \App\Models\Uom::factory()->create();
        $uom_type = $this->faker->randomElement(config('polanco.uom_types'));

        $original_uom_unit_name = $uom->unit_name;
        $new_uom_unit_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('uom.update', [$uom]), [
            'id' => $uom->id,
            'unit_name' => $new_uom_unit_name,
            'unit_symbol' => $new_uom_unit_name,
            'description' => $this->faker->sentence(7, true),
            'is_active' => $this->faker->boolean(),
            'type' => $uom_type,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\UomController::class, 'show'], $uom->id));

        $updated = \App\Models\Uom::findOrFail($uom->id);
        $this->assertEquals($updated->unit_name, $new_uom_unit_name);
        $this->assertNotEquals($updated->unit_name, $original_uom_unit_name);
    }

    // test cases...
}
