<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DioceseController
 */
class DioceseControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $response = $this->actingAs($user)->get(route('diocese.create'));

        $response->assertOk();
        $response->assertViewIs('dioceses.create');
        $response->assertViewHas('bishops');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSee('Add a Diocese');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $diocese = \App\Models\Diocese::factory()->create();
        $user = $this->createUserWithPermission('delete-contact');

        $response = $this->actingAs($user)->delete(route('diocese.destroy', [$diocese]));
        $response->assertSessionHas('flash_notification');

        $response->assertRedirect(action([\App\Http\Controllers\DioceseController::class, 'index']));
        $this->assertSoftDeleted($diocese);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $diocese = \App\Models\Diocese::factory()->create();
        $diocese = \App\Models\Contact::findOrFail($diocese->id);
        $main_address = \App\Models\Address::factory()->create([
            'contact_id' => $diocese->id,
            'location_type_id' => config('polanco.location_type.main'),
            'is_primary' => 1,
        ]);

        $main_phone = \App\Models\Phone::factory()->create([
            'contact_id' => $diocese->id,
            'location_type_id' =>  config('polanco.location_type.main'),
            'is_primary' => 1,
            'phone_type' => 'Phone',
        ]);

        $main_fax = \App\Models\Phone::factory()->create([
            'contact_id' => $diocese->id,
            'location_type_id' =>  config('polanco.location_type.main'),
            'phone_type' => 'Fax',
        ]);

        $main_email = \App\Models\Email::factory()->create([
            'contact_id' => $diocese->id,
            'is_primary' => 1,
            'location_type_id' => config('polanco.location_type.main'),
        ]);

        $url_main = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'Main',
            'url' => $this->faker->url(),
        ]);
        $url_work = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'Work',
            'url' => $this->faker->url(),
        ]);
        $url_facebook = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'Facebook',
            'url' => 'https://facebook.com/'.$this->faker->slug(),
        ]);
        $url_google = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'Google',
            'url' => 'https://google.com/'.$this->faker->slug(),
        ]);
        $url_instagram = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'Instagram',
            'url' => 'https://instagram.com/'.$this->faker->slug(),
        ]);
        $url_linkedin = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'LinkedIn',
            'url' => 'https://linkedin.com/'.$this->faker->slug(),
        ]);
        $url_twitter = \App\Models\Website::factory()->create([
            'contact_id' => $diocese->id,
            'website_type' => 'Twitter',
            'url' => 'https://twitter.com/'.$this->faker->slug(),
        ]);

        $response = $this->actingAs($user)->get(route('diocese.edit', [$diocese]));
        $contact = \App\Models\Contact::findOrFail($diocese->id);
        $response->assertOk();
        $response->assertViewIs('dioceses.edit');
        $response->assertViewHas('diocese');
        $response->assertViewHas('bishops');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Edit');
        $response->assertSeeText($diocese->display_name);
        // dd($contact->address_primary_street);
        $this->assertTrue($this->findFieldValueInResponseContent('bishop_id', $diocese->bishop_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('organization_name', $diocese->organization_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $diocese->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('sort_name', $diocese->sort_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('street_address', $contact->address_primary_street, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('supplemental_address_1', $diocese->address_primary_supplemental_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('city', $diocese->address_primary_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('state_province_id', $diocese->address_primary_state_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('postal_code', $diocese->address_primary_postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_phone', $diocese->phone_main_phone_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_fax', $diocese->phone_main_fax_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_primary', $diocese->email_primary_text, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('diocese_note', $diocese->note_diocese_text, 'textarea', $response->getContent()));

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
        $diocese = \App\Models\Diocese::factory()->create();

        $response = $this->actingAs($user)->get(route('diocese.index'));

        $dioceses = $response->viewData('dioceses');

        $response->assertOk();
        $response->assertViewIs('dioceses.index');
        $response->assertViewHas('dioceses');
        $this->assertGreaterThanOrEqual('1', $dioceses->count());
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $diocese = \App\Models\Diocese::factory()->create();
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('diocese.show', [$diocese]));

        $response->assertOk();
        $response->assertViewIs('dioceses.show');
        $response->assertViewHas('diocese');
        $response->assertViewHas('relationship_types');
        $response->assertViewHas('files');
        $response->assertSeeText($diocese->display_name);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $city_name = $this->faker->city();
        $org_name = 'New Diocese of '.$city_name;

        $response = $this->actingAs($user)->post(route('diocese.store'), [
            'organization_name' => $org_name,
            'display_name' => $org_name,
            'sort_name' => $city_name,
            'diocese_note' => $city_name.' Diocesan note',
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\DioceseController::class, 'index']));
        $this->assertDatabaseHas('contact', [
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.diocese'),
            'sort_name' => $city_name,
            'display_name' => $org_name,
        ]);
        $this->assertDatabaseHas('note', [
            'entity_table' => 'contact',
            'note' => $city_name.' Diocesan note',
            'subject' => 'Diocese Note',
        ]);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DioceseController::class,
            'store',
            \App\Http\Requests\StoreDioceseRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $diocese = \App\Models\Diocese::factory()->create();
        $sort_name = $diocese->sort_name;
        $city_name = $this->faker->city();
        $org_name = 'Renewed Diocese of '.$city_name;
        $diocese_note = $city_name.' Diocesan note updated';

        $response = $this->actingAs($user)->put(route('diocese.update', [$diocese]), [
            'sort_name' => $city_name,
            'display_name' => $org_name,
            'organization_name' => $org_name,
            'diocese_note' => $diocese_note,
        ]);
        // TODO: test for updating of other fields on the diocese.edit blade like email, phone, address, etc.

        $diocese->refresh();
        $response->assertRedirect(action([\App\Http\Controllers\DioceseController::class, 'show'], $diocese->id));
        $response->assertSessionHas('flash_notification');
        $this->assertEquals($diocese->sort_name, $city_name);
        $this->assertNotEquals($diocese->sort_name, $sort_name);
        $this->assertEquals($diocese->note_diocese_text, $diocese_note);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DioceseController::class,
            'update',
            \App\Http\Requests\UpdateDioceseRequest::class
        );
    }
}
