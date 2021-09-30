<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RelationshipController
 */
class RelationshipControllerTest extends TestCase
{
    // use DatabaseTransactions;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {   //TODO: relationship creation currently handled by person controller; this is more of a stub
        $user = $this->createUserWithPermission('create-relationship');

        $response = $this->actingAs($user)->get(route('relationship.create'));

        $response->assertRedirect(action('RelationshipController@index'));
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-relationship');
        $relationship = \App\Models\Relationship::factory()->create();

        $response = $this->actingAs($user)->from('relationship.index')->delete(route('relationship.destroy', [$relationship]));
        $response->assertSessionHas('flash_notification');

        $response->assertRedirect('relationship.index');
        $this->assertSoftDeleted($relationship);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {   //TODO: relationship editing currently handled by person controller; this is more of a stub

        $user = $this->createUserWithPermission('update-relationship');
        $relationship = \App\Models\Relationship::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship.edit', [$relationship]));

        $response->assertRedirect(action('RelationshipController@show', $relationship->id));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-relationship');

        $response = $this->actingAs($user)->get(route('relationship.index'));

        $response->assertOk();
        $response->assertViewIs('relationships.index');
        $response->assertViewHas('relationships');
        $response->assertSeeText('Relationship Index');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-relationship');
        $relationship = \App\Models\Relationship::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship.show', [$relationship]));

        $response->assertOk();
        $response->assertViewIs('relationships.show');
        $response->assertViewHas('relationship');
        $response->assertSeeText($relationship->description);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   //TODO: relationship creation/store currently handled by person controller; this is more of a stub

        $user = $this->createUserWithPermission('create-relationship');

        $response = $this->actingAs($user)->post(route('relationship.store'), [
            'contact_id_a' => null,
            'contact_id_b' => null,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RelationshipController@index'));
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {   //TODO: relationship creation currently handled by person controller; this is more of a stub
        $user = $this->createUserWithPermission('update-relationship');
        $relationship = \App\Models\Relationship::factory()->create();

        $response = $this->actingAs($user)->put(route('relationship.update', [$relationship]), [
          'contact_id_a' => $relationship->contact_id_a,
          'contact_id_b' => $relationship->contact_id_b,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RelationshipController@show', $relationship->id));
    }

    // test cases...
}
