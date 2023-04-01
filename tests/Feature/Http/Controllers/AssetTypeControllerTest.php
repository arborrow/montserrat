<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AssetTypeController
 */
class AssetTypeControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-asset-type');

        $response = $this->actingAs($user)->get(route('asset_type.create'));

        $response->assertOk();
        $response->assertViewIs('admin.asset_types.create');
        $response->assertSeeText('Create asset type');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-asset-type');
        $asset_type = \App\Models\AssetType::factory()->create();

        $response = $this->actingAs($user)->delete(route('asset_type.destroy', [$asset_type]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\AssetTypeController::class, 'index']));
        $this->assertSoftDeleted($asset_type);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-asset-type');
        $asset_type = \App\Models\AssetType::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_type.edit', [$asset_type]));

        $response->assertOk();
        $response->assertViewIs('admin.asset_types.edit');
        $response->assertViewHas('asset_type');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $asset_type->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('label', $asset_type->label, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $asset_type->description, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $asset_type->is_active, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('parent_asset_type_id', $asset_type->event_id, 'select', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-asset-type');

        $response = $this->actingAs($user)->get(route('asset_type.index'));

        $response->assertOk();
        $response->assertViewIs('admin.asset_types.index');
        $response->assertViewHas('asset_types');
        $response->assertSeeText('Asset types');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-asset-type');
        $asset_type = \App\Models\AssetType::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_type.show', [$asset_type]));

        $response->assertOk();
        $response->assertViewIs('admin.asset_types.show');
        $response->assertViewHas('asset_type');
        $response->assertSeeText('Asset type details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-asset-type');
        $parent_asset_type = \App\Models\AssetType::factory()->create();

        $asset_type_name = 'New '.$this->faker->word();
        $asset_type_label = $this->faker->words(2, true);
        $asset_type_description = $this->faker->sentence(7, true);
        $asset_type_is_active = $this->faker->boolean();

        $response = $this->actingAs($user)->post(route('asset_type.store'), [
            'name' => $asset_type_name,
            'label' => $asset_type_label,
            'description' => $asset_type_description,
            'is_active' => $asset_type_is_active,
            'parent_asset_type_id' => $parent_asset_type->id,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AssetTypeController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('asset_type', [
            'name' => $asset_type_name,
            'label' => $asset_type_label,
            'description' => $asset_type_description,
            'is_active' => $asset_type_is_active,
            'parent_asset_type_id' => $parent_asset_type->id,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-asset-type');
        $parent_asset_type = \App\Models\AssetType::factory()->create();
        $asset_type = \App\Models\AssetType::factory()->create();
        $original_asset_type_name = $asset_type->name;
        $new_asset_type_name = 'New '.$this->faker->words(3, true);

        $response = $this->actingAs($user)->put(route('asset_type.update', [$asset_type]), [
            'id' => $asset_type->id,
            'name' => $new_asset_type_name,
            'label' => $this->faker->words(4, true),
            'description' => $this->faker->sentence(7, true),
            'is_active' => $this->faker->boolean(),
            'parent_asset_type_id' => $parent_asset_type->id,
        ]);
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\AssetTypeController::class, 'show'], $asset_type->id));
        // var_dump($asset_type);
        $updated = \App\Models\AssetType::findOrFail($asset_type->id);
        $this->assertEquals($updated->name, $new_asset_type_name);
        $this->assertNotEquals($updated->name, $original_asset_type_name);
    }

    // test cases...
}
