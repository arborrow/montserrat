<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Organization;
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
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-contact');
        $organization = factory(\App\Models\Organization::class)->create();

        $response = $this->actingAs($user)->delete(route('organization.destroy', ['organization' => $organization]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('OrganizationController@index'));
        $this->assertSoftDeleted($organization);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $organization = factory(\App\Models\Organization::class)->create();
        $organization = \App\Models\Contact::findOrFail($organization->id);

        $organization_note = factory(\App\Models\Note::class)->create([
            'entity_table' => 'contact',
            'entity_id' => $organization->id,
            'subject' => 'Organization Note',
        ]);

        $main_address = factory(\App\Models\Address::class)->create([
            'contact_id' => $organization->id,
            'location_type_id' => config('polanco.location_type.main'),
            'is_primary' => 1,
        ]);

        $main_phone = factory(\App\Models\Phone::class)->create([
            'contact_id' => $organization->id,
            'location_type_id' =>  config('polanco.location_type.main'),
            'is_primary' => 1,
            'phone_type' => 'Phone',
        ]);

        $main_fax = factory(\App\Models\Phone::class)->create([
            'contact_id' => $organization->id,
            'location_type_id' =>  config('polanco.location_type.main'),
            'phone_type' => 'Fax',
        ]);

        $main_email = factory(\App\Models\Email::class)->create([
            'contact_id' => $organization->id,
            'is_primary' => 1,
            'location_type_id' => config('polanco.location_type.main'),
        ]);

        $url_main = factory(\App\Models\Website::class)->create([
            'contact_id' => $organization->id,
            'website_type' => 'Main',
            'url' => $this->faker->url,
        ]);
        $url_work = factory(\App\Models\Website::class)->create([
            'contact_id' => $organization->id,
            'website_type' => 'Work',
            'url' => $this->faker->url,
        ]);
        $url_facebook = factory(\App\Models\Website::class)->create([
            'contact_id' => $organization->id,
            'website_type' => 'Facebook',
            'url' => 'https://facebook.com/'.$this->faker->slug,
        ]);
        $url_instagram = factory(\App\Models\Website::class)->create([
            'contact_id' => $organization->id,
            'website_type' => 'Instagram',
            'url' => 'https://instagram.com/'.$this->faker->slug,
        ]);
        $url_linkedin = factory(\App\Models\Website::class)->create([
            'contact_id' => $organization->id,
            'website_type' => 'LinkedIn',
            'url' => 'https://linkedin.com/'.$this->faker->slug,
        ]);
        $url_twitter = factory(\App\Models\Website::class)->create([
            'contact_id' => $organization->id,
            'website_type' => 'Twitter',
            'url' => 'https://twitter.com/'.$this->faker->slug,
        ]);

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
        $this->assertTrue($this->findFieldValueInResponseContent('street_address', $organization->address_primary_street, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('supplemental_address_1', $organization->address_primary_supplemental_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('city', $organization->address_primary_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('state_province_id', $organization->address_primary_state_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('postal_code', $organization->address_primary_postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_phone', $organization->phone_main_phone_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_fax', $organization->phone_main_fax_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_primary', $organization->email_primary_text, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note', $organization->note_organization_text, 'textarea', $response->getContent()));

        // urls
        $this->assertTrue($this->findFieldValueInResponseContent('url_main', $url_main->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_work', $url_work->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_facebook', $url_facebook->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_instagram', $url_instagram->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_linkedin', $url_linkedin->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_twitter', $url_twitter->url, 'text', $response->getContent()));
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
        $organization = factory(\App\Models\Organization::class)->create();

        $response = $this->actingAs($user)->get(route('organization.show', ['organization' => $organization]));

        $response->assertOk();
        $response->assertViewIs('organizations.show');
        $response->assertViewHas('organization');
        $response->assertViewHas('files');
        $response->assertViewHas('relationship_types');
        $response->assertSeeText($organization->organization_name);
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
        $response->assertSessionHas('flash_notification');
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
        $organization = factory(\App\Models\Contact::class)->create();
        $original_name = $organization->organization_name;
        //create updated data
        $organization_name = $this->faker->company;
        $response = $this->actingAs($user)->put(route('organization.update', ['organization' => $organization]), [
          'organization_name' => $organization_name,
          'display_name' => $organization_name,
          'sort_name' => $organization_name,
        ]);

        $updated = \App\Models\Contact::find($organization->id);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('OrganizationController@show', $organization->id));
        $this->assertEquals($updated->sort_name, $organization_name);
        $this->assertNotEquals($updated->organization_name, $original_name);
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
