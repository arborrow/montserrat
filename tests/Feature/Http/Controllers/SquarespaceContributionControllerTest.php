<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SsInventoryController
 */
class SquarespaceContributionControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        // emtpy slug redirects to squarespace.contribution.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('show-squarespace-contribution');
        $response = $this->actingAs($user)->get(route('squarespace.contribution.create'));

        $response->assertOk();
        $response->assertViewIs('squarespace.contribution.index');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        // emtpy slug redirects to squarespace.contribution.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('show-squarespace-contribution');

        $contribution = \App\Models\SsContribution::factory()->create();

        $response = $this->actingAs($user)->delete(route('squarespace.contribution.destroy', [$contribution]));

        $response->assertOk();
        $response->assertViewIs('squarespace.contribution.index');

        
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-contribution');
        $donor = \App\Models\Contact::factory()->create();
        $retreat = \App\Models\Retreat::factory()->create();
        $contribution = \App\Models\SsContribution::factory()->create(['contact_id' => $donor->id, 'event_id' => $retreat->id]);

        $response = $this->actingAs($user)->get(route('squarespace.contribution.edit', [$contribution]));

        $response->assertOk();
        $response->assertViewIs('squarespace.contribution.edit');
        $response->assertViewHas('ss_contribution');
        $response->assertViewHas('matching_contacts');
        $response->assertViewHas('retreats');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('ids');
        $response->assertSeeText('Process Squarespace Contribution #'.$contribution->id);

        /*
        // TODO: come back and add these checks in later
        {!! Form::hidden('id', $ss_contribution->id) !!}
        {!! Form::select('event_id', $retreats, (isset($ss_contribution->event_id)) ? $ss_contribution->event_id : $ids['retreat_id'], ['class' => 'form-control']) !!}
        {!! Form::select('address_country_id', $countries, $ids['address_country'], ['class' => 'form-control']) !!}
        {!! Form::select('address_state_id', $states, $ids['address_state'], ['class' => 'form-control']) !!}
        
        {!! Form::select('donation_description', config('polanco.donation_descriptions'), (isset($ss_contribution->fund)) ? $ss_contribution->fund : $ss_contribution->offering_type, ['class' => 'form-control']) !!}
        {!! Form::text('name', ucwords(strtolower($ss_contribution->name)), ['class' => 'form-control']) !!}
        {!! Form::text('first_name', ucwords(strtolower(trim(substr($ss_contribution->name,0,strpos($ss_contribution->name,' '))))), ['class' => 'form-control']) !!}
        {!! Form::text('last_name', ucwords(strtolower(trim(substr($ss_contribution->name,strrpos($ss_contribution->name,' '))))), ['class' => 'form-control']) !!}
        {!! Form::text('email', trim($ss_contribution->email), ['class' => 'form-control']) !!}
        {!! Form::text('phone', $ss_contribution->phone, ['class' => 'form-control']) !!}
        {!! Form::text('address_street', ucwords(strtolower($ss_contribution->address_street)), ['class' => 'form-control']) !!}
        {!! Form::text('address_supplemental', $ss_contribution->address_supplemental, ['class' => 'form-control']) !!}
        {!! Form::text('address_city', ucwords(strtolower($ss_contribution->address_city)), ['class' => 'form-control']) !!}
        {!! Form::text('address_zip', $ss_contribution->address_zip, ['class' => 'form-control']) !!}
        {!! Form::number('amount', $ss_contribution->amount, ['class' => 'form-control','step'=>'0.01']) !!}
        {!! Form::text('comments', $ss_contribution->comments, ['class' => 'form-control']) !!}

        */

        // for simplicity assigning a contact_id and event_id since the goal here is to assure that the existing data is auto-populated/selected
        $this->assertTrue($this->findFieldValueInResponseContent('contact_id', null, 'select', $response->getContent()));
        // $this->assertTrue($this->findFieldValueInResponseContent('event_id', $contribution->event_id, 'select', $response->getContent()));
        // TODO: review how best to handle ampersand in Building & Maintenance (and others)
        $this->assertTrue($this->findFieldValueInResponseContent('donation_description', (isset($contribution->fund)) ? $contribution->fund : $contribution->offering_type, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('name', ucwords(strtolower($contribution->name)), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('first_name', ucwords(strtolower(trim(substr($contribution->name,0,strpos($contribution->name,' '))))), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('last_name', ucwords(strtolower(trim(substr($contribution->name,strrpos($contribution->name,' '))))), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email', trim($contribution->email), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone', $contribution->phone, 'text', $response->getContent()));
        
        $this->assertTrue($this->findFieldValueInResponseContent('address_street', $contribution->address_street, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_supplemental', $contribution->address_supplemental, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_city', $contribution->address_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_zip', $contribution->address_zip, 'text', $response->getContent()));
 
        $this->assertTrue($this->findFieldValueInResponseContent('amount', number_format($contribution->amount,2), 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('comments', $contribution->comments, 'text', $response->getContent()));
        

    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-contribution');

        $response = $this->actingAs($user)->get(route('squarespace.contribution.index'));

        $response->assertOk();
        $response->assertViewIs('squarespace.contribution.index');
        $response->assertViewHas('processed_ss_contributions');
        $response->assertViewHas('ss_contributions');
        $response->assertSeeText('Index of Squarespace Contributions');
    }


    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-contribution');
        $contribution = \App\Models\SsContribution::factory()->create();

        $response = $this->actingAs($user)->get(route('squarespace.contribution.show', [$contribution]));

        $response->assertOk();
        $response->assertViewIs('squarespace.contribution.show');
        $response->assertViewHas('ss_contribution');
        $response->assertSeeText('Squarespace Contribution #'.$contribution->id);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {  
        // emtpy slug redirects to squarespace.contribution.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('show-squarespace-contribution');

        $response = $this->actingAs($user)->post(route('squarespace.contribution.store'), [
            'amount' => $this->faker->numberBetween(100,600),
        ]);

        $response->assertOk();
        $response->assertViewIs('squarespace.contribution.index');
        
    }

    /**
     * 
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-inventory');

        $inventory = \App\Models\SsInventory::factory()->create();

        $original_name = $inventory->name;
        $new_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('inventory.update', [$inventory]), [
            'id' => $inventory->id,
            'name' => $new_name,
            'custom_form_id' => $inventory->custom_form_id,
            'variant_options' => $this->faker->numberBetween(6,8),
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SsInventoryController::class, 'show'], $inventory->id));

        $updated = \App\Models\SsInventory::findOrFail($inventory->id);

        $this->assertEquals($updated->name, $new_name);
        $this->assertNotEquals($updated->name, $original_name);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceContributionController::class,
            'update',
            \App\Http\Requests\UpdateSquarespaceContributionRequest::class
        );
    }

}
