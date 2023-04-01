<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AttachmentController
 */
class AttachmentControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function delete_asset_photo_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake evaluation for that retreat, see if you can display the evaluation
        $asset = \App\Models\Asset::factory()->create();
        $file = UploadedFile::fake()->image('asset_photo.jpg', 200, 300)->storeAs('asset/'.$asset->id, 'asset_photo.jpg');
        $description = 'Photo of '.$asset->name;
        $attachment = \App\Models\Attachment::factory()->create([
            'file_type_id' => config('polanco.file_type.asset_photo'),
            'uri' => 'asset_photo.jpg',
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'asset',
            'entity_id' => $asset->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('delete_asset_photo', ['asset_id' => $attachment->entity_id]));

        $response->assertRedirect(action([\App\Http\Controllers\AssetController::class, 'show'], $asset->id));
    }

    /**
     * @test
     */
    public function delete_avatar_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        //create a person, create a fake avatar for that person, see if you can delete the avatar
        $person = \App\Models\Contact::factory()->create();
        $file = UploadedFile::fake()->image('avatar.png', 150, 150)->storeAs('contact/'.$person->id, 'avatar.png');
        $description = 'Avatar for '.$person->full_name;

        $attachment = \App\Models\Attachment::factory()->create([
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'contact',
            'entity_id' => $person->id,
            'file_type_id' => config('polanco.file_type.contact_avatar'),
            'uri' => 'avatar.png',
        ]);

        $response = $this->actingAs($user)->get(route('delete_avatar', ['user_id' => $attachment->entity_id]));

        $response->assertRedirect(action([\App\Http\Controllers\PersonController::class, 'show'], $person->id));
    }

    /**
     * @test
     */
    public function delete_asset_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        $asset = \App\Models\Asset::factory()->create();
        $file_name = $this->faker->isbn10().'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('asset/'.$asset->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$asset->name;

        $attachment = \App\Models\Attachment::factory()->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'asset',
            'entity_id' => $asset->id,
            'file_type_id' => config('polanco.file_type.asset_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('delete_asset_attachment', ['asset_id' => $attachment->entity_id, 'file_name' => $attachment->uri]));

        $response->assertRedirect(action([\App\Http\Controllers\AssetController::class, 'show'], $asset->id));
    }

    /**
     * @test
     */
    public function delete_contact_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $person = \App\Models\Contact::factory()->create();
        $file_name = $this->faker->isbn10().'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('contact/'.$person->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$person->full_name;

        $attachment = \App\Models\Attachment::factory()->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'contact',
            'entity_id' => $person->id,
            'file_type_id' => config('polanco.file_type.contact_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('delete_contact_attachment', ['user_id' => $attachment->entity_id, 'file_name' => $attachment->uri]));

        $response->assertRedirect(action([\App\Http\Controllers\PersonController::class, 'show'], $person->id));
    }

    /**
     * @test
     */
    public function delete_event_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $event = \App\Models\Retreat::factory()->create();
        $file_name = $this->faker->isbn10().'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('event/'.$event->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$event->idnumber;

        $attachment = \App\Models\Attachment::factory()->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'event',
            'entity_id' => $event->id,
            'file_type_id' => config('polanco.file_type.event_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('delete_event_attachment', ['event_id' => $attachment->entity_id, 'file_name' => $attachment->uri]));
        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $event->id));
        // TODO: perform additional assertions such as verify that the deleted file has been renamed to name-deleted-time.extension
    }

    /**
     * @test
     */
    public function delete_event_contract_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake contract for that retreat, see if you can delete the contract
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->create('contract.pdf')->storeAs('event/'.$retreat->id, 'contract.pdf');
        $description = 'Contract for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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

        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $retreat->id));
    }

    /**
     * @test
     */
    public function delete_event_evaluations_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake evaluation for that retreat, see if you can delete the evaluation
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->create('evaluations.pdf')->storeAs('event/'.$retreat->id, 'evaluations.pdf');
        $description = 'Evaluations for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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

        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $retreat->id));
    }

    /**
     * @test
     */
    public function delete_event_group_photo_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake evaluation for that retreat, see if you can display the evaluation
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->image('group_photo.jpg', 200, 300)->storeAs('event/'.$retreat->id, 'group_photo.jpg');
        $description = 'Group photo for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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

        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $retreat->id));
    }

    /**
     * @test
     */
    public function delete_event_schedule_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        //create a retreat, create a fake schedule for that retreat, see if you can display the schedule
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->create('schedule.pdf')->storeAs('event/'.$retreat->id, 'schedule.pdf');
        $description = 'Schedule for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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

        $response->assertRedirect(action([\App\Http\Controllers\RetreatController::class, 'show'], $retreat->id));
    }

    /**
     * @test
     */
    public function get_asset_photo_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-asset');
        $asset = \App\Models\Asset::factory()->create();
        $file = UploadedFile::fake()->image('asset_photo.jpg', 200, 300)->storeAs('asset/'.$asset->id, 'asset_photo.jpg');
        $description = 'Asset photo for '.$asset->name;
        $attachment = \App\Models\Attachment::factory()->create([
            'file_type_id' => config('polanco.file_type.asset_photo'),
            'uri' => 'asset_photo.jpg',
            'mime_type' => 'image/jpeg',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'asset',
            'entity_id' => $asset->id,
        ]);
        $attachment->refresh();

        $response = $this->actingAs($user)->get(route('get_asset_photo', ['asset_id' => $attachment->entity_id]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function get_avatar_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-avatar');

        //create a person, create a fake avatar for that person, see if you can display the avatar
        $person = \App\Models\Contact::factory()->create();
        $file = UploadedFile::fake()->image('avatar.png', 150, 150)->storeAs('contact/'.$person->id, 'avatar.png');
        $description = 'Avatar for '.$person->full_name;

        $attachment = \App\Models\Attachment::factory()->create([
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
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->create('contract.pdf')->storeAs('event/'.$retreat->id, 'contract.pdf');
        $description = 'Contract for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->create('evaluations.pdf')->storeAs('event/'.$retreat->id, 'evaluations.pdf');
        $description = 'Evaluations for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->image('group_photo.jpg', 200, 300)->storeAs('event/'.$retreat->id, 'group_photo.jpg');
        $description = 'Group photo for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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
        $retreat = \App\Models\Retreat::factory()->create();
        $file = UploadedFile::fake()->create('schedule.pdf')->storeAs('event/'.$retreat->id, 'schedule.pdf');
        $description = 'Schedule for '.$retreat->idnumber.'-'.$retreat->title;
        $attachment = \App\Models\Attachment::factory()->create([
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
        $person = \App\Models\Contact::factory()->create();
        $file_name = $this->faker->isbn10().'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('contact/'.$person->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$person->full_name;

        $attachment = \App\Models\Attachment::factory()->create([
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
        $event = \App\Models\Retreat::factory()->create();
        $file_name = $this->faker->isbn10().'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('event/'.$event->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$event->idnumber;

        $attachment = \App\Models\Attachment::factory()->create([
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

    /**
     * @test
     */
    public function show_asset_attachment_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-attachment');

        //create a person, create a fake attachment for that person, see if you can display the attachment
        $asset = \App\Models\Asset::factory()->create();
        $file_name = $this->faker->isbn10().'.pdf';
        $file = UploadedFile::fake()->create($file_name)->storeAs('asset/'.$asset->id.'/attachments', $file_name);
        $description = 'Random Attachment for '.$asset->name;

        $attachment = \App\Models\Attachment::factory()->create([
            'mime_type' => 'application/pdf',
            'description' => $description,
            'upload_date' => $this->faker->dateTime('now'),
            'entity' => 'asset',
            'entity_id' => $asset->id,
            'file_type_id' => config('polanco.file_type.asset_attachment'),
            'uri' => $file_name,
        ]);

        $response = $this->actingAs($user)->get(route('show_asset_attachment', ['asset_id' => $asset->id, 'file_name' => $file_name]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function create_returns_back_with_flash_response()
    {
        $user = $this->createUserWithPermission('create-attachment');

        $response = $this->actingAs($user)->from(URL('attachment'))->get(route('attachment.create'));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(route('attachment.index'));
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-attachment');
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => '1',
            'subcontact_type' => '0',
        ]);
        $attachment = \App\Models\Attachment::factory()->create([
            'uri' => $this->faker->word().'.pdf',
            'entity_id' => $contact->id,
            'entity' => 'contact',
        ]);

        $response = $this->actingAs($user)->from(URL('attachment'))->delete(route('attachment.destroy', [$attachment]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(route('attachment.index'));
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-attachment');
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => '1',
            'subcontact_type' => '0',
        ]);
        $attachment = \App\Models\Attachment::factory()->create([
            'uri' => $this->faker->word().'.pdf',
            'description' => $this->faker->sentence(),
            'entity_id' => $contact->id,
            'entity' => 'contact',
        ]);

        $response = $this->actingAs($user)->get(route('attachment.edit', [$attachment]));

        $response->assertOk();
        $response->assertViewIs('attachments.edit');
        $response->assertViewHas('attachment');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('description', $attachment->description, 'textarea', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-attachment');

        $response = $this->actingAs($user)->get(route('attachment.index'));

        $response->assertOk();
        $response->assertViewIs('attachments.index');
        $response->assertViewHas('attachments');
        $response->assertSeeText('Attachments');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-attachment');
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => '1',
            'subcontact_type' => '0',
        ]);
        $attachment = \App\Models\Attachment::factory()->create([
            'uri' => $this->faker->word().'.pdf',
            'description' => $this->faker->sentence(),
            'entity_id' => $contact->id,
            'entity' => 'contact',
        ]);

        $response = $this->actingAs($user)->get(route('attachment.show', [$attachment]));

        $response->assertOk();
        $response->assertViewIs('attachments.show');
        $response->assertViewHas('attachment');
        $response->assertSeeText('Attachment details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-attachment');

        $attachment_uri = $this->faker->word().'.pdf';
        $attachment_description = $this->faker->sentence(7, true);

        $response = $this->actingAs($user)->from(URL('attachment'))->post(route('attachment.store'), [
            'uri' => $attachment_uri,
            'description' => $attachment_description,
        ]);
        // $response->assertSessionHas('flash_notification');
        $response->assertRedirect(route('attachment.index'));
        // $response->assertSeeText('Attachments');
        // $response->assertSeeText('Storing attachment');
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-attachment');
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => '1',
            'subcontact_type' => '0',
        ]);

        $attachment_uri = $this->faker->word().'.pdf';
        $attachment_description = $this->faker->sentence(7, true);

        $attachment = \App\Models\Attachment::factory()->create([
            'uri' => $attachment_uri,
            'description' => $attachment_description,
            'entity_id' => $contact->id,
            'entity' => 'contact',
        ]);

        $new_attachment_description = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('attachment.update', [$attachment]), [
            'id' => $attachment->id,
            'description' => $new_attachment_description,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AttachmentController::class, 'show'], $attachment->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\Models\Attachment::findOrFail($attachment->id);

        $this->assertEquals($updated->description, $new_attachment_description);
        $this->assertNotEquals($updated->description, $attachment_description);
    }
}
