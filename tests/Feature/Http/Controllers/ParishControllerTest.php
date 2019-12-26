<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ParishController
 */
class ParishControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $response = $this->actingAs($user)->get(route('parish.create'));

        $response->assertOk();
        $response->assertViewIs('parishes.create');
        $response->assertViewHas('dioceses');
        $response->assertViewHas('pastors');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Add a Parish');

    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-contact');
        $parish = factory(\App\Parish::class)->create();

        $response = $this->actingAs($user)->delete(route('parish.destroy', [$parish->id]));
        ;
        $response->assertRedirect(action('ParishController@index'));
        $this->assertSoftDeleted($parish);

    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $parish = factory(\App\Parish::class)->create();

        $response = $this->actingAs($user)->get(route('parish.edit', [$parish]));

        $response->assertOk();
        $response->assertViewIs('parishes.edit');
        $response->assertViewHas('parish');
        $response->assertViewHas('dioceses');
        $response->assertViewHas('pastors');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText($parish->display_name);

    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $parish = factory(\App\Parish::class)->create();

        $response = $this->actingAs($user)->get(route('parish.index'));

        $parishes = $response->viewData('parishes');

        $response->assertOk();
        $response->assertViewIs('parishes.index');
        $response->assertViewHas('parishes');
        $response->assertViewHas('dioceses');
        $response->assertViewHas('diocese');
        $this->assertGreaterThanOrEqual('1', $parishes->count());

    }

    /**
     * @test
     */
    public function parish_index_by_diocese_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $diocese = factory(\App\Diocese::class)->create();
        $parish = factory(\App\Parish::class)->create();
        $relationship_diocese = factory(\App\Relationship::class)->create([
            'contact_id_a' => $diocese->id,
            'contact_id_b' => $parish->id,
            'relationship_type_id' => config('polanco.relationship_type.diocese'),
        ]);

        $response = $this->actingAs($user)->get('parishes/diocese/' . $diocese->id);
        $parishes = $response->viewData('parishes');

        $response->assertOk();
        $response->assertViewIs('parishes.index');
        $response->assertViewHas('parishes');
        $response->assertViewHas('dioceses');
        $response->assertViewHas('diocese');
        $this->assertGreaterThanOrEqual('1', $parishes->count());

    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $parish = factory(\App\Parish::class)->create();

        $response = $this->actingAs($user)->get(route('parish.show', [$parish]));

        $response->assertOk();
        $response->assertViewIs('parishes.show');
        $response->assertViewHas('parish');
        $response->assertViewHas('files');
        $response->assertViewHas('relationship_types');
        $response->assertSeeText(e($parish->display_name));

    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');
        $parish_name = 'St. ' . $this->faker->firstName . ' Parish';

        $response = $this->actingAs($user)->post(route('parish.store'), [
          'organization_name' => $parish_name,
          'display_name' => $parish_name,
          'sort_name' => $parish_name,
        ]);

        $response->assertRedirect(action('ParishController@index'));

        $this->assertDatabaseHas('contact', [
          'contact_type' => config('polanco.contact_type.organization'),
          'subcontact_type' => config('polanco.contact_type.parish'),
          'sort_name' => $parish_name,
          'display_name' => $parish_name,
          'organization_name' => $parish_name,
        ]);

    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ParishController::class,
            'store',
            \App\Http\Requests\StoreParishRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $parish = factory(\App\Parish::class)->create();
        $original_sort_name = $parish->sort_name;
        $new_parish_name = 'St. ' . $this->faker->firstName . ' Parish of the Renewal';

        $response = $this->actingAs($user)->put(route('parish.update', [$parish]), [
          'sort_name' => $new_parish_name,
          'display_name' => $new_parish_name,
          'organization_name' => $new_parish_name,
          'id' => $parish->id,
        ]);

        $updated = \App\Contact::findOrFail($parish->id);

        $response->assertRedirect(action('ParishController@show', $parish->id));
        $this->assertEquals($updated->sort_name, $new_parish_name);
        $this->assertNotEquals($updated->sort_name, $original_sort_name);

    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ParishController::class,
            'update',
            \App\Http\Requests\UpdateParishRequest::class
        );
    }

    // test cases...
}
