<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\GroupContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->get('registration/add/'.$contact->id);

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
    public function add_group_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');

        $group = \App\Models\Group::factory()->create();

        $response = $this->actingAs($user)->get('group/'.$group->id.'/registration');

        $response->assertOk();
        $response->assertViewIs('registrations.add_group');
        $response->assertViewHas('retreats');
        $response->assertViewHas('groups');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText($group->title);
    }

    /**
     * @test
     */
    public function arrive_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = \App\Models\Registration::factory()->create([
          'arrived_at' => null,
          'canceled_at' => null,
          'departed_at' => null,
          'registration_confirm_date' => null,
          'attendance_confirm_date' => null,
        ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.arrive', ['id' => $registration->id]));
        $updated = \App\Models\Registration::findOrFail($registration->id);
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
        $registration = \App\Models\Registration::factory()->create([
            'attendance_confirm_date' => null,
          ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.attend', ['id' => $registration->id]));

        $updated = \App\Models\Registration::findOrFail($registration->id);

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
        $registration = \App\Models\Registration::factory()->create([
            'canceled_at' => null,
          ]);

        $response = $this->actingAs($user)->get(route('registration.cancel', ['id' => $registration->id]));
        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.cancel', ['id' => $registration->id]));

        $updated = \App\Models\Registration::findOrFail($registration->id);

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
        $registration = \App\Models\Registration::factory()->create([
            'registration_confirm_date' => null,
          ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.confirm', ['id' => $registration->id]));

        $updated = \App\Models\Registration::findOrFail($registration->id);

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
        $registration = \App\Models\Registration::factory()->create([
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
        $this->assertEquals($registration->remember_token, null);
        $this->assertNotEquals($registration->registration_confirm_date, null);
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
        $registration = \App\Models\Registration::factory()->create([
            'departed_at' => null,
          ]);
        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))
            ->get(route('registration.depart', ['id' => $registration->id]));

        $updated = \App\Models\Registration::findOrFail($registration->id);
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
        $registration = \App\Models\Registration::factory()->create();

        $response = $this->actingAs($user)->delete(route('registration.destroy', [$registration]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RegistrationController@index'));
        $this->assertSoftDeleted($registration);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = \App\Models\Registration::factory()->create();

        $response = $this->actingAs($user)->get(route('registration.edit', [$registration]));

        $response->assertOk();
        $response->assertViewIs('registrations.edit');
        $response->assertViewHas('registration');
        $response->assertViewHas('retreats');
        $response->assertViewHas('rooms');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Edit Registration');
        $response->assertSeeText($registration->notes);

        $this->assertTrue($this->findFieldValueInResponseContent('event_id', $registration->event_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('register_date', $registration->register_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('source', $registration->source, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('status_id', $registration->status_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('registration_confirm_date', $registration->registration_confirm_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('confirmed_by', $registration->confirmed_by, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('arrived_at', $registration->arrived_at, 'datetime', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('departed_at', $registration->departed_at, 'datetime', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('canceled_at', $registration->canceled_at, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('room_id', $registration->room_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('deposit', number_format($registration->deposit, 2, '.', ''), 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('notes', $registration->notes, 'textarea', $response->getContent()));
    }

    /*
    {!! Form::select('event_id', $retreats, $registration->event_id, ['class' => 'form-control']) !!}
{!! Form::date('register_date', isset($registration->register_date) ? $registration->register_date : now() , ['class'=>'form-control flatpickr-date']) !!}
{!! Form::select('source', $defaults['registration_source'], $registration->source, ['class' => 'form-control']) !!}
{!! Form::select('status_id', $defaults['participant_status_type'], $registration->status_id, ['class' => 'form-control']) !!}
    {!! Form::date('registration_confirm_date', $registration->registration_confirm_date, ['class'=>'form-control flatpickr-date']) !!}
{!! Form::text('confirmed_by', $registration->confirmed_by, ['class'=>'form-control']) !!}
{!! Form::date('arrived_at', $registration->arrived_at, ['class'=>'form-control flatpickr-date-time']) !!}
{!! Form::date('departed_at', $registration->departed_at, ['class'=>'form-control flatpickr-date-time']) !!}
{!! Form::date('canceled_at', $registration->canceled_at, ['class'=>'form-control flatpickr-date']) !!}
{!! Form::select('room_id', $rooms, $registration->room_id, ['class' => 'form-control']) !!}
{!! Form::text('deposit', $registration->deposit, ['class'=>'form-control']) !!}
{!! Form::textarea('notes', $registration->notes, ['class'=>'form-control', 'rows'=>'3']) !!}

     */

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $registration = \App\Models\Registration::factory()->create();

        $response = $this->actingAs($user)->get(route('registration.index'));

        $response->assertOk();
        $response->assertViewIs('registrations.index');
        $response->assertViewHas('registrations');
        $registrations = $response->viewData('registrations');
        $this->assertGreaterThanOrEqual('1', $registrations->count());
    }

    /**
     * @test
     */
    public function offwaitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $registration = \App\Models\Registration::factory()->create([
            'status_id' => config('polanco.registration_status_id.waitlist'),
        ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))->
            get(route('registration.offwaitlist', ['id' => $registration->id]));
        $updated = \App\Models\Registration::findOrFail($registration->id);
        $response->assertRedirect(URL('retreat/'.$registration->event_id));
        $this->assertEquals(config('polanco.registration_status_id.registered'), $updated->status_id);
    }

    /**
     * @test
     */
    public function register_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');
        $retreat = \App\Models\Retreat::factory()->create();
        $contact = \App\Models\Contact::factory()->create([
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
        $response->assertSeeText($retreat->title);
        $response->assertSeeText($contact->sort_name);
    }

    /**
     * @test
     */
    public function registration_email_returns_an_ok_response()
    {
        $registration = \App\Models\Registration::factory()->create([
            'canceled_at' => null,
            'arrived_at' => null,
            'departed_at' => null,
            'status_id' => config('polanco.registration_status_id.registered'),
            'notes' => 'Registration email test',
        ]);
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $registration->contact_id,
            'is_primary' => '1',
        ]);
        $event = \App\Models\Retreat::findOrFail($registration->event_id);

        $user = $this->createUserWithPermission('show-registration');

        $response = $this->actingAs($user)->get('registration/'.$registration->id.'/email');

        $response->assertRedirect('person/'.$registration->contact_id);
        $this->assertDatabaseHas('touchpoints', [
          'person_id' => $registration->contact_id,
          'staff_id' => config('polanco.self.id'),
          'type' => 'Email',
          'notes' => $event->idnumber.' registration email sent.',
        ]);
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $registration = \App\Models\Registration::factory()->create();

        $response = $this->actingAs($user)->get(route('registration.show', [$registration]));

        $response->assertOk();
        $response->assertViewIs('registrations.show');
        $response->assertViewHas('registration');
        $response->assertSeeText($registration->contact->full_name);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-registration');
        $retreat = \App\Models\Retreat::factory()->create();
        $contact = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);
        $response = $this->actingAs($user)->post(route('registration.store'), [
            'register_date' => $this->faker->dateTime('now'),
            'event_id' => $retreat->id,
            'status_id' => config('polanco.registration_status_id.registered'),
            'contact_id' => $contact->id,
            'deposit' => $this->faker->randomFloat(2, 0, 1000),
            'attendance_confirm_date' => null,
            'registration_confirm_date' => null,
            'canceled_at' => null,
            'arrived_at' => null,
            'departed_at' => null,
            'num_registrants' => '1',
        ]);
        $response->assertRedirect(action('RegistrationController@index'));
        $response->assertSessionHas('flash_notification');
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
        $retreat = \App\Models\Retreat::factory()->create();
        $group = \App\Models\Group::factory()->create();
        $group_contacts = \App\Models\GroupContact::factory()->count($this->faker->numberBetween(2, 10))->create([
            'group_id' => $group->id,
        ]);
        $response = $this->actingAs($user)->post('registration/add_group', [
            'event_id' => $retreat->id,
            'group_id' => $group->id,
            'status_id' => config('polanco.registration_status_id.registered'),
            'register_date' => $this->faker->dateTime('now'),
            'deposit' => $this->faker->randomFloat(2, 0, 100),
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $registrations = \App\Models\Registration::whereEventId($retreat->id)->get();
        $group_contacts = \App\Models\GroupContact::whereGroupId($group->id)->get();
        // assert that every group contact now has a registration for the event
        $this->assertEquals($registrations->count(), $group_contacts->count());
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
        $registration = \App\Models\Registration::factory()->create();
        $new_deposit = $this->faker->numberBetween(0, 1000);
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
        $response->assertSessionHas('flash_notification');
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
        $registration = \App\Models\Registration::factory()->create([
            'status_id' => config('polanco.registration_status_id.registered'),
        ]);

        $response = $this->actingAs($user)->from(URL('retreat/'.$registration->event_id))->
            get(route('registration.waitlist', ['id' => $registration->id]));

        $updated = \App\Models\Registration::findOrFail($registration->id);

        $response->assertRedirect(URL('retreat/'.$registration->event_id));
        $this->assertEquals(config('polanco.registration_status_id.waitlist'), $updated->status_id);
    }

    // test cases...
}
