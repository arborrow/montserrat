<?php

namespace Tests\Feature\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TouchpointController
 */
class TouchpointControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function add_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');
        // Create a fake contact to have an interaction with
        // Creat a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $contact = \App\Models\Contact::factory()->create();
        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);
        $group_contact = \App\Models\GroupContact::factory()->create([
            'group_id' => config('polanco.group_id.staff'),
            'contact_id' => $staff->id,
        ]);

        $response = $this->actingAs($user)->get('touchpoint/add/'.$contact->id);

        $response->assertOk();
        $response->assertViewIs('touchpoints.create');
        $response->assertViewHas('staff', function ($staff_members) use ($staff) {
            return Arr::exists($staff_members, $staff->id);
        });
        $response->assertViewHas('persons', function ($people) use ($contact) {
            return Arr::exists($people, $contact->id);
        });
        $response->assertViewHas('defaults');
        $response->assertSeeText('Create Touchpoint');
    }

    /**
     * @test
     */
    public function add_group_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');
        // Create a fake contact to have an interaction with
        // Creat a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);
        $group_contact_staff = \App\Models\GroupContact::factory()->create([
            'group_id' => config('polanco.group_id.staff'),
            'contact_id' => $staff->id,
        ]);

        $group = \App\Models\Group::factory()->create();

        /* for testing add we don't actually need to create the group members so I'm commenting out

        $number_group_members = $this->faker->numberBetween(2, 10);
        $group_contact = \App\Models\GroupContact::factory()->count($number_group_members)->create([
          'group_id' => $group->id,
        ]);

        */

        $response = $this->actingAs($user)->get('group/'.$group->id.'/touchpoint');

        $response->assertOk();
        $response->assertViewIs('touchpoints.add_group');
        $response->assertViewHas('staff', function ($staff_members) use ($staff) {
            return Arr::exists($staff_members, $staff->id);
        });
        $response->assertViewHas('groups', function ($group_members) use ($group) {
            return Arr::exists($group_members, $group->id);
        });
        $response->assertViewHas('defaults');
        $response->assertSeeText('Create Group Touchpoint');
    }

    /**
     * @test
     */
    public function add_retreat_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');

        // Create a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);

        // Create a fake retreat
        // Register a random number of people for that retreat
        // Create touchpoint for the retreatants registered on that retreat
        // Since this is just the add, we don't actually need the retreatants so commenting them out

        $retreat = \App\Models\Retreat::factory()->create();
        /* $number_participants = $this->faker->numberBetween(3,15);
        $registration = \App\Models\Registration::factory()->count($number_participants)->create([
            'event_id' => $retreat->id,
        ]);
        */

        $response = $this->actingAs($user)->get('retreat/'.$retreat->id.'/touchpoint');

        $response->assertOk();
        $response->assertViewIs('touchpoints.add_retreat');
        $response->assertViewHas('staff');
        $response->assertViewHas('retreat');
        $response->assertViewHas('retreats');
        $response->assertViewHas('participants');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Create Retreat Touchpoint');
    }

    /**
     * @test
     */
    public function add_retreat_waitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');

        // Create a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);

        // Create a fake retreat
        // Register a random number of people for that retreat
        // Create touchpoint for the retreatants registered on that retreat
        // Since this is just the add, we don't actually need the retreatants so commenting them out

        $retreat = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get('retreat/'.$retreat->id.'/waitlist_touchpoint');

        $response->assertOk();
        $response->assertViewIs('touchpoints.add_retreat_waitlist');
        $response->assertViewHas('staff');
        $response->assertViewHas('retreat');
        $response->assertViewHas('retreats');
        $response->assertViewHas('participants');
        $response->assertViewHas('defaults');
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');

        $response = $this->actingAs($user)->get(route('touchpoint.create'));

        $response->assertOk();
        $response->assertViewIs('touchpoints.create');
        $response->assertViewHas('staff');
        $response->assertViewHas('persons');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Create Touchpoint');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-touchpoint');
        $touchpoint = \App\Models\Touchpoint::factory()->create();

        $response = $this->actingAs($user)->delete(route('touchpoint.destroy', [$touchpoint]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\TouchpointController::class, 'index']));
        $this->assertSoftDeleted($touchpoint);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-touchpoint');
        $touchpoint = \App\Models\Touchpoint::factory()->create();

        $response = $this->actingAs($user)->get(route('touchpoint.edit', [$touchpoint]));

        $response->assertOk();
        $response->assertViewIs('touchpoints.edit');
        $response->assertViewHas('touchpoint');
        $response->assertViewHas('staff');
        $response->assertViewHas('persons');
        $response->assertSeeText('Edit Touchpoint');

        $this->assertTrue($this->findFieldValueInResponseContent('touched_at', $touchpoint->touched_at, 'datetime', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('person_id', $touchpoint->person_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('type', $touchpoint->type, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('notes', $touchpoint->notes, 'textarea', $response->getContent()));

        /*
        {!! Form::text('touched_at', date('F j, Y g:i A', strtotime($touchpoint->touched_at)), ['class' => 'col-md-3']) !!}
        {!! Form::select('person_id', $persons, $touchpoint->person_id, ['class' => 'col-md-3']) !!}
        {!! Form::select('type', config('polanco.touchpoint_source'), $touchpoint->type, ['class' => 'col-md-3']) !!}
        {!! Form::textarea('notes', $touchpoint->notes, ['class' => 'col-md-3']) !!}

         */
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-touchpoint');

        $response = $this->actingAs($user)->get(route('touchpoint.index'));

        $response->assertOk();
        $response->assertViewIs('touchpoints.index');
        $response->assertViewHas('touchpoints');
        $response->assertSeeText('Touchpoint Index');
    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-touchpoint');

        $touchpoint = \App\Models\Touchpoint::factory()->create();

        $response = $this->actingAs($user)->get('touchpoint/type/'.$touchpoint->staff_id);
        $response->assertOk();
        $response->assertViewIs('touchpoints.index');
        $response->assertViewHas('touchpoints');
        $response->assertViewHas('staff', function ($staff_members) use ($touchpoint) {
            return Arr::exists($staff_members, $touchpoint->staff_id);
        });
        $response->assertSeeText('Touchpoint Index');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-touchpoint');
        $touchpoint = \App\Models\Touchpoint::factory()->create();

        $response = $this->actingAs($user)->get(route('touchpoint.show', [$touchpoint]));

        $response->assertOk();
        $response->assertViewIs('touchpoints.show');
        $response->assertViewHas('touchpoint');
        $response->assertSeeText('Touchpoint details');
        $response->assertSeeText($touchpoint->description);
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');
        $person = \App\Models\Contact::factory()->create();
        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);
        $group_contact = \App\Models\GroupContact::factory()->create([
            'group_id' => config('polanco.group_id.staff'),
            'contact_id' => $staff->id,
        ]);
        // $touched_at = $this->faker->dateTime('now');
        $touched_at = Carbon::now();
        $response = $this->actingAs($user)->post(route('touchpoint.store'), [
            'touched_at' => $touched_at,
            'person_id' => $person->id,
            'staff_id' => $staff->id,
            'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
            'notes' => $this->faker->paragraph(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\TouchpointController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('touchpoints', [
            'touched_at' => $touched_at,
            'person_id' => $person->id,
            'staff_id' => $staff->id,
        ]);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TouchpointController::class,
            'store',
            \App\Http\Requests\StoreTouchpointRequest::class
        );
    }

    /**
     * @test
     */
    public function store_group_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');
        // Create a fake contact to have an interaction with
        // Creat a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);
        $group_contact_staff = \App\Models\GroupContact::factory()->create([
            'group_id' => config('polanco.group_id.staff'),
            'contact_id' => $staff->id,
        ]);

        $group = \App\Models\Group::factory()->create();

        $number_group_members = $this->faker->numberBetween(2, 10);
        $group_contact = \App\Models\GroupContact::factory()->count($number_group_members)->create([
            'group_id' => $group->id,
        ]);

        $notes = $this->faker->paragraph();
        $touched_at = Carbon::now();

        $random_group_member = \App\Models\GroupContact::whereGroupId($group->id)->get()->random();

        $response = $this->actingAs($user)->post('touchpoint/add_group', [
            'group_id' => $group->id,
            'touched_at' => $touched_at,
            'staff_id' => $staff->id,
            'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
            'notes' => $notes,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\GroupController::class, 'show'], $group->id));
        $response->assertSessionHas('flash_notification');
        $this->assertDatabaseHas('touchpoints', [
            'touched_at' => $touched_at,
            'person_id' => $random_group_member->contact_id,
            'staff_id' => $staff->id,
            'notes' => $notes,
        ]);
    }

    /**
     * @test
     */
    public function store_group_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TouchpointController::class,
            'store_group',
            \App\Http\Requests\StoreGroupTouchpointRequest::class
        );
    }

    /**
     * @test
     */
    public function store_retreat_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');

        // Create a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);

        // Create a fake retreat
        // Register a random number of people for that retreat
        // Create touchpoint for the retreatants registered on that retreat

        $retreat = \App\Models\Retreat::factory()->create();
        $number_participants = $this->faker->numberBetween(3, 15);

        // criteria set from search criteria in touchpoint controller's store_retreat method
        $participants = \App\Models\Registration::factory()->count($number_participants)->create([
            'event_id' => $retreat->id,
            'status_id' => config('polanco.registration_status_id.registered'),
            'role_id' => config('polanco.participant_role_id.retreatant'),
            'canceled_at' => null,
        ]);

        $notes = $this->faker->paragraph();
        $touched_at = $this->faker->dateTime('now');
        $touched_at = Carbon::now();

        // where criteria copied from touchpoint controller store_retreat method for consistency
        $actual_participants = \App\Models\Registration::whereStatusId(config('polanco.registration_status_id.registered'))->whereEventId($retreat->id)->whereRoleId(config('polanco.participant_role_id.retreatant'))->whereNull('canceled_at')->get();
        $random_participant = $actual_participants->random();

        $response = $this->actingAs($user)->post('touchpoint/add_retreat', [
            'event_id' => $retreat->id,
            'touched_at' => $touched_at,
            'staff_id' => $staff->id,
            'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
            'notes' => $notes,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $retreat->id));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('touchpoints', [
            'touched_at' => $touched_at,
            'person_id' => $random_participant->contact_id,
            'staff_id' => $staff->id,
            'notes' => $notes,
        ]);
    }

    /**
     * @test
     */
    public function store_retreat_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TouchpointController::class,
            'store_retreat',
            \App\Http\Requests\StoreRetreatTouchpointRequest::class
        );
    }

    /**
     * @test
     */
    public function store_retreat_waitlist_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-touchpoint');

        // Create a staff contact and use the authenticated user's email to associate with the staff contact
        // Add the staff contact to the staff group - probably not necessary for this test but for consistency I am adding it here

        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);

        // Create a fake retreat
        // Register a random number of people for that retreat
        // Create touchpoint for the retreatants registered on that retreat

        $retreat = \App\Models\Retreat::factory()->create();
        $number_participants = $this->faker->numberBetween(3, 15);

        // criteria set from search criteria in touchpoint controller's store_retreat method
        $participants = \App\Models\Registration::factory()->count($number_participants)->create([
            'event_id' => $retreat->id,
            'status_id' => config('polanco.registration_status_id.waitlist'),
            'role_id' => config('polanco.participant_role_id.retreatant'),
            'canceled_at' => null,
        ]);

        $notes = $this->faker->paragraph();
        $touched_at = Carbon::now();

        // where criteria copied from touchpoint controller store_retreat method for consistency
        $actual_participants = \App\Models\Registration::whereStatusId(config('polanco.registration_status_id.waitlist'))->whereEventId($retreat->id)->whereRoleId(config('polanco.participant_role_id.retreatant'))->whereNull('canceled_at')->get();
        $random_participant = $actual_participants->random();

        $response = $this->actingAs($user)->post('touchpoint/add_retreat_waitlist', [
            'event_id' => $retreat->id,
            'touched_at' => $touched_at,
            'staff_id' => $staff->id,
            'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
            'notes' => $notes,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $retreat->id));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('touchpoints', [
            'touched_at' => $touched_at,
            'person_id' => $random_participant->contact_id,
            'staff_id' => $staff->id,
            'notes' => $notes,
        ]);
    }

    /**
     * @test
     */
    public function store_retreat_waitlist_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TouchpointController::class,
            'store_retreat_waitlist',
            \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-touchpoint');
        $person = \App\Models\Contact::factory()->create();
        $staff = \App\Models\Contact::factory()->create();
        $email = \App\Models\Email::factory()->create([
            'contact_id' => $staff->id,
            'location_type_id' => config('polanco.location_type.work'),
            'email' => $user->email,
            'is_primary' => '1',
        ]);
        $group_contact = \App\Models\GroupContact::factory()->create([
            'group_id' => config('polanco.group_id.staff'),
            'contact_id' => $staff->id,
        ]);

        $touchpoint = \App\Models\Touchpoint::factory()->create();
        $original_staff_id = $touchpoint->staff_id;
        $original_person_id = $touchpoint->person_id;
        $response = $this->actingAs($user)->put(route('touchpoint.update', [$touchpoint]), [
            'id' => $touchpoint->id,
            'touched_at' => Carbon::now(),
            'person_id' => $person->id,
            'staff_id' => $staff->id,
            'notes' => $this->faker->paragraph(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\TouchpointController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $touchpoint->refresh();
        $this->AssertEquals($person->id, $touchpoint->person_id);
        $this->AssertEquals($staff->id, $touchpoint->staff_id);
        $this->AssertNotEquals($original_staff_id, $touchpoint->staff_id);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TouchpointController::class,
            'update',
            \App\Http\Requests\UpdateTouchpointRequest::class
        );
    }

    // test cases...
}
