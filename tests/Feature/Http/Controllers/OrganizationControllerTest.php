<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Organization;

/**
 * @see \App\Http\Controllers\OrganizationController
 */
class OrganizationControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $response = $this->actingAs($user)->get(route('organization.create'));

        $response->assertOk();
        $response->assertViewIs('organizations.create');
        $response->assertViewHas('subcontact_types');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Add an Organization');
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-contact');
        $organization = factory(\App\Organization::class)->create();

        $response = $this->actingAs($user)->delete(route('organization.destroy', ['organization' => $organization]));

        $response->assertRedirect(action('OrganizationController@index'));
        $this->assertSoftDeleted($organization);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $organization = factory(\App\Organization::class)->create();
        $response = $this->actingAs($user)->get(route('organization.edit', ['organization' => $organization]));

        $response->assertOk();
        $response->assertViewIs('organizations.edit');
        $response->assertViewHas('organization');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertViewHas('subcontact_types');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('organization.index'));

        $response->assertOk();
        $response->assertViewIs('organizations.index');
        $response->assertViewHas('organizations');
        $response->assertViewHas('subcontact_types');
        $response->assertSeeText('Organizations');

    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $subcontact_type_id = rand(7,13);
        $response = $this->actingAs($user)->get('organization/type/' . $subcontact_type_id);

        $response->assertOk();
        $response->assertViewIs('organizations.index');
        $response->assertViewHas('organizations');
        $response->assertViewHas('subcontact_types');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Organizations');

    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $organization = factory(\App\Organization::class)->create();
        $response = $this->actingAs($user)->get(route('organization.show', ['organization' => $organization]));

        $response->assertOk();
        $response->assertViewIs('organizations.show');
        $response->assertViewHas('organization');
        $response->assertViewHas('files');
        $response->assertViewHas('relationship_types');
        $response->assertSeeText(e($organization->organization_name));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');
        $organization_name = $this->faker->company;

        $response = $this->actingAs($user)->post(route('organization.store'), [
          'organization_name' => $organization_name,
          'display_name' => $organization_name,
          'sort_name' => $organization_name,
          'contact_type' => config('polanco.contact_type.organization'),
          'subcontact_type' => $this->faker->numberBetween(9,11),

        ]);
        $response->assertRedirect(action('OrganizationController@index'));
        $this->assertDatabaseHas('contact', [
          'contact_type' => config('polanco.contact_type.organization'),
          'sort_name' => $organization_name,
          'display_name' => $organization_name,
        ]);

    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrganizationController::class,
            'store',
            \App\Http\Requests\StoreOrganizationRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        //create original data
        $user = $this->createUserWithPermission('update-contact');
        $organization = factory(\App\Organization::class)->create();
        $original_name = $organization->organization_name;
        //create updated data
        $organization_name = $this->faker->company;
        $response = $this->actingAs($user)->put(route('organization.update', ['organization' => $organization]), [
          'organization_name' => $organization_name,
          'display_name' => $organization_name,
          'sort_name' => $organization_name,
        ]);

        $updated = \App\Contact::find($organization->id);

        $response->assertRedirect(action('OrganizationController@show', $organization->id));
        $this->assertEquals($updated->sort_name, $organization_name);
        $this->assertNotEquals($updated->organization_name, $original_name);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrganizationController::class,
            'update',
            \App\Http\Requests\UpdateOrganizationRequest::class
        );
    }

    // test cases...
}
