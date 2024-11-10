<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RoomController
 */
class RoomControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    #[Test]
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-room');

        $response = $this->actingAs($user)->get(route('room.create'));

        $response->assertOk();
        $response->assertViewIs('rooms.create');
        $response->assertViewHas('locations');
        $response->assertViewHas('floors');
        $response->assertSeeText('Add A Room');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-room');
        $room = \App\Models\Room::factory()->create();

        $response = $this->actingAs($user)->delete(route('room.destroy', [$room]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RoomController::class, 'index']));
        $this->assertSoftDeleted($room);
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-room');
        $room = \App\Models\Room::factory()->create();

        $response = $this->actingAs($user)->get(route('room.edit', [$room]));

        $response->assertOk();
        $response->assertViewIs('rooms.edit');
        $response->assertViewHas('room');
        $response->assertViewHas('locations');
        $response->assertViewHas('floors');
        $room_data = $response->viewData('room');
        $this->assertEquals($room_data->description, $room->description);
        $response->assertSeeText('Edit Room');

        $this->assertTrue($this->findFieldValueInResponseContent('location_id', $room->location_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('floor', $room->floor, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('name', $room->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $room->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('notes', $room->notes, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('access', $room->access, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('type', $room->type, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('occupancy', $room->occupancy, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('status', $room->status, 'text', $response->getContent()));

        /*
        {!! Form::select('location_id', $locations, $room->location_id, ['class' => 'col-md-2']) !!}
        {!! Form::select('floor', $floors, $room->floor, ['class' => 'col-md-2']) !!}
        {!! Form::text('name', $room->name, ['class' => 'col-md-2']) !!}
        {!! Form::textarea('description', $room->description, ['class' => 'col-md-5', 'rows'=>'3']) !!}
        {!! Form::textarea('notes', $room->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
        {!! Form::text('access', $room->access, ['class' => 'col-md-1']) !!}
        {!! Form::text('type', $room->type, ['class' => 'col-md-1']) !!}
        {!! Form::text('occupancy', $room->occupancy, ['class' => 'col-md-1']) !!}
        {!! Form::text('status', $room->status, ['class' => 'col-md-1']) !!}
         */
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-room');

        $response = $this->actingAs($user)->get(route('room.index'));

        $response->assertOk();
        $response->assertViewIs('rooms.index');
        $response->assertViewHas('roomsort');
        $response->assertSeeText('Room Index');
    }

    #[Test]
    public function schedule_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-room');

        $response = $this->actingAs($user)->get(route('rooms'));

        $response->assertOk();
        $response->assertViewIs('rooms.sched2');
        $response->assertViewHas('roomsort');
        $response->assertViewHas('dts');
        $response->assertViewHas('m');
        $response->assertViewHas('previous_link');
        $response->assertViewHas('next_link');
        $response->assertSeeText('Room Schedules');
    }

    #[Test]
    public function schedule_with_hyphenated_date_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-room');
        $yesterday = Carbon::now()->subDay()->toDateString();

        $response = $this->actingAs($user)->get(route('rooms', ['ymd' => $yesterday]));

        $response->assertOk();
        $response->assertViewIs('rooms.sched2');
        $response->assertViewHas('roomsort');
        $response->assertViewHas('dts');
        $response->assertViewHas('m');
        $response->assertViewHas('previous_link');
        $response->assertViewHas('next_link');
        $response->assertSeeText('Room Schedules');
    }

    #[Test]
    public function schedule_with_unhyphenated_date_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-room');
        $yesterday = Carbon::now()->subDay()->toDateString();
        // remove hyphens
        $yesterday = str_replace('-', '', $yesterday);

        $response = $this->actingAs($user)->get(route('rooms', ['ymd' => $yesterday]));

        $response->assertOk();
        $response->assertViewIs('rooms.sched2');
        $response->assertViewHas('roomsort');
        $response->assertViewHas('dts');
        $response->assertViewHas('m');
        $response->assertViewHas('previous_link');
        $response->assertViewHas('next_link');
        $response->assertSeeText('Room Schedules');
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-room');
        $room = \App\Models\Room::factory()->create();

        $response = $this->actingAs($user)->get(route('room.show', [$room]));

        $response->assertOk();
        $response->assertViewIs('rooms.show');
        $response->assertViewHas('room');
        $response->assertSeeText($room->description);
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-room');

        $location = \App\Models\Location::factory()->create();
        $name = 'New '.$this->faker->lastName().' Suite';
        $description = $this->faker->catchPhrase();

        $response = $this->actingAs($user)->post(route('room.store'), [
            'location_id' => $location->id,
            'floor' => $this->faker->numberBetween($min = 1, $max = 2),
            'name' => $name,
            'description' => $description,
            'notes' => $this->faker->sentence(),
            'access' => $this->faker->word(),
            'type' => $this->faker->word(),
            'occupancy' => $this->faker->randomDigitNotNull(),
            'status' => $this->faker->word(),
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RoomController::class, 'index']));
        $this->assertDatabaseHas('rooms', [
            'name' => $name,
            'description' => $description,
            'location_id' => $location->id,
        ]);
    }

    #[Test]
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoomController::class,
            'store',
            \App\Http\Requests\StoreRoomRequest::class
        );
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-room');
        $room = \App\Models\Room::factory()->create();

        $original_description = $room->description;
        $new_location = \App\Models\Location::factory()->create();
        $new_name = 'Renovated '.$this->faker->lastName().' Suite';
        $new_description = $this->faker->catchPhrase();

        $response = $this->actingAs($user)->put(route('room.update', [$room]), [
            'id' => $room->id,
            'location_id' => $new_location->id,
            'name' => $new_name,
            'description' => $new_description,
        ]);

        $room->refresh();
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\RoomController::class, 'index']));
        $this->assertEquals($new_description, $room->description);
        $this->assertNotEquals($original_description, $room->description);
    }

    #[Test]
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoomController::class,
            'update',
            \App\Http\Requests\UpdateRoomRequest::class
        );
    }

    // test cases...
}
