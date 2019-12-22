<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DioceseController
 */
class DioceseControllerTest extends TestCase
{
    use WithFaker;

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

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $diocese = factory(\App\Diocese::class)->create();
        $user = $this->createUserWithPermission('delete-contact');

        $response = $this->actingAs($user)->delete(route('diocese.destroy', [$diocese]));

        $response->assertRedirect(action('DioceseController@index'));
        $this->assertSoftDeleted($diocese);

        // TODO: perform additional assertions such as ensuring all touchpoints, addresses, etc. are also soft deleted
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $diocese = factory(\App\Diocese::class)->create();
        $user = $this->createUserWithPermission('update-contact');

        $response = $this->actingAs($user)->get(route('diocese.edit', [$diocese]));

        $response->assertOk();
        $response->assertViewIs('dioceses.edit');
        $response->assertViewHas('diocese');
        $response->assertViewHas('bishops');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $diocese = factory(\App\Diocese::class)->create();

        $response = $this->actingAs($user)->get(route('diocese.index'));

        $response->assertOk();
        $response->assertViewIs('dioceses.index');
        $response->assertViewHas('dioceses');

        $dioceses = $response->viewData('dioceses');
        $diocese_view = $dioceses->find($diocese->id);
        $count_dioceses = $dioceses->count();
        $this->assertGreaterThanOrEqual('1',$count_dioceses);
        $this->assertEquals($diocese->id, $diocese_view->id);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $diocese = factory(\App\Diocese::class)->create();
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('diocese.show', [$diocese]));

        $response->assertOk();
        $response->assertViewIs('dioceses.show');
        $response->assertViewHas('diocese');
        $response->assertViewHas('relationship_types');
        $response->assertViewHas('files');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $city_name = $this->faker->city;
        $org_name = 'New Diocese of ' . $city_name;

        $response = $this->actingAs($user)->post(route('diocese.store'), [
            'organization_name' => $org_name,
            'display_name' => $org_name,
            'sort_name' => $city_name,
        ]);

        $response->assertRedirect(action('DioceseController@index'));
        $this->assertDatabaseHas('contact', [
          'contact_type' => config('polanco.contact_type.organization'),
          'subcontact_type' => config('polanco.contact_type.diocese'),
          'sort_name' => $city_name,
          'display_name' => $org_name,
        ]);
        // TODO: add testing for storing address, email, phone, website data and then perform additional assertions
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
        $diocese = factory(\App\Diocese::class)->create();
        $user = $this->createUserWithPermission('update-contact');
        $sort_name = $diocese->sort_name;
        $city_name = $this->faker->city;
        $org_name = 'Renewed Diocese of ' . $city_name;

        $response = $this->actingAs($user)->put(route('diocese.update', [$diocese]), [
          'sort_name' => $city_name,
          'display_name' => $org_name,
          'organization_name' => $org_name,

        ]);
        // TODO: test for updating of other fields on the diocese.edit blade like email, phone, address, etc.

        $updated = \App\Contact::find($diocese->id);

        $response->assertRedirect(action('DioceseController@show', $diocese->id));
        $this->assertEquals($updated->sort_name, $city_name);
        $this->assertNotEquals($updated->sort_name, $sort_name);

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

    // test cases...
}
