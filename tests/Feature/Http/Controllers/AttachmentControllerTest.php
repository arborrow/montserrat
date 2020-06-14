<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AttachmentController
 */
class AttachmentControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function delete_avatar_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        //create a person, create a fake avatar for that person, see if you can delete the avatar
        $person = factory(\App\Contact::class)->create();
        $file = UploadedFile::fake()->image('avatar.png', 150, 150)->storeAs('contact/'.$person->id, 'avatar.png');
        $description = 'Avatar for '.$person->full_name;

        $attachment = factory(\App\Attachment::class)->create([
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'contact',
            'entity_id' => $person->id,
            'file_type_id' => config('polanco.file_type.contact_avatar'),
            'uri' => 'avatar.png',
        ]);

        $response = $this->actingAs($user)->get(route('delete_avatar', ['user_id' => $attachment->entity_id]));

        $response->assertRedirect(action('PersonController@show', $person->id));

    }

    /**
     * @test
     */
    public function delete_contact_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $person = factory(\App\Contact::class)->create();
        $file_name = $this->faker->isbn10.'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('contact/'.$person->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$person->full_name;

        $attachment = factory(\App\Attachment::class)->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'contact',
            'entity_id' => $person->id,
            'file_type_id' => config('polanco.file_type.contact_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('delete_contact_attachment', ['user_id' => $attachment->entity_id, 'file_name' => $attachment->uri]));

        $response->assertRedirect(action('PersonController@show', $person->id));

    }

    /**
     * @test
     */
    public function delete_event_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $event = factory(\App\Retreat::class)->create();
        $file_name = $this->faker->isbn10.'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('event/'.$event->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$event->idnumber;

        $attachment = factory(\App\Attachment::class)->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $event->id,
            'file_type_id' => config('polanco.file_type.event_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('delete_event_attachment', ['event_id' => $attachment->entity_id, 'file_name' => $attachment->uri]));
        $response->assertRedirect(action('RetreatController@show', $event->id));
        // TODO: perform additional assertions such as verify that the deleted file has been renamed to name-deleted-time.extension
    }

    /**
     * @test
     */
    public function delete_event_contract_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake contract for that retreat, see if you can delete the contract
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->create('contract.pdf')->storeAs('event/'.$retreat->id, 'contract.pdf');
        $description = 'Contract for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_contract'),
            'uri' => 'contract.pdf',
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('delete_event_contract', ['event_id' => $attachment->entity_id]));

        $response->assertRedirect(action('RetreatController@show', $retreat->id));

    }

    /**
     * @test
     */
    public function delete_event_evaluations_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake evaluation for that retreat, see if you can delete the evaluation
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->create('evaluations.pdf')->storeAs('event/'.$retreat->id, 'evaluations.pdf');
        $description = 'Evaluations for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_evaluation'),
            'uri' => 'evaluations.pdf',
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('delete_event_evaluations', ['event_id' => $attachment->entity_id]));

        $response->assertRedirect(action('RetreatController@show', $retreat->id));

    }

    /**
     * @test
     */
    public function delete_event_group_photo_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake evaluation for that retreat, see if you can display the evaluation
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->image('group_photo.jpg', 200, 300)->storeAs('event/'.$retreat->id, 'group_photo.jpg');
        $description = 'Group photo for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_group_photo'),
            'uri' => 'group_photo.jpg',
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('delete_event_group_photo', ['event_id' => $attachment->entity_id]));

        $response->assertRedirect(action('RetreatController@show', $retreat->id));

    }

    /**
     * @test
     */
    public function delete_event_schedule_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake schedule for that retreat, see if you can display the schedule
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->create('schedule.pdf')->storeAs('event/'.$retreat->id, 'schedule.pdf');
        $description = 'Schedule for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_schedule'),
            'uri' => 'schedule.pdf',
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('delete_event_schedule', ['event_id' => $attachment->entity_id]));

        $response->assertRedirect(action('RetreatController@show', $retreat->id));

    }

    /**
     * @test
     */
    public function get_avatar_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-avatar');

        //create a person, create a fake avatar for that person, see if you can display the avatar
        $person = factory(\App\Contact::class)->create();
        $file = UploadedFile::fake()->image('avatar.png', 150, 150)->storeAs('contact/'.$person->id, 'avatar.png');
        $description = 'Avatar for '.$person->full_name;

        $attachment = factory(\App\Attachment::class)->create([
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'contact',
            'entity_id' => $person->id,
            'file_type_id' => config('polanco.file_type.contact_avatar'),
            'uri' => 'avatar.png',
        ]);

        $response = $this->actingAs($user)->get(route('get_avatar', ['user_id' => $person->id]));

        $response->assertOk();

    }

    /**
     * @test
     */
    public function get_event_contract_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-event-attachment');
        //create a retreat, create a fake contract for that retreat, see if you can display the contract
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->create('contract.pdf')->storeAs('event/'.$retreat->id, 'contract.pdf');
        $description = 'Contract for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_contract'),
            'uri' => 'contract.pdf',
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('get_event_contract', ['event_id' => $retreat->id]));

        $response->assertOk();

    }

    /**
     * @test
     */
    public function get_event_evaluations_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-event-evaluation');
        //create a retreat, create a fake evaluation for that retreat, see if you can display the evaluation
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->create('evaluations.pdf')->storeAs('event/'.$retreat->id, 'evaluations.pdf');
        $description = 'Evaluations for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_evaluation'),
            'uri' => 'evaluation.pdf',
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('get_event_evaluations', ['event_id' => $attachment->entity_id]));

        $response->assertOk();

    }

    /**
     * @test
     */
    public function get_event_group_photo_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-event-group-photo');
        //create a retreat, create a fake evaluation for that retreat, see if you can display the evaluation
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->image('group_photo.jpg', 200, 300)->storeAs('event/'.$retreat->id, 'group_photo.jpg');
        $description = 'Group photo for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_group_photo'),
            'uri' => 'group_photo.jpg',
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('get_event_group_photo', ['event_id' => $attachment->entity_id]));

        $response->assertOk();

    }

    /**
     * @test
     */
    public function get_event_schedule_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-event-schedule');
        //create a retreat, create a fake schedule for that retreat, see if you can display the schedule
        $retreat = factory(\App\Retreat::class)->create();
        $file = UploadedFile::fake()->create('schedule.pdf')->storeAs('event/'.$retreat->id, 'schedule.pdf');
        $description = 'Schedule for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = factory(\App\Attachment::class)->create([
            'file_type_id' => config('polanco.file_type.event_schedule'),
            'uri' => 'schedule.pdf',
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $retreat->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('get_event_schedule', ['event_id' => $attachment->entity_id]));

        $response->assertOk();

    }

    /**
     * @test
     */
    public function show_contact_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $person = factory(\App\Contact::class)->create();
        $file_name = $this->faker->isbn10.'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('contact/'.$person->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$person->full_name;

        $attachment = factory(\App\Attachment::class)->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'contact',
            'entity_id' => $person->id,
            'file_type_id' => config('polanco.file_type.contact_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('show_contact_attachment', ['user_id' => $person->id, 'file_name' => $file_name]));

        $response->assertOk();

    }


    /**
     * @test
     */
    public function show_event_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-event-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $event = factory(\App\Retreat::class)->create();
        $file_name = $this->faker->isbn10.'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('event/'.$event->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$event->idnumber;

        $attachment = factory(\App\Attachment::class)->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $event->id,
            'file_type_id' => config('polanco.file_type.event_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('show_event_attachment', ['event_id' => $event->id, 'file_name' => $file_name]));

        $response->assertOk();
    }

// test cases...
}
