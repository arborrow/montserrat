<?php

namespace Tests\Feature\Http\Controllers;

use App\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

        $this->assertTrue($this->findFieldValueInResponseContent('organization_name', $organization->organization_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('subcontact_type', $organization->subcontact_type, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $organization->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('sort_name', $organization->sort_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('street_address', $organization->address_primary_street_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('supplemental_address_1', $organization->address_primary_supplemental_address_1, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('city', $organization->address_primary_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('state_province_id', $organization->address_primary_state_province_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('postal_code', $organization->address_primary_postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_phone', $organization->phone_main_phone_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_fax', $organization->phone_main_fax_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_primary', $organization->email_primary_text, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note', $organization->note_organization_text, 'textarea', $response->getContent()));


        /*
        {!! Form::text('organization_name', $organization->organization_name, ['class' => 'form-control']) !!}
{!! Form::select('subcontact_type', $subcontact_types, $organization->subcontact_type, ['class' => 'form-control']) !!}
{!! Form::text('display_name', $organization->display_name, ['class' => 'form-control']) !!}
{!! Form::text('sort_name', $organization->sort_name, ['class' => 'form-control']) !!}
{!! Form::text('street_address', $organization->address_primary_street_address, ['class' => 'form-control']) !!}
{!! Form::text('supplemental_address_1', $organization->address_primary_supplemental_address_1, ['class' => 'form-control']) !!}
{!! Form::text('city', $organization->address_primary_city, ['class' => 'form-control']) !!}
{!! Form::select('state_province_id', $states, $organization->address_primary_state_province_id, ['class' => 'form-control']) !!}
{!! Form::text('postal_code', $organization->address_primary_postal_code, ['class' => 'form-control']) !!}
{!! Form::text('phone_main_phone', $organization->phone_main_phone_number, ['class' => 'form-control']) !!}
{!! Form::text('phone_main_fax', $organization->phone_main_fax_number, ['class' => 'form-control']) !!}
    {!! Form::text('email_primary', $organization->email_primary_text, ['class' => 'form-control']) !!}
// TODO: @include('organizations.update.urls')
{!! Form::textarea('note', $organization->note_organization_text, ['class'=>'form-control', 'rows'=>'3']) !!}

         */
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
        $subcontact_type_id = rand(7, 13);
        $response = $this->actingAs($user)->get('organization/type/'.$subcontact_type_id);

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
        $response->assertSeeText($organization->organization_name);

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
          'subcontact_type' => $this->faker->numberBetween(9, 11),

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
