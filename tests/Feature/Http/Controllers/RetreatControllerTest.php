<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RetreatController
 */
class RetreatControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function assign_rooms_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        // create a retreat, then create a number of registrations for the retreat
        $retreat = \App\Models\Retreat::factory()->create();
        $number_registrations = $this->faker->numberBetween(2, 10);
        $registration = \App\Models\Registration::factory()->count($number_registrations)->create([
          'event_id' => $retreat->id,
          'canceled_at' => null,
          'arrived_at' => null,
          'departed_at' => null,
          'room_id' => null,
        ]);

        // create a single room for the test just in case none have been created
        $room = \App\Models\Room::factory()->create();

        $response = $this->actingAs($user)->get(route('retreat.assign_rooms', ['id' => $retreat->id]));
        // TODO: $response->assertSessionHas('flash_notification');
        $response->assertOk();
        $response->assertViewIs('retreats.assign_rooms');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertViewHas('rooms');
        $response->assertSeeText('Save Room Assignments');
    }

    /**
     * @test
     */
    public function calendar_returns_an_ok_response()
    {   //TODO: atm this is a pretty weak test assuming Google calendar is not implemented, could be stronger if we simulate creating such events
        $user = $this->createUserWithPermission('show-retreat');

        $response = $this->actingAs($user)->get(route('calendar'));

        $response->assertOk();
        $response->assertViewIs('calendar.index');
        $response->assertViewHas('calendar_events');
        $response->assertSeeText('Index of Google Master Calendar Events');
    }

    /**
     * @test
     */
    public function checkin_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');

        // create a retreat, then create a number of registrations for the retreat
        $retreat = \App\Models\Retreat::factory()->create();
        $number_registrations = $this->faker->numberBetween(2, 10);
        $registrations = \App\Models\Registration::factory()->count($number_registrations)->create([
          'event_id' => $retreat->id,
          'canceled_at' => null,
          'arrived_at' => null,
          'departed_at' => null,
          'room_id' => null,
        ]);

        $response = $this->from('retreat.show', $retreat->id)->actingAs($user)->get(route('retreat.checkin', ['id' => $retreat->id]));
        $registration = $registrations->random();
        $registration->refresh();
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $this->assertNotEquals(null, $registration->arrived_at);
    }

    /**
     * @test
     */
    public function checkout_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');

        // create a retreat, then create a number of registrations for the retreat
        $retreat = \App\Models\Retreat::factory()->create(
            [
            'start_date' => $this->faker->dateTimeBetween('-5 days', '-2 days'),
            'end_date' => $this->faker->dateTimeBetween('-1 day', '1 day'),
          ]
        );
        $number_registrations = $this->faker->numberBetween(2, 10);
        $registrations = \App\Models\Registration::factory()->count($number_registrations)->create([
          'event_id' => $retreat->id,
          'canceled_at' => null,
          'arrived_at' => $this->faker->dateTime('now'),
          'departed_at' => null,
          'room_id' => null,
        ]);

        $response = $this->actingAs($user)->get(route('retreat.checkout', ['id' => $retreat->id]));

        $registration = $registrations->random();
        $registration->refresh();

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $this->assertNotEquals(null, $registration->departed_at);
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-retreat');

        $response = $this->actingAs($user)->get(route('retreat.create'));
        $response->assertOk();
        $response->assertViewIs('retreats.create');
        $response->assertViewHas('d');
        $response->assertViewHas('i');
        $response->assertViewHas('a');
        $response->assertViewHas('c');
        $response->assertViewHas('event_types');
        $response->assertSeeText('Create Retreat');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-retreat');
        $retreat = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->delete(route('retreat.destroy', [$retreat]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@index'));
        $this->assertSoftDeleted($retreat);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-retreat');
        $retreat = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get(route('retreat.edit', [$retreat]));

        $response->assertOk();
        $response->assertViewIs('retreats.edit');
        $response->assertViewHas('retreat');
        $response->assertViewHas('options');
        $response->assertViewHas('event_types');
        $response->assertViewHas('is_active');
        $response->assertSeeText('Edit');
        $response->assertSeeText($retreat->idnumber);

        $this->assertTrue($this->findFieldValueInResponseContent('idnumber', $retreat->idnumber, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('start_date', $retreat->start_date, 'datetime', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('end_date', $retreat->end_date, 'datetime', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('title', $retreat->title, 'text', $response->getContent()));

        // TODO: come back and figure out how to deal with null lists; add some directors, assistants, innkeepers, and ambassadors
        // $this->assertTrue($this->findFieldValueInResponseContent('directors[]', $retreat->retreatmasters->pluck('contact.id'), 'select', $response->getContent()));
        // $this->assertTrue($this->findFieldValueInResponseContent('innkeepers[]', $retreat->innkeepers->pluck('contact.id'), 'select', $response->getContent()));
        // $this->assertTrue($this->findFieldValueInResponseContent('assistants[]', $retreat->assistants->pluck('contact.id'), 'select', $response->getContent()));
        // $this->assertTrue($this->findFieldValueInResponseContent('ambassadors[]', $retreat->ambassadors->pluck('contact.id'), 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('description', $retreat->description, 'textarea', $response->getContent()));
    }

    /*
    {!! Form::text('idnumber', $retreat->idnumber, ['class' => 'form-control']) !!}
{!! Form::text('start_date', date('F j, Y g:i A', strtotime($retreat->start_date)), ['id' => 'start_date', 'class' => 'form-control form-control flatpickr-datetime']) !!}
{!! Form::text('end_date', date('F j, Y g:i A', strtotime($retreat->end_date)), ['id' => 'end_date', 'class' => 'form-control form-control flatpickr-datetime']) !!}
{!! Form::text('title', $retreat->title, ['class' => 'form-control']) !!}
{!! Form::select('directors[]', $options['directors'], $retreat->retreatmasters->pluck('contact.id'), ['id'=>'directors','class' => 'form-control select2','multiple' => 'multiple']) !!}
{!! Form::select('ambassadors[]', $options['ambassadors'], $retreat->ambassadors->pluck('contact.id'), ['id'=>'ambassadors','class' => 'form-control select2','multiple' => 'multiple']) !!}
{!! Form::select('innkeepers[]', $options['innkeepers'], $retreat->innkeepers->pluck('contact.id'), ['id'=>'innkeepers','class' => 'form-control select2','multiple' => 'multiple']) !!}
{!! Form::select('assistants[]', $options['assistants'], $retreat->assistants->pluck('contact.id'), ['id'=>'assistants','class' => 'form-control select2','multiple' => 'multiple']) !!}
    {!! Form::select('event_type', $event_types, $retreat->event_type_id, ['class' => 'form-control']) !!}
{!! Form::select('is_active', $is_active, $retreat->is_active, ['class' => 'form-control']) !!}
{!! Form::textarea('description', $retreat->description, ['class' => 'form-control', 'rows'=>'3']) !!}

     */

    /**
     * @test
     */
    public function edit_payments_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-payment');
        $retreat = \App\Models\Retreat::factory()->create();
        $registration = \App\Models\Registration::factory()->create([
          'canceled_at' => null,
          'event_id' => $retreat->id,
        ]);

        $response = $this->actingAs($user)->get(route('retreat.payments.edit', ['id' => $retreat->id]));

        $response->assertOk();
        $response->assertViewIs('retreats.payments.edit');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertViewHas('donation_description');
        $response->assertViewHas('payment_description');
        $response->assertSeeText('Retreat Offerings for '.e($retreat->title));
    }

    /**
     * @test
     */
    public function get_event_by_id_number_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        $retreat = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get('retreat/id/'.$retreat->idnumber);

        $response->assertOk();
        $response->assertViewIs('retreats.show');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertViewHas('status');
        $response->assertSeeText($retreat->title);
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        $retreat = \App\Models\Retreat::factory()->create();
        $response = $this->actingAs($user)->get(route('retreat.index'));
        $response->assertOk();
        $response->assertViewIs('retreats.index');
        $response->assertViewHas('retreats');
        $response->assertViewHas('oldretreats');
        $response->assertViewHas('defaults');
        $response->assertViewHas('event_types');
        $response->assertSeeText('Upcoming Retreat');
        $response->assertSeeText('Previous Retreat');
    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        // create a new event type, add a random number of retreats (2-10) to that event type ensuring they are all future events
        $event_type = \App\Models\EventType::factory()->create();
        $number_retreats = $this->faker->numberBetween(2, 10);
        $retreat = \App\Models\Retreat::factory()->count($number_retreats)->create([
            'event_type_id' => $event_type->id,
            'start_date' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'end_date' => $this->faker->dateTimeBetween('+11 days', '+15 days'),

        ]);

        $response = $this->actingAs($user)->get('retreat/type/'.$event_type->id);
        $response->assertOk();
        $response->assertViewIs('retreats.index');
        $response->assertViewHas('retreats');
        $response->assertViewHas('oldretreats');
        $response->assertViewHas('defaults');
        $response->assertViewHas('event_types');
        $response->assertSeeText('Upcoming '.e($event_type->type));
        $response->assertSeeText('Previous '.e($event_type->type));
        // TODO: not particularly well written test as it may be influenced by other tests so there may be cases where there are more upcoming events than created by this test
    }

    /**
     * @test
     */
    public function room_update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $retreat = \App\Models\Retreat::factory()->create();
        $registration = \App\Models\Registration::factory()->create([
          'room_id' => null,
          'event_id' => $retreat->id,
          'notes' => null,
          'source' => 'room_update',
          'canceled_at' => null,
        ]);
        $room = \App\Models\Room::factory()->create();
        $registrations = [];
        $notes = [];
        $registrations[$registration->id] = $room->id;
        $notes[$registration->id] = $this->faker->sentence;

        $response = $this->actingAs($user)->post(route('retreat.room_update'), [
            'registrations' => $registrations,
            'notes' => $notes,
        ]);

        $updated_registration = \App\Models\Registration::findOrFail($registration->id);
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $this->assertNotEquals(null, $updated_registration->room_id);
        $this->assertEquals($room->id, $updated_registration->room_id);
        $this->assertNotEquals(null, $updated_registration->notes);
    }

    /**
     * @test
     */
    public function room_update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RetreatController::class,
            'room_update',
            \App\Http\Requests\RoomUpdateRetreatRequest::class
        );
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        $retreat = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get(route('retreat.show', [$retreat]));

        $response->assertOk();
        $response->assertViewIs('retreats.show');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertViewHas('status');
        $response->assertSeeText($retreat->title);
    }


        /**
         * @test
         */
        public function show_with_status_returns_an_ok_response()
        {
            $user = $this->createUserWithPermission('show-retreat');
            $retreat = \App\Models\Retreat::factory()->create();
            $status = $this->faker->randomElement(config('polanco.registration_filters'));
            $response = $this->actingAs($user)->get(route('retreat.status', ['id' => $retreat->id, 'status' => $status]));

            $response->assertOk();
            $response->assertViewIs('retreats.show');
            $response->assertViewHas('retreat');
            $response->assertViewHas('registrations');
            $response->assertViewHas('status');
            $response->assertSeeText($retreat->title);
        }

    /**
     * @test
     */
    public function show_payments_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');

        $registration = \App\Models\Registration::factory()->create();
        $retreat = \App\Models\Retreat::findOrFail($registration->event_id);

        $response = $this->actingAs($user)->get(route('retreat.payments', ['id' => $registration->event_id]));

        $response->assertOk();
        $response->assertViewIs('retreats.payments.show');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertSeeText($retreat->idnumber);
    }

    /**
     * @test
     */
    public function show_waitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        $registration = \App\Models\Registration::factory()->create([
            'status_id' => config('polanco.registration_status_id.waitlist'),
        ]);
        $retreat = \App\Models\Retreat::findOrFail($registration->event_id);
        $response = $this->actingAs($user)->get('retreat/'.$registration->event_id.'/waitlist');

        $response->assertOk();
        $response->assertViewIs('retreats.waitlist');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertSeeText('Waitlist for');
        $response->assertSeeText($retreat->idnumber);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-retreat');
        $idnumber = $this->faker->numberBetween(11111111, 99999999).$this->faker->lastName;
        $response = $this->actingAs($user)->post(route('retreat.store'), [
            'idnumber' => $idnumber,
            'start_date' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'end_date' => $this->faker->dateTimeBetween('+11 days', '+15 days'),
            'title' => $this->faker->catchPhrase,
            'silent' => $this->faker->boolean(90),
            'is_active' => '1',
            'description' => $this->faker->paragraph,
            'event_type_id' => $this->faker->numberBetween(1, 14),
            'innkeeper_id' => 0,
            'assistant_id' => 0,
        ]);
        // TODO: assumes that Google calendar integration is not set but eventually we will want to test that this too is working and saving the calendar event
        $retreat = \App\Models\Retreat::whereIdnumber($idnumber)->first();
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@index'));
        $this->assertEquals($retreat->idnumber, $idnumber);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RetreatController::class,
            'store',
            \App\Http\Requests\StoreRetreatRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-retreat');
        $retreat = \App\Models\Retreat::factory()->create();
        $original_idnumber = $retreat->idnumber;
        $original_title = $retreat->title;
        $new_idnumber = $this->faker->numberBetween(11111111, 99999999).$this->faker->lastName;
        $new_title = $this->faker->catchPhrase;
        $response = $this->actingAs($user)->put(route('retreat.update', [$retreat]), [
            'id' => $retreat->id,
            'idnumber' => $new_idnumber,
            'start_date' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'end_date' => $this->faker->dateTimeBetween('+11 days', '+15 days'),
            'title' => $new_title,
            'innkeeper_id' => '0',
            'assistant_id' => '0',
            'silent' => $this->faker->boolean(90),
            'is_active' => '1',
            'description' => $this->faker->paragraph,
            'event_type_id' => $this->faker->numberBetween(1, 14),
        ]);
        $retreat->refresh();
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $this->assertEquals($retreat->title, $new_title);
        $this->assertEquals($retreat->idnumber, $new_idnumber);
        $this->assertNotEquals($retreat->title, $original_title);
        $this->assertNotEquals($retreat->idnumber, $original_idnumber);

        // TODO: write tests for uploading of files (schedule, evaluations, contracts, group pictures, etc.)
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RetreatController::class,
            'update',
            \App\Http\Requests\UpdateRetreatRequest::class
        );
    }

    /**
     * @test
     */
    public function event_room_list_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $retreat = \App\Models\Retreat::factory()->create();
        $retreatant = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
        ]);
        $room = \App\Models\Room::factory()->create();
        $registration = \App\Models\Registration::factory()->create([
            'event_id' => $retreat->id,
            'contact_id' => $retreatant->id,
            'room_id' => $room->id,
            'canceled_at' => null,
        ]);
        $response = $this->actingAs($user)->get('retreat/'.$registration->event_id.'/roomlist');
        $response->assertOk();
        $response->assertViewIs('retreats.roomlist');
        $response->assertViewHas('event');
        $response->assertViewHas('results');
        $response->assertSeeText($room->name);
        $response->assertSeeText($retreatant->sort_name);
        $response->assertSeeText($retreat->title);
    }

    /**
     * @test
     */
    public function event_namebadges_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $retreat = \App\Models\Retreat::factory()->create();
        $retreatant = \App\Models\Contact::factory()->create([
                'contact_type' => config('polanco.contact_type.individual'),
            ]);
        $room = \App\Models\Room::factory()->create();
        $registration = \App\Models\Registration::factory()->create([
                'event_id' => $retreat->id,
                'contact_id' => $retreatant->id,
                'room_id' => $room->id,
                'canceled_at' => null,
            ]);
        $response = $this->actingAs($user)->get('retreat/'.$registration->event_id.'/namebadges');
        $response->assertOk();
        $response->assertViewIs('retreats.namebadges');
        $response->assertViewHas('event');
        $response->assertViewHas('cresults');
        $response->assertSeeText($retreatant->first_name.' '.$retreatant->last_name);
    }


        /**
         * @test
         */
        public function event_namebadges_with_role_returns_an_ok_response()
        {
            $user = $this->createUserWithPermission('show-registration');
            $retreat = \App\Models\Retreat::factory()->create();
            $retreatant = \App\Models\Contact::factory()->create([
                    'contact_type' => config('polanco.contact_type.individual'),
                ]);
            $room = \App\Models\Room::factory()->create();
            $role = $this->faker->randomElement(array_flip(config('polanco.participant_role_id')));

            // TODO: perhaps ideally this would be refactored so that the case select would work for all pariticipant role types
            // $role = \App\Models\ParticipantRoleType::whereIsActive(1)->get()->random();
            $registration = \App\Models\Registration::factory()->create([
                    'event_id' => $retreat->id,
                    'contact_id' => $retreatant->id,
                    'room_id' => $room->id,
                    'canceled_at' => null,
                    'role_id' => config('polanco.participant_role_id.'.$role),
                ]);

            $response = $this->actingAs($user)->get('retreat/'.$registration->event_id.'/namebadges/'.$role);

            $response->assertOk();
            $response->assertViewIs('retreats.namebadges');
            $response->assertViewHas('event');
            $response->assertViewHas('cresults');
            $response->assertSeeText($retreatant->first_name.' '.$retreatant->last_name);
        }

    /**
     * @test
     */
    public function event_tableplacards_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-registration');
        $retreat = \App\Models\Retreat::factory()->create();
        $retreatant = \App\Models\Contact::factory()->create([
                'contact_type' => config('polanco.contact_type.individual'),
            ]);
        $registration = \App\Models\Registration::factory()->create([
                'event_id' => $retreat->id,
                'contact_id' => $retreatant->id,
                'canceled_at' => null,
                'role_id' => config('polanco.participant_role_id.retreatant'),
            ]);
        $response = $this->actingAs($user)->get('retreat/'.$registration->event_id.'/tableplacards');
        $response->assertOk();
        $response->assertViewIs('retreats.tableplacards');
        $response->assertViewHas('event');
        $response->assertViewHas('cresults');
        $response->assertSeeText($retreatant->first_name.' '.$retreatant->last_name);
    }

    /**
     * @test
     */
    public function results_returns_an_ok_response()
    {   // create a new user and then search for that user's last name and ensure that a result appears
        $user = $this->createUserWithPermission('show-retreat');

        $retreat = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get('retreat/results?idnumber='.$retreat->idnumber);

        $response->assertOk();
        $response->assertViewIs('retreats.results');
        $response->assertViewHas('events');
        $response->assertSeeText('results found');
        $response->assertSeeText($retreat->idnumber);
    }

    /**
     * @test
     */
    public function search_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');

        $response = $this->actingAs($user)->get('retreat/search');

        $response->assertOk();
        $response->assertViewIs('retreats.search');
        $response->assertViewHas('event_types');
        $response->assertSeeText('Search Events');
    }

    // test cases...
}
