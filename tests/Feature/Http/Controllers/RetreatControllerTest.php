<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RetreatController
 */
class RetreatControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function assign_rooms_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        // create a retreat, then create a number of registrations for the retreat
        $retreat = factory(\App\Retreat::class)->create();
        $number_registrations = $this->faker->numberBetween(2, 10);
        $registration = factory(\App\Registration::class, $number_registrations)->create([
          'event_id' => $retreat->id,
          'canceled_at' => null,
          'arrived_at' => null,
          'departed_at' => null,
          'room_id' => null,
        ]);

        // create a single room for the test just in case none have been created
        $room = factory(\App\Room::class)->create();

        $response = $this->actingAs($user)->get(route('retreat.assign_rooms', ['id' => $retreat->id]));

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
        $retreat = factory(\App\Retreat::class)->create();
        $number_registrations = $this->faker->numberBetween(2, 10);
        $registrations = factory(\App\Registration::class, $number_registrations)->create([
          'event_id' => $retreat->id,
          'canceled_at' => null,
          'arrived_at' => null,
          'departed_at' => null,
          'room_id' => null,
        ]);

        $response = $this->from('retreat.show', $retreat->id)->actingAs($user)->get(route('retreat.checkin', ['id' => $retreat->id]));
        $registration = $registrations->random();
        $registration->refresh();
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
        $retreat = factory(\App\Retreat::class)->create(
          [
            'start_date' => $this->faker->dateTimeBetween('-5 days', '-2 days'),
            'end_date' => $this->faker->dateTimeBetween('-1 day', '1 day'),
          ]
        );
        $number_registrations = $this->faker->numberBetween(2, 10);
        $registrations = factory(\App\Registration::class, $number_registrations)->create([
          'event_id' => $retreat->id,
          'canceled_at' => null,
          'arrived_at' => $this->faker->dateTime('now'),
          'departed_at' => null,
          'room_id' => null,
        ]);

        $response = $this->actingAs($user)->get(route('retreat.checkout', ['id' => $retreat->id]));

        $registration = $registrations->random();
        $registration->refresh();

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
        $retreat = factory(\App\Retreat::class)->create();

        $response = $this->actingAs($user)->delete(route('retreat.destroy', [$retreat]));

        $response->assertRedirect(action('RetreatController@index'));
        $this->assertSoftDeleted($retreat);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-retreat');
        $retreat = factory(\App\Retreat::class)->create();

        $response = $this->actingAs($user)->get(route('retreat.edit', [$retreat]));

        $response->assertOk();
        $response->assertViewIs('retreats.edit');
        $response->assertViewHas('retreat');
        $response->assertViewHas('d');
        $response->assertViewHas('i');
        $response->assertViewHas('a');
        $response->assertViewHas('c');
        $response->assertViewHas('event_types');
        $response->assertViewHas('is_active');
        $response->assertSeeText('Edit');
        $response->assertSeeText(e($retreat->idnumber));
    }

    /**
     * @test
     */
    public function edit_payments_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-payment');
        $retreat = factory(\App\Retreat::class)->create();
        $registration = factory(\App\Registration::class)->create([
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
        $retreat = factory(\App\Retreat::class)->create();

        $response = $this->actingAs($user)->get('retreat/id/'.$retreat->idnumber);

        $response->assertOk();
        $response->assertViewIs('retreats.show');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertViewHas('status');
        $response->assertSeeText(e($retreat->title));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        $retreat = factory(\App\Retreat::class)->create();
        $response = $this->actingAs($user)->get(route('retreat.index'));
        $upcoming = $response->viewData('retreats');
        $previous = $response->viewData('oldretreats');
        $total = $upcoming->count() + $previous->count();
        $response->assertOk();
        $response->assertViewIs('retreats.index');
        $response->assertViewHas('retreats');
        $response->assertViewHas('oldretreats');
        $response->assertViewHas('defaults');
        $response->assertViewHas('event_types');
        $response->assertSeeText('Upcoming Retreat');
        $response->assertSeeText('Previous Retreat');
        $this->assertGreaterThan(1, $total);
    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        // create a new event type, add a random number of retreats (2-10) to that event type ensuring they are all future events
        $event_type = factory(\App\EventType::class)->create();
        $number_retreats = $this->faker->numberBetween(2, 10);
        $retreat = factory(\App\Retreat::class, $number_retreats)->create([
            'event_type_id' => $event_type->id,
            'start_date' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'end_date' => $this->faker->dateTimeBetween('+11 days', '+15 days'),

        ]);

        $response = $this->actingAs($user)->get('retreat/type/'.$event_type->id);
        $upcoming = $response->viewData('retreats');
        $response->assertOk();
        $response->assertViewIs('retreats.index');
        $response->assertViewHas('retreats');
        $response->assertViewHas('oldretreats');
        $response->assertViewHas('defaults');
        $response->assertViewHas('event_types');
        $response->assertSeeText('Upcoming '.e($event_type->type));
        $response->assertSeeText('Previous '.e($event_type->type));
        $this->assertEquals($number_retreats, $upcoming->count());
    }

    /**
     * @test
     */
    public function room_update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-registration');
        $retreat = factory(\App\Retreat::class)->create();
        $registration = factory(\App\Registration::class)->create([
          'room_id' => null,
          'event_id' => $retreat->id,
          'notes' => null,
          'source' => 'room_update',
          'canceled_at' => null,
        ]);
        $room = factory(\App\Room::class)->create();
        $registrations = [];
        $notes = [];
        $registrations[$registration->id] = $room->id;
        $notes[$registration->id] = $this->faker->sentence;

        $response = $this->actingAs($user)->post(route('retreat.room_update'), [
            'registrations' => $registrations,
            'notes' => $notes,
        ]);

        $updated_registration = \App\Registration::findOrFail($registration->id);
        $response->assertRedirect(action('RetreatController@index'));
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
        $retreat = factory(\App\Retreat::class)->create();

        $response = $this->actingAs($user)->get(route('retreat.show', [$retreat]));

        $response->assertOk();
        $response->assertViewIs('retreats.show');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertViewHas('status');
        $response->assertSeeText(e($retreat->title));
    }

    /**
     * @test
     */
    public function show_payments_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');

        $registration = factory(\App\Registration::class)->create();
        $retreat = \App\Retreat::findOrFail($registration->event_id);

        $response = $this->actingAs($user)->get(route('retreat.payments', ['id' => $registration->event_id]));

        $response->assertOk();
        $response->assertViewIs('retreats.payments.show');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertSeeText(e($retreat->idnumber));
    }

    /**
     * @test
     */
    public function show_waitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-retreat');
        $registration = factory(\App\Registration::class)->create([
            'status_id' => config('polanco.registration_status_id.waitlist'),
        ]);
        $retreat = \App\Retreat::findOrFail($registration->event_id);
        $response = $this->actingAs($user)->get('retreat/'.$registration->event_id.'/waitlist');

        $response->assertOk();
        $response->assertViewIs('retreats.waitlist');
        $response->assertViewHas('retreat');
        $response->assertViewHas('registrations');
        $response->assertSeeText('Waitlist for');
        $response->assertSeeText(e($retreat->idnumber));
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
        $retreat = \App\Retreat::whereIdnumber($idnumber)->first();
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
        $retreat = factory(\App\Retreat::class)->create();
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
        $response->assertRedirect(action('RetreatController@index'));
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
        $retreat = factory(\App\Retreat::class)->create();
        $retreatant = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.individual'),
        ]);
        $room = factory(\App\Room::class)->create();
        $registration = factory(\App\Registration::class)->create([
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

    // test cases...
}
