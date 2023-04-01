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
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {   //TODO: relationship creation currently handled by person controller; this is more of a stub
        $user = $this->createUserWithPermission('create-relationship');

        $response = $this->actingAs($user)->get(route('relationship.create'));

        $response->assertRedirect(action([\App\Http\Controllers\RelationshipController::class, 'index']));
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
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
    public function edit_returns_an_ok_response(): void
    {   //TODO: relationship editing currently handled by person controller; this is more of a stub
        $user = $this->createUserWithPermission('update-relationship');
        $relationship = \App\Models\Relationship::factory()->create();

        $response = $this->actingAs($user)->get(route('relationship.edit', [$relationship]));

        $response->assertRedirect(action([\App\Http\Controllers\RelationshipController::class, 'show'], $relationship->id));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
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
    public function show_returns_an_ok_response(): void
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
    public function store_returns_an_ok_response(): void
    {   //TODO: relationship creation/store currently handled by person controller; this is more of a stub
        $user = $this->createUserWithPermission('create-relationship');

        $response = $this->actingAs($user)->post(route('relationship.store'), [
            'contact_id_a' => null,
            'contact_id_b' => null,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RelationshipController::class, 'index']));
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {   //TODO: relationship creation currently handled by person controller; this is more of a stub
        $user = $this->createUserWithPermission('update-relationship');
        $relationship = \App\Models\Relationship::factory()->create();

        $response = $this->actingAs($user)->put(route('relationship.update', [$relationship]), [
            'contact_id_a' => $relationship->contact_id_a,
            'contact_id_b' => $relationship->contact_id_b,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RelationshipController::class, 'show'], $relationship->id));
    }

    /**
     * @test
     */
    public function disjoined_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-contact');

        $response = $this->actingAs($user)->get(route('relationship.disjoined'));

        $response->assertOk();
        $response->assertViewIs('relationships.disjoined');
        $response->assertViewHas('couples');
        $response->assertSeeText('Disjoined Couples Index');
    }

    /**
     * @test
     */
    public function rejoin_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-contact');
        $relationship = \App\Models\Relationship::factory()->create(['relationship_type_id' => config('polanco.relationship_type.husband_wife')]);
        $husband_address = \App\Models\Address::factory()->create(['contact_id' => $relationship->contact_id_a, 'is_primary' => 1]);
        $wife_address = \App\Models\Address::factory()->create(['contact_id' => $relationship->contact_id_b, 'is_primary' => 1]);

        $response = $this->actingAs($user)->from(URL('registration/disjoined'))->get(route('relationship.rejoin', [
            'id' => $relationship->id,
            'dominant' => $relationship->contact_id_a,
        ]));

        $response->assertRedirect('registration/disjoined');
        $this->assertEquals($relationship->contact_a_address, $relationship->contact_b_address);
    }

    // test cases...
}
