<?php

namespace Tests\Feature\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AssetJobController
 */
class AssetJobControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-asset-job');

        $response = $this->actingAs($user)->get(route('asset_job.create'));

        $response->assertOk();
        $response->assertViewIs('asset_jobs.create');
        $response->assertViewHas('asset_tasks');
        $response->assertViewHas('staff');
        $response->assertViewHas('status');
        $response->assertSeeText('Create asset job');
    }

    /**
     * @test
     */
    public function create_with_asset_task_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-asset-job');
        $asset_task = \App\Models\AssetTask::factory()->create();

        $response = $this->actingAs($user)->get('asset_job/create/'.$asset_task->id);

        $response->assertOk();
        $response->assertViewIs('asset_jobs.create');
        $response->assertViewHas('asset_tasks');
        $response->assertViewHas('staff');
        $response->assertViewHas('status');
        $response->assertSeeText('Create asset job');
        $response->assertSeeText($asset_task->title);
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-asset-job');
        $asset_job = \App\Models\AssetJob::factory()->create();

        $response = $this->actingAs($user)->delete(route('asset_job.destroy', [$asset_job]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\AssetJobController::class, 'index']));
        $this->assertSoftDeleted($asset_job);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('update-asset-job');
        $asset_job = \App\Models\AssetJob::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_job.edit', [$asset_job]));

        $response->assertOk();
        $response->assertViewIs('asset_jobs.edit');

        $response->assertViewHas('asset_job');
        $response->assertViewHas('asset_tasks');
        $response->assertViewHas('staff');
        $response->assertViewHas('status');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('asset_task_id', $asset_job->asset_task_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('assigned_to_id', $asset_job->assigned_to_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('status', $asset_job->status, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('scheduled_date', $asset_job->scheduled_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('start_date', $asset_job->start_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('end_date', $asset_job->end_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('actual_labor', $asset_job->actual_labor, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('actual_labor_cost', $asset_job->actual_labor_cost, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('additional_materials', $asset_job->additional_materials, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('actual_material_cost', $asset_job->actual_material_cost, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note', $asset_job->note, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('tag', $asset_job->tag, 'text', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('show-asset-job');

        $response = $this->actingAs($user)->get(route('asset_job.index'));

        $response->assertOk();
        $response->assertViewIs('asset_jobs.index');
        $response->assertViewHas('asset_jobs');
        $response->assertSeeText('Asset jobs');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-asset-job');
        $asset_job = \App\Models\AssetJob::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_job.show', [$asset_job]));

        $response->assertOk();
        $response->assertViewIs('asset_jobs.show');
        $response->assertViewHas('asset_job');
        $response->assertSeeText('Asset job');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-asset-job');

        // creates a contact as a simulated staff person but does not actually add them to staff group
        $asset_task = \App\Models\AssetTask::factory()->create();
        $staff = \App\Models\Contact::factory()->create();

        // required by StoreAssetJobRequest
        // 'asset_task_id' => 'integer|min:0|exists:asset_task,id|required',
        // 'assigned_to_id' => 'integer|min:0|exists:contact,id|required',
        // 'scheduled_date' => 'date|required',
        // 'status' => 'in:'.implode(',', config('polanco.asset_job_status')).'|required',

        $asset_task_id = $asset_task->id;
        $assigned_to_id = $staff->id;
        $scheduled_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '+6 days', $endDate = '+30 days')->getTimeStamp());
        $status = $this->faker->randomElement(config('polanco.asset_job_status'));

        // TODO:: add start_date, end_date
        // omitting start/end dates for now rather than attempting to calculate based on unknown future validation
        $response = $this->actingAs($user)->post(route('asset_job.store'), [
            'asset_task_id' => $asset_task_id,
            'assigned_to_id' => $assigned_to_id,
            'scheduled_date' => $scheduled_date,
            'status' => $status,
            'actual_labor' => $this->faker->numberBetween(15, 60),
            'actual_labor_cost' => $this->faker->numberBetween(20, 80),
            'additional_materials' => $this->faker->sentence(),
            'actual_material_cost' => $this->faker->numberBetween(10, 20),
            'note' => $this->faker->sentence(),
            'tag' => $this->faker->word(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AssetJobController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('asset_job', [
            'asset_task_id' => $asset_task_id,
            'assigned_to_id' => $assigned_to_id,
            'scheduled_date' => $scheduled_date,
            'status' => $status,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('update-asset-job');

        $asset_job = \App\Models\AssetJob::factory()->create();

        $original_note = $asset_job->note;
        $updated_note = 'Updated '.$original_note;

        $response = $this->actingAs($user)->put(route('asset_job.update', [$asset_job]), [
            'id' => $asset_job->id,
            'asset_task_id' => $asset_job->asset_task_id,
            'assigned_to_id' => $asset_job->assigned_to_id,
            'scheduled_date' => $asset_job->scheduled_date,
            'status' => $asset_job->status,
            'note' => $updated_note,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AssetJobController::class, 'show'], $asset_job->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\Models\AssetJob::findOrFail($asset_job->id);
        $this->assertEquals($updated->note, $updated_note);
        $this->assertNotEquals($updated->note, $original_note);
    }

    // test cases...
}
