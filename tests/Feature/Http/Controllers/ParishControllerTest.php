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

        $response->assertRedirect(action('ParishController@index'));
        $this->assertSoftDeleted($parish);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $parish = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.parish'),
        ]);

        $main_address = factory(\App\Address::class)->create([
            'contact_id' => $parish->id,
            'location_type_id' => config('polanco.location_type.main'),
            'is_primary' => 1,
        ]);

        $main_phone = factory(\App\Phone::class)->create([
            'contact_id' => $parish->id,
            'location_type_id' =>  config('polanco.location_type.main'),
            'is_primary' => 1,
            'phone_type' => 'Phone',
        ]);

        $main_fax = factory(\App\Phone::class)->create([
            'contact_id' => $parish->id,
            'location_type_id' =>  config('polanco.location_type.main'),
            'phone_type' => 'Fax',
        ]);

        $main_email = factory(\App\Email::class)->create([
            'contact_id' => $parish->id,
            'is_primary' => 1,
            'location_type_id' => config('polanco.location_type.main'),
        ]);

        $url_main = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'Main',
            'url' => $this->faker->url,
        ]);
        $url_work = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'Work',
            'url' => $this->faker->url,
        ]);
        $url_facebook = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'Facebook',
            'url' => 'https://facebook.com/'.$this->faker->slug,
        ]);
        $url_google = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'Google',
            'url' => 'https://google.com/'.$this->faker->slug,
        ]);
        $url_instagram = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'Instagram',
            'url' => 'https://instagram.com/'.$this->faker->slug,
        ]);
        $url_linkedin = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'LinkedIn',
            'url' => 'https://linkedin.com/'.$this->faker->slug,
        ]);
        $url_twitter = factory(\App\Website::class)->create([
            'contact_id' => $parish->id,
            'website_type' => 'Twitter',
            'url' => 'https://twitter.com/'.$this->faker->slug,
        ]);

        $response = $this->actingAs($user)->get(route('parish.edit', [$parish]));

        $response->assertOk();
        $response->assertViewIs('parishes.edit');
        $response->assertViewHas('parish');
        $response->assertViewHas('dioceses');
        $response->assertViewHas('pastors');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText($parish->organization_name);

        $this->assertTrue($this->findFieldValueInResponseContent('organization_name', $parish->organization_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $parish->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('sort_name', $parish->sort_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('diocese_id', $parish->diocese_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('pastor_id', $parish->pastor_id, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('street_address', $parish->address_primary_street, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('city', $parish->address_primary_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('state_province_id', $parish->address_primary_state_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('postal_code', $parish->address_primary_postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_phone', $parish->phone_main_phone_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_fax', $parish->phone_main_fax_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_primary', $parish->email_primary_text, 'text', $response->getContent()));

        // urls
        $this->assertTrue($this->findFieldValueInResponseContent('url_main', $url_main->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_work', $url_work->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_facebook', $url_facebook->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_instagram', $url_instagram->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_linkedin', $url_linkedin->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_twitter', $url_twitter->url, 'text', $response->getContent()));
        // TODO: add note
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

        $response = $this->actingAs($user)->get('parishes/diocese/'.$diocese->id);
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
        $response->assertSeeText($parish->display_name);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');
        $parish_name = 'St. '.$this->faker->firstName.' Parish';

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
        $new_parish_name = 'St. '.$this->faker->firstName.' Parish of the Renewal';

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
