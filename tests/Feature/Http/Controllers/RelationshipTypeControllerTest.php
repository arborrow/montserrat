<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\RelationshipType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Carbon\Carbon;

/**
 * @see \App\Http\Controllers\RelationshipTypeController
 */
class RelationshipTypeControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function add_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-relationship');
        $user->assignRole('test-role:relationship_type_add');
        $relationship_type = \App\Models\RelationshipType::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship_type.add', ['id' => $relationship_type->id]));
        // dd($response);
        $response->assertOk();
        $response->assertViewIs('relationships.types.add');
        $response->assertViewHas('relationship_type');
        $response->assertViewHas('contact_a_list');
        $response->assertViewHas('contact_b_list');

        $response->assertSeeText($relationship_type->description);
    }

    /**
     * @test
     */
    public function add_with_a_and_b_returns_an_ok_response()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-relationship');
        $user->assignRole('test-role:relationship_type_add');
        $relationship_type = \App\Models\RelationshipType::factory()->create();

        // for simplicity just testing with individuals
        $contact_a = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => '0',
        ]);
        $contact_b = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => '0',
        ]);

        $relationship_type = \App\Models\RelationshipType::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship_type.add',
            ['id' => $relationship_type->id, 'a' => $contact_a->id, 'b' => $contact_b->id]));
        // dd($response);
        $response->assertOk();
        $response->assertViewIs('relationships.types.add');
        $response->assertViewHas('relationship_type');
        $response->assertViewHas('contact_a_list', function ($a_contacts) use ($contact_a) {
            return Arr::exists($a_contacts, $contact_a->id);
        });
        $response->assertViewHas('contact_b_list', function ($b_contacts) use ($contact_b) {
            return Arr::exists($b_contacts, $contact_b->id);
        });
        $response->assertSeeText($relationship_type->description);
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

        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);
        $relationship_type = array_rand(array_flip(['Child', 'Employee', 'Husband', 'Parent', 'Parishioner', 'Sibling', 'Wife']));
        $response = $this->actingAs($user)->post(route('relationship_type.addme'), [
            'relationship_type' => $relationship_type,
            'contact_id' => $contact->id,
        ]);

        switch ($relationship_type) {
            case 'Child':
            case 'Husband':
            case 'Sibling':
            case 'Employee':
                $relationship_type_id = \App\Models\RelationshipType::whereNameAB($relationship_type)->first();
                $response->assertRedirect(route('relationship_type.add', ['id' => $relationship_type_id->id, 'a' => $contact->id]));
                break;
            case 'Parent':
            case 'Wife':
            case 'Employer':
            case 'Volunteer':
            case 'Parishioner':
            case 'Primary contact':
                $relationship_type_id = \App\Models\RelationshipType::whereNameBA($relationship_type)->first();
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

        $relationship_type = \App\Models\RelationshipType::factory()->create();

        $response = $this->actingAs($user)->delete(route('relationship_type.destroy', [$relationship_type]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RelationshipTypeController::class, 'index']));
        $this->assertSoftDeleted($relationship_type);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-relationshiptype');
        $relationship_type = \App\Models\RelationshipType::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship_type.edit', [$relationship_type]));

        $response->assertOk();
        $response->assertViewIs('relationships.types.edit');
        $response->assertViewHas('relationship_type');
        $response->assertSeeText('Edit Relationship Type');
        $response->assertSeeText($relationship_type->description);

        $this->assertTrue($this->findFieldValueInResponseContent('name_a_b', $relationship_type->name_a_b, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('label_a_b', $relationship_type->label_a_b, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('name_b_a', $relationship_type->name_b_a, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('label_b_a', $relationship_type->label_b_a, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $relationship_type->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $relationship_type->is_active, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_reserved', $relationship_type->is_reserved, 'checkbox', $response->getContent()));

        /*
        {!! Form::text('name_a_b', $relationship_type->name_a_b, ['class' => 'col-md-3']) !!}
        {!! Form::text('label_a_b', $relationship_type->label_a_b, ['class' => 'col-md-3']) !!}
        {!! Form::text('name_b_a', $relationship_type->name_b_a, ['class' => 'col-md-3']) !!}
        {!! Form::text('label_b_a', $relationship_type->label_b_a, ['class' => 'col-md-3']) !!}
        {!! Form::textarea('description', $relationship_type->description, ['class' => 'col-md-3']) !!}
        {!! Form::checkbox('is_active', true, $relationship_type->is_active,['class' => 'col-md-1']) !!}
        {!! Form::checkbox('is_reserved', false, $relationship_type->is_reserved, ['class' => 'col-md-1']) !!}
         */
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-relationshiptype');
        $relationship_type = \App\Models\RelationshipType::factory()->create();

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
    public function make_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-relationship');

        $contact_a = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);
        $contact_b = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        // generically testing for ability to create sibling relationship to avoid complexity of contact types and subtypes
        $relationship_type_id = config('polanco.relationship_type.sibling');

        $response = $this->actingAs($user)->from('relationship_type/'.config('polanco.relationship_type.sibling').'/add/'.$contact_a->id.'/'.$contact_b->id)->post('relationship/add', [
            'contact_a_id' => $contact_a->id,
            'contact_b_id' => $contact_b->id,
            'relationship_type_id' => $relationship_type_id,
        ]);

        $response->assertRedirect('person/'.$contact_b->id);
        $this->assertDatabaseHas('relationship', [
            'contact_id_a' => $contact_a->id,
            'contact_id_b' => $contact_b->id,
            'relationship_type_id' => $relationship_type_id,
        ]);
    }

    /**
     * @test
     */
    public function make_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RelationshipTypeController::class,
            'make',
            \App\Http\Requests\MakeRelationshipTypeRequest::class
        );
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-relationshiptype');
        $relationship_type = \App\Models\RelationshipType::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship_type.show', [$relationship_type]));

        $response->assertOk();
        $response->assertViewIs('relationships.types.show');
        $response->assertViewHas('relationship_type');
        $response->assertViewHas('relationships');
        $response->assertSeeText($relationship_type->description);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-relationshiptype');

        $name_a_b = $this->faker->company();
        $name_b_a = $this->faker->jobTitle();
        $description = $this->faker->catchPhrase();

        $response = $this->actingAs($user)->post(route('relationship_type.store'), [
            'name_a_b' => $name_a_b,
            'name_b_a' => $name_b_a,
            'label_a_b' => 'has a '.$this->faker->word().' of ',
            'label_b_a' => $this->faker->word().' for ',
            'description' => $description,
            'contact_type_a' => array_rand(array_flip(['Individual', 'Organization', 'Household'])),
            'contact_type_b' => array_rand(array_flip(['Individual', 'Organization', 'Household'])),
            'contact_sub_type_a' => null,
            'contact_sub_type_b' => null,
            'is_reserved' => 0,
            'is_active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $response->assertRedirect(action([\App\Http\Controllers\RelationshipTypeController::class, 'index']));
        $response->assertSessionHas('flash_notification');
        $this->assertDatabaseHas('relationship_type', [
            'name_a_b' => $name_a_b,
            'name_b_a' => $name_b_a,
            'description' => $description,
        ]);
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

        $relationship_type = \App\Models\RelationshipType::factory()->create();
        $original_description = $relationship_type->description;
        $new_name_a_b = $this->faker->company();
        $new_name_b_a = $this->faker->jobTitle();
        $new_description = $this->faker->catchPhrase();

        $response = $this->actingAs($user)->put(route('relationship_type.update', [$relationship_type]), [
            'id' => $relationship_type->id,
            'name_a_b' => $new_name_a_b,
            'name_b_a' => $new_name_b_a,
            'label_a_b' => 'has a '.$this->faker->word().' of ',
            'label_b_a' => $this->faker->word().' for ',
            'description' => $new_description,

        ]);
        // dd($response,$relationship_type->id);
        $updated = \App\Models\RelationshipType::findOrFail($relationship_type->id);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RelationshipTypeController::class, 'index']));
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
