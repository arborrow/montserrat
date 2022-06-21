<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SquarespaceInventoryController
 */
class SquarespaceCustomFormControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-squarespace-custom-form');

        $response = $this->actingAs($user)->get(route('custom_form.create'));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.custom_forms.create');
        $response->assertSeeText('Create Squarespace Custom Form');
    }

    /**
     * @test
     */
    public function create_field_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();

        $response = $this->actingAs($user)->get(route('custom_form.field.create', ['id' => $custom_form->id]));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.custom_forms.fields.create');
        $response->assertViewHas('custom_form');
        $response->assertSeeText('Create Squarespace Custom Form Field');
    }


    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();

        $response = $this->actingAs($user)->delete(route('custom_form.destroy', [$custom_form]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'index']));
        $this->assertSoftDeleted($custom_form);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();

        $response = $this->actingAs($user)->get(route('custom_form.edit', [$custom_form]));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.custom_forms.edit');
        $response->assertViewHas('custom_form');
        $response->assertSeeText('Edit: ' . $custom_form->name);
        
        $this->assertTrue($this->findFieldValueInResponseContent('name', $custom_form->name, 'text', $response->getContent()));
        
    }


    /**
     * @test
     */
    public function edit_field_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-custom-form');
        $custom_form_field = \App\Models\SquarespaceCustomFormField::factory()->create();

        $response = $this->actingAs($user)->get(route('custom_form.field.edit', [$custom_form_field]));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.custom_forms.fields.edit');
        $response->assertViewHas('custom_form_field');
        $response->assertSeeText('Edit Squarespace Custom Field: ' . $custom_form_field->name);
        
        $this->assertTrue($this->findFieldValueInResponseContent('name', $custom_form_field->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('type', $custom_form_field->type, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('variable_name', $custom_form_field->variable_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('sort_order', $custom_form_field->sort_order, 'number', $response->getContent()));

    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-custom-form');

        $response = $this->actingAs($user)->get(route('custom_form.index'));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.custom_forms.index');
        $response->assertViewHas('custom_forms');
        $response->assertSeeText('Squarespace Custom Forms Index');
    }


    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();

        $response = $this->actingAs($user)->get(route('custom_form.show', [$custom_form]));

        $response->assertOk();
        $response->assertViewIs('admin.squarespace.custom_forms.show');
        $response->assertViewHas('custom_form');
        $response->assertSeeText('Squarespace Custom Form:');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   //$this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-squarespace-custom-form');

        $name = $this->faker->word();
        
        $response = $this->actingAs($user)->post(route('custom_form.store'), [
            'name' => $name,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'index']));
        $response->assertSessionHas('flash_notification');
        
        $this->assertDatabaseHas('squarespace_custom_form', [
            'name' => $name,
        ]);
    }

    /**
     * @test
     */
    public function store_field_returns_an_ok_response()
    {   $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();
        $variable_name = strtolower($this->faker->word());
        $name = ucwords($variable_name);
        $type = $this->faker->randomElement(['select' , 'name' , 'address' , 'phone' , 'email' , 'date' , 'person' , 'text']);
        $sort_order = $this->faker->numberBetween(1,10);
        
        $response = $this->actingAs($user)->post(route('custom_form.field.store',['id' => $custom_form->id]), [
            'id' => $custom_form->id,
            'form_id' => $custom_form->id,
            'name' => $name,
            'variable_name' => $variable_name,
            'sort_order' => $sort_order,
            'type' => $type,
        ]);
        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'show'], $custom_form->id));
        $response->assertSessionHas('flash_notification');
        
        $this->assertDatabaseHas('squarespace_custom_form_field', [
            'name' => $name,
            'variable_name' => $variable_name,
            'sort_order' => $sort_order,
            'type' => $type,
        ]);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceCustomFormController::class,
            'store',
            \App\Http\Requests\StoreSquarespaceCustomFormRequest::class
        );
    }

    /**
     * @test
     */
    public function store_field_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceCustomFormController::class,
            'store_field',
            \App\Http\Requests\StoreSquarespaceCustomFormFieldRequest::class
        );
    }


    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-custom-form');

        $custom_form = \App\Models\SquarespaceCustomForm::factory()->create();

        $original_name = $custom_form->name;
        $new_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('custom_form.update', [$custom_form]), [
            'id' => $custom_form->id,
            'name' => $new_name,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'show'], $custom_form->id));

        $updated = \App\Models\SquarespaceCustomForm::findOrFail($custom_form->id);

        $this->assertEquals($updated->name, $new_name);
        $this->assertNotEquals($updated->name, $original_name);
    }


    /**
     * @test
     */
    public function update_field_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-custom-form');

        $custom_form_field = \App\Models\SquarespaceCustomFormField::factory()->create();

        $original_name = $custom_form_field->name;
        $new_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('custom_form.field.update', [$custom_form_field]), [
            'id' => $custom_form_field->id,
            'form_id' => $custom_form_field->form_id,
            'name' => $new_name,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'show'], $custom_form_field->form_id));

        $updated = \App\Models\SquarespaceCustomFormField::findOrFail($custom_form_field->id);

        $this->assertEquals($updated->name, $new_name);
        $this->assertNotEquals($updated->name, $original_name);
    }


    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceCustomFormController::class,
            'update',
            \App\Http\Requests\UpdateSquarespaceCustomFormRequest::class
        );
    }

    /**
     * @test
     */
    public function update_field_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceCustomFormController::class,
            'update_field',
            \App\Http\Requests\UpdateSquarespaceCustomFormFieldRequest::class
        );
    }

}
