<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ExportListController
 */
class ExportListControllerTest extends TestCase
{
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-export-list');

        $response = $this->actingAs($user)->get(route('export_list.create'));

        $response->assertOk();
        $response->assertViewIs('admin.export_lists.create');
        $response->assertViewHas('export_list_types');
        $response->assertSeeText('Create export list');
    }

    /**
     * @test

     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-export-list');
        $export_list = factory(\App\ExportList::class)->create();

        $response = $this->actingAs($user)->delete(route('export_list.destroy', [$export_list]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('ExportListController@index'));
        $this->assertSoftDeleted($export_list);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-export-list');
        $export_list = factory(\App\ExportList::class)->create();

        $response = $this->actingAs($user)->get(route('export_list.edit', [$export_list]));

        $response->assertOk();
        $response->assertViewIs('admin.export_lists.edit');
        $response->assertViewHas('export_list');
        $response->assertSeeText('Edit');

//        $this->assertTrue($this->findFieldValueInResponseContent('unit_name', $export_list->unit_name, 'text', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-export-list');

        $response = $this->actingAs($user)->get(route('export_list.index'));

        $response->assertOk();
        $response->assertViewIs('admin.export_lists.index');
        $response->assertSeeText('Export list');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-export-list');
        $export_list = factory(\App\ExportList::class)->create();

        $response = $this->actingAs($user)->get(route('export_list.show', [$export_list]));

        $response->assertOk();
        $response->assertViewIs('admin.export_lists.show');
        $response->assertViewHas('export_list');
        $response->assertSeeText('Export list details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-export-list');

        $export_list_label = $this->faker->word;
        $export_list_title = 'Title of '.$export_list_label;
        $export_list_type = $this->faker->randomElement(config('polanco.export_list_types'));

        $response = $this->actingAs($user)->post(route('export_list.store'), [
            'title' => $export_list_title,
            'label' => $export_list_label,
            'type' => $export_list_type,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('ExportListController@index'));

        $this->assertDatabaseHas('export_list', [
          'title' => $export_list_title,
          'label' => $export_list_label,
          'type' => $export_list_type,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-export-list');

        $export_list = factory(\App\ExportList::class)->create();
        $export_list_type = $this->faker->randomElement(config('polanco.export_list_types'));

        $original_export_list_title = $export_list->title;
        $new_export_list_title = 'New ' . $this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('export_list.update', [$export_list]), [
          'id' => $export_list->id,
          'title' => $new_export_list_title,
          'label' => $export_list->label,
          'type' => $export_list_type,
        ]);

        $response->assertRedirect(action('ExportListController@show', $export_list->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\ExportList::findOrFail($export_list->id);
        $this->assertEquals($updated->title, $new_export_list_title);
        $this->assertNotEquals($updated->title, $original_export_list_title);
    }

    // test cases...
}
