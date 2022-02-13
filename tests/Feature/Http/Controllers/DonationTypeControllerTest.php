<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

// $this->withoutExceptionHandling();

/**
 * @see \App\Http\Controllers\DonationTypeController
 */
class DonationTypeControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-donation-type');

        $response = $this->actingAs($user)->get(route('donation_type.create'));

        $response->assertOk();
        $response->assertViewIs('admin.donation_types.create');
        $response->assertSeeText('Create donation type');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-donation-type');
        $donation_type = \App\Models\DonationType::factory()->create();

        $response = $this->actingAs($user)->delete(route('donation_type.destroy', [$donation_type]));
        $response->assertSessionHas('flash_notification');

        $response->assertRedirect(action([\App\Http\Controllers\DonationTypeController::class, 'index']));
        $this->assertSoftDeleted($donation_type);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-donation-type');
        $donation_type = \App\Models\DonationType::factory()->create();

        $response = $this->actingAs($user)->get(route('donation_type.edit', [$donation_type]));

        $response->assertOk();
        $response->assertViewIs('admin.donation_types.edit');
        $response->assertViewHas('donation_type');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $donation_type->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('label', $donation_type->label, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('value', $donation_type->value, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $donation_type->description, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $donation_type->is_active, 'checkbox', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation-type');

        $response = $this->actingAs($user)->get(route('donation_type.index'));

        $response->assertOk();
        $response->assertViewIs('admin.donation_types.index');
        $response->assertViewHas('donation_types');
        $response->assertSeeText('Donation types');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation-type');
        $donation_type = \App\Models\DonationType::factory()->create();

        $response = $this->actingAs($user)->get(route('donation_type.show', [$donation_type]));

        $response->assertOk();
        $response->assertViewIs('admin.donation_types.show');
        $response->assertViewHas('donation_type');
        $response->assertSeeText('Donation type details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-donation-type');
        $donation_type_name = 'New '.$this->faker->word();
        $donation_type_label = $this->faker->words(2, true);
        $donation_type_description = $this->faker->sentence(7, true);
        $donation_type_value = strval($this->faker->numberBetween(1000, 2000));
        $donation_type_is_active = $this->faker->boolean();
        $response = $this->actingAs($user)->post(route('donation_type.store'), [
            'name' => $donation_type_name,
            'label' => $donation_type_label,
            'description' => $donation_type_description,
            'value' => $donation_type_value,
            'is_active' => $donation_type_is_active,
        ]);
        $response->assertRedirect(action([\App\Http\Controllers\DonationTypeController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('donation_type', [
            'name' => $donation_type_name,
            'label' => $donation_type_label,
            'description' => $donation_type_description,
            'value' => $donation_type_value,
            'is_active' => $donation_type_is_active,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-donation-type');
        $donation_type = \App\Models\DonationType::factory()->create();
        $original_donation_type_name = $donation_type->name;
        $new_donation_type_name = 'New '.$this->faker->words(3, true);

        $response = $this->actingAs($user)->put(route('donation_type.update', [$donation_type]), [
            'id' => $donation_type->id,
            'name' => $new_donation_type_name,
            'label' => $this->faker->words(4, true),
            'value' => strval($this->faker->numberBetween(1000, 2000)),
            'description' => $this->faker->sentence(7, true),
            'is_active' => $this->faker->boolean(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\DonationTypeController::class, 'show'], $donation_type->id));
        $response->assertSessionHas('flash_notification');
        $updated = \App\Models\DonationType::findOrFail($donation_type->id);
        $this->assertEquals($updated->name, $new_donation_type_name);
        $this->assertNotEquals($updated->name, $original_donation_type_name);
    }

    // test cases...
}
