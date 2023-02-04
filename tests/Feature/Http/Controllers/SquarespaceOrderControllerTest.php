<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SquarespaceOrderController
 */
class SquarespaceOrderControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        // emtpy slug redirects to squarespace.order.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('show-squarespace-order');
        $response = $this->actingAs($user)->get(route('squarespace.order.create'));

        $response->assertOk();
        $response->assertViewIs('squarespace.order.index');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        // emtpy slug redirects to squarespace.order.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('show-squarespace-order');

        $order = \App\Models\SquarespaceOrder::factory()->create();

        $response = $this->actingAs($user)->delete(route('squarespace.order.destroy', [$order]));

        $response->assertOk();
        $response->assertViewIs('squarespace.order.index');

    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-squarespace-order');
        $retreatant = \App\Models\Contact::factory()->create();
        $retreat = \App\Models\Retreat::factory()->create();
        $order = \App\Models\SquarespaceOrder::factory()->create(['contact_id' => $retreatant->id, 'event_id' => $retreat->id]);
        $order->retreat_quantity = 2; //manually set because normally it is not visible on the edit form
        $order->additional_names_and_phone_numbers = $this->faker->name() . ' ' . $this->faker->phoneNumber();
        $order->gift_certificate_number = $this->faker->numberBetween(100,999);
        $order->save();

        $response = $this->actingAs($user)->get(route('squarespace.order.edit', [$order]));

        $response->assertOk();
        $response->assertViewIs('squarespace.order.edit');
        $response->assertViewHas('order');
        $response->assertViewHas('matching_contacts');
        $response->assertViewHas('retreats');
        $response->assertViewHas('couple_matching_contacts');
        $response->assertViewHas('prefixes');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('languages');
        $response->assertViewHas('parish_list');
        $response->assertViewHas('ids');
        
        // for simplicity assigning a contact_id and event_id since the goal here is to assure that the existing data is auto-populated/selected
        $this->assertTrue($this->findFieldValueInResponseContent('contact_id', $order->contact_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('event_id', $order->event_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('deposit_amount', number_format($order->deposit_amount,2), 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('retreat_quantity', $order->retreat_quantity, 'number', $response->getContent()));
        if ($order->is_couple) {
            $this->assertTrue($this->findFieldValueInResponseContent('couple_contact_id', (isset($order->couple_contact_id)) ? $order->couple_contact_id : 0, 'select', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_name', ucwords(strtolower($order->couple_name)), 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_first_name', ucwords(strtolower(trim(substr($order->couple_name,0,strpos($order->couple_name,' '))))), 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_last_name', ucwords(strtolower(trim(substr($order->couple_name,strrpos($order->couple_name,' '))))), 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_nick_name', null, 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_middle_name', null, 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_email', trim($order->couple_email), 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_mobile_phone', $order->couple_mobile_phone, 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_emergency_contact', $order->couple_emergency_contact, 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_emergency_contact_relationship', $order->couple_emergency_contact_relationship, 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_emergency_contact_phone', $order->couple_emergency_contact_phone, 'text', $response->getContent()));
            $this->assertTrue($this->findFieldValueInResponseContent('couple_dietary', $order->couple_dietary, 'text', $response->getContent()));                
            $this->assertTrue($this->findFieldValueInResponseContent('couple_health', null, 'text', $response->getContent()));
        }        
        $this->assertTrue($this->findFieldValueInResponseContent('order_number', $order->order_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('name', ucwords(strtolower($order->name)), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('first_name', ucwords(strtolower(trim(substr($order->name,0,strpos($order->name,' '))))), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('last_name', ucwords(strtolower(trim(substr($order->name,strrpos($order->name,' '))))), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('nick_name', null, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('middle_name', null, 'text', $response->getContent()));
        
        $this->assertTrue($this->findFieldValueInResponseContent('email', trim($order->email), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_street', $order->address_street, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_supplemental', $order->address_supplemental, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_city', $order->address_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_zip', $order->address_zip, 'text', $response->getContent()));
 
        $this->assertTrue($this->findFieldValueInResponseContent('mobile_phone', $order->mobile_phone, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('home_phone', $order->home_phone, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('work_phone', $order->work_phone, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact', $order->emergency_contact, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact_relationship', $order->emergency_contact_relationship, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact_phone', $order->emergency_contact_phone, 'text', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('dietary', $order->dietary, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('health', null, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('comments', $order->comments, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('additional_names_and_phone_numbers', $order->additional_names_and_phone_numbers, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('gift_certificate_number', $order->gift_certificate_number, 'text', $response->getContent()));
 
        /* TODO: not sure if I had been checking hidden form types
        * TODO: tesing of fields with complex logic will be implemented later, manually set values when creating test
            {!! Form::hidden('id', $order->id) !!} 
            {!! Form::hidden('parish', ucwords(strtolower($order->parish))) !!}
            {!! Form::select('preferred_language_id', $languages, $ids['preferred_language'], ['class' => 'form-control']) !!}
            {!! Form::select('parish_id', $parish_list, (null !== optional($order->retreatant)->parish_id) ? optional($order->retreatant)->parish_id : null, ['class' => 'form-control']) !!}
            {!! Form::select('gift_certificate_retreat', $retreats, null, ['class' => 'form-control']) !!}
            {!! Form::select('couple_contact_id', $couple_matching_contacts, , ['class' => 'form-control']) !!}
            {!! Form::select('title_id', $prefixes, $ids['title'], ['class' => 'form-control']) !!}
            {!! Form::select('couple_title_id', $prefixes, $ids['couple_title'], ['class' => 'form-control']) !!}
            {!! Form::select('address_state_id', $states, $ids['address_state'], ['class' => 'form-control']) !!}
            {!! Form::select('address_country_id', $countries, $ids['address_country'], ['class' => 'form-control']) !!}
            {!! Form::text('date_of_birth', $order->date_of_birth, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
            {!! Form::text('couple_date_of birth', $order->couple_date_of_birth, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
            {!! Form::text('room_preference', ($order->room_preference == 'Ninguna' || $order->room_preference == 'None') ? null : $order->room_preference, ['class' => 'form-control']) !!}
        */
        
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-order');

        $response = $this->actingAs($user)->get(route('squarespace.order.index'));

        $response->assertOk();
        $response->assertViewIs('squarespace.order.index');
        $response->assertViewHas('processed_orders');
        $response->assertViewHas('unprocessed_orders');
        $response->assertSeeText('Squarespace Orders');
    }


    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-squarespace-order');
        $order = \App\Models\SquarespaceOrder::factory()->create();

        $response = $this->actingAs($user)->get(route('squarespace.order.show', [$order]));

        $response->assertOk();
        $response->assertViewIs('squarespace.order.show');
        $response->assertViewHas('order');
        $response->assertSeeText('Squarespace Order #'.$order->order_number);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   
        // emtpy slug redirects to squarespace.order.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('show-squarespace-order');

        $response = $this->actingAs($user)->post(route('squarespace.order.store'), [
            'order_number' => $this->faker->numberBetween(100,999),
        ]);

        $response->assertOk();
        $response->assertViewIs('squarespace.order.index');        
    }


    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        // not a slug
        $user = $this->createUserWithPermission('update-squarespace-order');
        $retreatant = \App\Models\Contact::factory()->create();
        $couple = \App\Models\Contact::factory()->create();
        $retreat = \App\Models\Retreat::factory()->create();
        $order = \App\Models\SquarespaceOrder::factory()->create([
            'contact_id' => $retreatant->id, 
            'event_id' => $retreat->id, 
            'couple_contact_id' => $couple->id,
            'deposit_amount' => $this->faker->numberBetween(50,400)]);
        $new_dietary = 'Bread and water fasting';
        $old_dietary = $order->dietary;

        $response = $this->actingAs($user)->put(route('squarespace.order.update', [$order]), [
            'id' => $order->id,
            'contact_id' => $retreatant->id,
            'event_id' => $retreat->id,
            'dietary' => $new_dietary,
        ]);
        $updated = \App\Models\SquarespaceOrder::findOrFail($order->id);
        
        //$response->assertSessionHas('flash_notification');
        // TODO: currently assuming couple order so not testing if it properly returns to squarespace.order.edit
        if (!isset($order->participant_id) && (!isset($order->contact_id) || ($order->is_couple && !isset($order->couple_contact_id) ))) {
            $response->assertRedirect(action([\App\Http\Controllers\SquarespaceOrderController::class, 'edit'],$order->id)); 
        } else {
            $response->assertRedirect(action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']));
        }

        $this->assertEquals($updated->dietary, $new_dietary);
        $this->assertNotEquals($updated->dietary, $old_dietary);
    }

    /**
    * @test
    */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SquarespaceOrderController::class,
            'update',
            \App\Http\Requests\UpdateSquarespaceOrderRequest::class
        );
    }


}
