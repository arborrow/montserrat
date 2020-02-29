<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\GroupContact;

/**
 * @see \App\Http\Controllers\RegistrationController
 */
class RegistrationControllerTest extends TestCase
{
    use withFaker;

    /**
     * @test
     */
    public function add_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');
        $contact = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->get('registration/add/' . $contact->id);

        $response->assertOk();
        $response->assertViewIs('registrations.create');
        $response->assertViewHas('retreats');
        $response->assertViewHas('retreatants');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Add A Registration');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function add_group_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');

        $group = factory(\App\Group::class)->create();

        $response = $this->actingAs($user)->get('group/' . $group->id . '/registration');

        $response->assertOk();
        $response->assertViewIs('registrations.add_group');
        $response->assertViewHas('retreats');
        $response->assertViewHas('groups');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText(e($group->title));

    }

    /**
     * @test
     */
    public function arrive_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
          'arrived_at' => null,
          'canceled_at' => null,
          'departed_at' => null,
          'registration_confirm_date' => null,
          'attendance_confirm_date' => null,
        ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.arrive', ['id' => $registration->id]));
        $updated = \App\Registration::findOrFail($registration->id);
        // test that the arrived date has been updated from NULL to now
        $this->assertNotEquals($registration->arrived_at, $updated->arrived_at);
        // test that we are being redirected back to the retreat show blade
        $response->assertRedirect(URL('retreat/'.$registration->event_id));

    }

    /**
     * @test
     */
    public function attend_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
            'attendance_confirm_date' => null,
          ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.attend', ['id' => $registration->id]));

        $updated = \App\Registration::findOrFail($registration->id);

        // test that the attend date has been updated from NULL to now
        $this->assertNotEquals($registration->attendance_confirm_date, $updated->attendance_confirm_date);
        // test that we are being redirected back to the retreat show blade
        $response->assertRedirect(URL('retreat/'.$registration->event_id));

    }

    /**
     * @test
     */
    public function cancel_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
            'canceled_at' => null,
          ]);

        $response = $this->actingAs($user)->get(route('registration.cancel', ['id' => $registration->id]));
        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.cancel', ['id' => $registration->id]));

        $updated = \App\Registration::findOrFail($registration->id);

        // test that the attend date has been updated from NULL to now
        $this->assertNotEquals($registration->canceled_at, $updated->canceled_at);
        // test that we are being redirected back to the retreat show blade
        $response->assertRedirect(URL('retreat/'.$registration->event_id));

    }

    /**
     * @test
     */
    public function confirm_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
            'registration_confirm_date' => null,
          ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.confirm', ['id' => $registration->id]));

        $updated = \App\Registration::findOrFail($registration->id);

        // test that the attend date has been updated from NULL to now
        $this->assertNotEquals($registration->registration_confirm_date, $updated->registration_confirm_date);
        // test that we are being redirected back to the retreat show blade
        $response->assertRedirect(URL('retreat/'.$registration->event_id));

    }

    /**
     * @test
     */
    public function confirm_attendance_returns_an_ok_response()
    {
          $registration = factory(\App\Registration::class)->create([
              'departed_at' => null,
              'registration_confirm_date' => null,
              'arrived_at' => null,
              'canceled_at' => null,
              'attendance_confirm_date' => null,
          ]);

          $path = 'registration/confirm/'.$registration->remember_token;
          $response = $this->get($path);
          $registration->refresh();

          $response->assertRedirect('https://montserratretreat.org/retreat-attendance');
          $this->assertEquals($registration->remember_token,null);
          $this->assertNotEquals($registration->registration_confirm_date,null);
      }



    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');

        $response = $this->actingAs($user)->get(route('registration.create'));

        $response->assertOk();
        $response->assertViewIs('registrations.create');
        $response->assertViewHas('retreats');
        $response->assertViewHas('retreatants');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Add A Registration');

    }

    /**
     * @test
     */
    public function depart_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
            'departed_at' => null,
          ]);
        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.depart', ['id' => $registration->id]));

        $updated = \App\Registration::findOrFail($registration->id);
        // test that the attend date has been updated from NULL to now
        $this->assertNotEquals($registration->departed_at, $updated->departed_at);
        // test that we are being redirected back to the retreat show blade
        $response->assertRedirect(URL('retreat/'.$registration->event_id));


    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-registration');
        $registration = factory(\App\Registration::class)->create();

        $response = $this->actingAs($user)->delete(route('registration.destroy', [$registration]));

        $response->assertRedirect(action('RegistrationController@index'));
        $this->assertSoftDeleted($registration);

    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create();

        $response = $this->actingAs($user)->get(route('registration.edit', [$registration]));

        $response->assertOk();
        $response->assertViewIs('registrations.edit');
        $response->assertViewHas('registration');
        $response->assertViewHas('retreats');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Edit Registration');
        $response->assertSeeText(e($registration->notes));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $registration = factory(\App\Registration::class)->create();

        $response = $this->actingAs($user)->get(route('registration.index'));

        $response->assertOk();
        $response->assertViewIs('registrations.index');
        $response->assertViewHas('registrations');
        $registrations = $response->viewData('registrations');
        $this->assertGreaterThanOrEqual('1',$registrations->count());

    }

    /**
     * @test
     */
    public function offwaitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
            'status_id' => config('polanco.registration_status_id.waitlist'),
        ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))->
            get(route('registration.offwaitlist', ['id' => $registration->id]));
        $updated = \App\Registration::findOrFail($registration->id);
        $response->assertRedirect(URL('retreat/'.$registration->event_id));
        $this->assertEquals(config('polanco.registration_status_id.registered'),$updated->status_id);

    }

    /**
     * @test
     */
    public function register_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');
        $retreat = factory(\App\Retreat::class)->create();
        $contact = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->get(route('registration.register', [
            'retreat_id' => $retreat->id,
            'contact_id' => $contact->id,
        ]));

        $response->assertOk();
        $response->assertViewIs('registrations.create');
        $response->assertViewHas('retreats');
        $response->assertViewHas('retreatants');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText(e($retreat->title));
        $response->assertSeeText(e($contact->sort_name));
    }

    /**
     * @test
     */
    public function registration_email_returns_an_ok_response()
    {
        $registration = factory(\App\Registration::class)->create([
            'canceled_at' => null,
            'arrived_at' => null,
            'departed_at' => null,
            'status_id' => config('polanco.registration_status_id.registered'),
            'notes' => 'Registration email test',
        ]);
        $email = factory(\App\Email::class)->create([
            'contact_id' => $registration->contact_id,
            'is_primary' => '1',
        ]);
        $event = \App\Retreat::findOrFail($registration->event_id);

        $user = $this->createUserWithPermission('show-registration');

        $response = $this->actingAs($user)->get('registration/'.$registration->id.'/email');

        $response->assertRedirect('person/'.$registration->contact_id);
        $this->assertDatabaseHas('touchpoints', [
          'person_id' => $registration->contact_id,
          'staff_id' => config('polanco.self.id'),
          'type' => 'Email',
          'notes' => $event->idnumber . ' registration email sent.',
        ]);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $registration = factory(\App\Registration::class)->create();

        $response = $this->actingAs($user)->get(route('registration.show', [$registration]));

        $response->assertOk();
        $response->assertViewIs('registrations.show');
        $response->assertViewHas('registration');
        $response->assertSeeText(e($registration->contact->full_name));
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');
        $retreat = factory(\App\Retreat::class)->create();
        $contact = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);
        $response = $this->actingAs($user)->post(route('registration.store'), [
            'register_date' => $this->faker->dateTime('now'),
            'event_id' => $retreat->id,
            'status_id' => config('polanco.registration_status_id.registered'),
            'contact_id' => $contact->id,
            'deposit' => $this->faker->randomFloat(2,0,1000),
            'attendance_confirm_date' => null,
            'registration_confirm_date' => null,
            'canceled_at' => null,
            'arrived_at' => null,
            'departed_at' => null,
            'num_registrants' => '1',
        ]);
        $response->assertRedirect(action('RegistrationController@index'));
        $this->assertDatabaseHas('participant', [
          'event_id' => $retreat->id,
          'contact_id' => $contact->id,
          'status_id' => config('polanco.registration_status_id.registered'),
        ]);

    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegistrationController::class,
            'store',
            \App\Http\Requests\StoreRegistrationRequest::class
        );
    }

    /**
     * @test
     */
    public function store_group_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');
        $retreat = factory(\App\Retreat::class)->create();
        $group = factory(\App\Group::class)->create();
        $group_contacts = factory(\App\GroupContact::class, $this->faker->numberBetween(2,10))->create([
            'group_id' => $group->id,
        ]);
        $response = $this->actingAs($user)->post('registration/add_group', [
            'event_id' => $retreat->id,
            'group_id' => $group->id,
            'status_id' => config('polanco.registration_status_id.registered'),
            'register_date' => $this->faker->dateTime('now'),
            'deposit' => $this->faker->randomFloat(2,0,100),
        ]);

        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $registrations = \App\Registration::whereEventId($retreat->id)->get();
        $group_contacts = \App\GroupContact::whereGroupId($group->id)->get();
        // assert that every group contact now has a registration for the event
        $this->assertEquals($registrations->count(),$group_contacts->count());
    }

    /**
     * @test
     */
    public function store_group_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegistrationController::class,
            'store_group',
            \App\Http\Requests\StoreGroupRegistrationRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create();
        $new_deposit = $this->faker->numberBetween(0,1000);
        $original_deposit = $registration->deposit;
        $response = $this->actingAs($user)->put(route('registration.update', [$registration]), [
            'id' => $registration->id,
            'register_date' => $this->faker->dateTime('now'),
            'attendance_confirm_date' => $this->faker->dateTime('now'),
            'registration_confirm_date' => $this->faker->dateTime('now'),
            'canceled_at' => null,
            'arrived_at' => null,
            'departed_at' => null,
            'event_id' => $registration->event_id,
            'status_id' => config('polanco.registration_status_id.registered'),
            'room_id' => 0,
            'deposit' => $new_deposit,
            'contact_id' => $registration->contact_id,

        ]);
        $registration->refresh();
        $response->assertRedirect(action('PersonController@show', $registration->contact_id));
        $this->assertEquals($registration->deposit, $new_deposit);
        $this->assertNotEquals($registration->deposit, $original_deposit);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegistrationController::class,
            'update',
            \App\Http\Requests\UpdateRegistrationRequest::class
        );
    }

    /**
     * @test
     */
    public function waitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = factory(\App\Registration::class)->create([
            'status_id' => config('polanco.registration_status_id.registered'),
        ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))->
            get(route('registration.waitlist', ['id' => $registration->id]));

        $updated = \App\Registration::findOrFail($registration->id);

        $response->assertRedirect(URL('retreat/'.$registration->event_id));
        $this->assertEquals(config('polanco.registration_status_id.waitlist'),$updated->status_id);

    }

    // test cases...
}
