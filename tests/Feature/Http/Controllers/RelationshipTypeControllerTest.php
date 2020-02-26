<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\RelationshipType;

/**
 * @see \App\Http\Controllers\RelationshipTypeController
 */
class RelationshipTypeConrollerTest extends TestCase
{
    use withFaker;

    /**
     * @test
     */
    public function add_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-relationship');
        $user->assignRole('test-role:relationship_type_add');
        $relationship_type = factory(\App\RelationshipType::class)->create();

        $response = $this->actingAs($user)->get(route('relationship_type.add', ['id' => $relationship_type->id]));
        // dd($response);
        $response->assertOk();
        $response->assertViewIs('relationships.types.add');
        $response->assertViewHas('relationship_type');
        $response->assertViewHas('contact_a_list');
        $response->assertViewHas('contact_b_list');

        $response->assertSeeText(e($relationship_type->description));
    }

    /**
     * @test
     */
    public function addme_returns_an_ok_response()
    {   /* TODO: evaluate relationships and use of this function throughout Polanco, we may be able to remove addme from controller altogether
        // technically this is adding a relationship (not a relationship_type) so a bit of mismatch
        // relationship_types are manually defined in each contoller for persons and $organizations resulting in far more logic than normal in a test
        // for now, for the the sake of simplicity, we will only test for one random relationship_type for basic functionality
        // namely, we will create a user and show the addme form for a random relationship_type
        */

        $user = $this->createUserWithPermission('create-relationship');

        $contact = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);
        $relationship_type = array_rand(array_flip(array('Child','Employee','Husband','Parent','Parishioner','Sibling','Wife')));
        $response = $this->actingAs($user)->post(route('relationship_type.addme'), [
            'relationship_type' => $relationship_type,
            'contact_id' => $contact->id,
          ]);

        switch ($relationship_type) {
            case 'Child':
            case 'Husband':
            case 'Sibling':
            case 'Employee':
                $relationship_type_id = \App\RelationshipType::whereNameAB($relationship_type)->first();
                $response->assertRedirect(route('relationship_type.add', ['id' => $relationship_type_id->id, 'a' => $contact->id]));
                break;
            case 'Parent':
            case 'Wife':
            case 'Employer':
            case 'Volunteer':
            case 'Parishioner':
            case 'Primary contact':
                $relationship_type_id = \App\RelationshipType::whereNameBA($relationship_type)->first();
                $response->assertRedirect(route('relationship_type.add', ['id' => $relationship_type_id->id, 'a' => 0, 'b' => $contact->id]));
                break;
            }
    }

    /**
     * @test
     */
    public function addme_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RelationshipTypeController::class,
            'addme',
            \App\Http\Requests\AddmeRelationshipTypeRequest::class
        );
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-relationshiptype');

        $response = $this->actingAs($user)->get(route('relationship_type.create'));

        $response->assertOk();
        $response->assertViewIs('relationships.types.create');
        $response->assertViewHas('contact_types');
        $response->assertSeeText('Create Relationship Type');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-relationshiptype');

        $relationship_type = factory(\App\RelationshipType::class)->create();

        $response = $this->actingAs($user)->delete(route('relationship_type.destroy', [$relationship_type]));

        $response->assertRedirect(action('RelationshipTypeController@index'));
        $this->assertSoftDeleted($relationship_type);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-relationshiptype');
        $relationship_type = factory(\App\RelationshipType::class)->create();

        $response = $this->actingAs($user)->get(route('relationship_type.edit', [$relationship_type]));

        $response->assertOk();
        $response->assertViewIs('relationships.types.edit');
        $response->assertViewHas('relationship_type');
        $response->assertSeeText('Edit Relationship Type');
        $response->assertSeeText(e($relationship_type->description));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-relationshiptype');
        $relationship_type = factory(\App\RelationshipType::class)->create();

        $response = $this->actingAs($user)->get(route('relationship_type.index'));

        $response->assertOk();
        $response->assertViewIs('relationships.types.index');
        $response->assertViewHas('relationship_types');
        $relationship_types = $response->viewData('relationship_types');
        $this->assertGreaterThanOrEqual('1', $relationship_types->count());
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-relationshiptype');
        $relationship_type = factory(\App\RelationshipType::class)->create();

        $response = $this->actingAs($user)->get(route('relationship_type.show', [$relationship_type]));

        $response->assertOk();
        $response->assertViewIs('relationships.types.show');
        $response->assertViewHas('relationship_type');
        $response->assertViewHas('relationships');
        $response->assertSeeText(e($relationship_type->description));
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-relationshiptype');

        $name_a_b = $this->faker->company;
        $name_b_a = $this->faker->jobTitle;
        $description = $this->faker->catchPhrase;

        $response = $this->actingAs($user)->post(route('relationship_type.store'), [
          'name_a_b' => $name_a_b,
          'name_b_a' => $name_b_a,
          'label_a_b' => 'has a ' . $this->faker->word .' of ',
          'label_b_a' => $this->faker->word . ' for ',
          'description' => $description,
          'contact_type_a' => array_rand(array_flip(['Individual','Organization','Household'])),
          'contact_type_b' => array_rand(array_flip(['Individual','Organization','Household'])),
          'contact_sub_type_a' => null,
          'contact_sub_type_b' => null,
          'is_reserved' => 0,
          'is_active' => 1,
          'created_at' => $this->faker->dateTime('now'),
          'updated_at' => $this->faker->dateTime('now')
        ]);
        $response->assertRedirect(action('RelationshipTypeController@index'));
        $this->assertDatabaseHas('relationship_type', [
          'name_a_b' => $name_a_b,
          'name_b_a' => $name_b_a,
          'description' => $description,
        ]);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RelationshipTypeController::class,
            'store',
            \App\Http\Requests\StoreRelationshipTypeRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-relationshiptype');

        $relationship_type = factory(\App\RelationshipType::class)->create();
        $original_description = $relationship_type->description;
        $new_name_a_b = $this->faker->company;
        $new_name_b_a = $this->faker->jobTitle;
        $new_description = $this->faker->catchPhrase;

        $response = $this->actingAs($user)->put(route('relationship_type.update', [$relationship_type]), [
          'id' => $relationship_type->id,
          'name_a_b' => $new_name_a_b,
          'name_b_a' => $new_name_b_a,
          'label_a_b' => 'has a ' . $this->faker->word .' of ',
          'label_b_a' => $this->faker->word . ' for ',
          'description' => $new_description,

        ]);
        // dd($response,$relationship_type->id);
        $updated = \App\RelationshipType::findOrFail($relationship_type->id);

        $response->assertRedirect(action('RelationshipTypeController@index'));
        $this->assertEquals($updated->description, $new_description);
        $this->assertNotEquals($updated->description, $original_description);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RelationshipTypeController::class,
            'update',
            \App\Http\Requests\UpdateRelationshipTypeRequest::class
        );
    }

    // test cases...
}
