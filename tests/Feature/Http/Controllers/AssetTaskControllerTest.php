<?php

namespace Tests\Feature\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AssetTaskController
 */
class AssetTaskControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-asset-task');

        $response = $this->actingAs($user)->get(route('asset_task.create'));

        $response->assertOk();
        $response->assertViewIs('asset_tasks.create');
        $response->assertViewHas('assets');
        $response->assertViewHas('frequencies');
        $response->assertViewHas('priorities');
        $response->assertViewHas('vendors');
        $response->assertSeeText('Create asset task');
    }

    /**
     * @test
     */
    public function create_with_asset_task_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-asset-task');
        $asset = \App\Models\Asset::factory()->create();

        $response = $this->actingAs($user)->get('asset_task/create/'.$asset->id);

        $response->assertOk();
        $response->assertViewIs('asset_tasks.create');
        $response->assertViewHas('assets');
        $response->assertViewHas('frequencies');
        $response->assertViewHas('priorities');
        $response->assertViewHas('vendors');
        $response->assertSeeText('Create asset task');
        $response->assertSeeText($asset->name);
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-asset-task');
        $asset_task = \App\Models\AssetTask::factory()->create();

        $response = $this->actingAs($user)->delete(route('asset_task.destroy', [$asset_task]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\AssetTaskController::class, 'index']));
        $this->assertSoftDeleted($asset_task);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-asset-task');
        $asset_task = \App\Models\AssetTask::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_task.edit', [$asset_task]));

        $response->assertOk();
        $response->assertViewIs('asset_tasks.edit');

        $response->assertViewHas('asset_task');
        $response->assertViewHas('assets');
        $response->assertViewHas('vendors');
        $response->assertViewHas('frequencies');
        $response->assertViewHas('priorities');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('asset_id', $asset_task->asset_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('title', $asset_task->title, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('start_date', $asset_task->start_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('scheduled_until_date', $asset_task->scheduled_until_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('frequency_interval', $asset_task->frequency_interval, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('frequency', $asset_task->frequency, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('frequency_month', $asset_task->frequency_month, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('frequency_day', $asset_task->frequency_day, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('frequency_time', $asset_task->frequency_time, 'time', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $asset_task->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('priority_id', $asset_task->priority_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('needed_labor_minutes', $asset_task->needed_labor_minutes, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('estimated_labor_cost', $asset_task->estimated_labor_cost, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('needed_material', $asset_task->needed_material, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('estimated_material_cost', $asset_task->estimated_material_cost, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('vendor_id', $asset_task->vendor_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('category', $asset_task->category, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('tag', $asset_task->tag, 'text', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-asset-task');

        $response = $this->actingAs($user)->get(route('asset_task.index'));

        $response->assertOk();
        $response->assertViewIs('asset_tasks.index');
        $response->assertViewHas('asset_tasks');
        $response->assertSeeText('Asset tasks');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-asset-task');
        $asset_task = \App\Models\AssetTask::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_task.show', [$asset_task]));

        $response->assertOk();
        $response->assertViewIs('asset_tasks.show');
        $response->assertViewHas('asset_task');
        $response->assertSeeText('Asset task details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-asset-task');

        $asset = \App\Models\Asset::factory()->create();

        $title = $this->faker->word();
        $description = $this->faker->sentence(7, true);

        // required by StoreAssetTaskRequest
        $asset_id = $asset->id;
        $frequency = $this->faker->randomElement(config('polanco.asset_task_frequency'));
        $priority_id = $this->faker->randomElement(config('polanco.priority'));
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '-10 days')->getTimeStamp());
        $scheduled_until_date = Carbon::now()->addYear();

        $response = $this->actingAs($user)->post(route('asset_task.store'), [
            'asset_id' => $asset->id,
            'start_date' => $start_date,
            'scheduled_until_date' => $scheduled_until_date,
            'title' => $title,
            'description' => $description,
            'priority_id' => $priority_id,
            'frequency' => $frequency,
            'frequency_interval' => $this->faker->numberBetween(1, 10),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AssetTaskController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('asset_task', [
            'title' => $title,
            'description' => $description,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('update-asset-task');

        $asset_task = \App\Models\AssetTask::factory()->create();

        $title = $this->faker->word();
        $original_title = $asset_task->title;
        $updated_title = 'Updated '.$title;

        $response = $this->actingAs($user)->put(route('asset_task.update', [$asset_task]), [
            'id' => $asset_task->id,
            'asset_id' => $asset_task->asset_id,
            'title' => $updated_title,
            'start_date' => $asset_task->start_date,
            'scheduled_until_date' => $asset_task->scheduled_until_date,
            'frequency' => $asset_task->frequency,
            'frequency_interval' => $this->faker->numberBetween(1, 10),
            'priority_id' => $asset_task->priority_id,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AssetTaskController::class, 'show'], $asset_task->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\Models\AssetTask::findOrFail($asset_task->id);
        $this->assertEquals($updated->title, $updated_title);
        $this->assertNotEquals($updated->title, $original_title);
    }

    /**
     * @test
     */
    public function schedule_jobs_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-asset-task');
        $asset_task = \App\Models\AssetTask::factory()->create();

        $response = $this->actingAs($user)->get(route('asset_tasks.schedule_jobs', [$asset_task]));

        $response->assertRedirect(action([\App\Http\Controllers\AssetTaskController::class, 'show'], $asset_task->id));
        $response->assertSessionHas('flash_notification');
    }

    // test cases...
}
