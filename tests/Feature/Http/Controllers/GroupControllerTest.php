<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
class GroupControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-group');

        $response = $this->actingAs($user)->get(route('group.create'));

        $response->assertOk();
        $response->assertViewIs('groups.create');
        $response->assertSee('Create Group');

    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-group');
        $group = factory(\App\Group::class)->create();

        $response = $this->actingAs($user)->delete(route('group.destroy', [$group]));
        $response->assertSessionHas('flash_notification');

        $response->assertRedirect(action('GroupController@index'));
        $this->assertSoftDeleted($group);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-group');
        $group = factory(\App\Group::class)->create();

        $response = $this->actingAs($user)->get(route('group.edit', [$group]));

        $response->assertOk();
        $response->assertViewIs('groups.edit');
        $response->assertViewHas('group');
        $response->assertSee('Edit Group');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $group->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('title', $group->title, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $group->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $group->is_active, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_hidden', $group->is_hidden, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_reserved', $group->is_reserved, 'checkbox', $response->getContent()));

/*
        {!! Form::text('name', $group->name, ['class' => 'col-md-3']) !!}
        {!! Form::text('title', $group->title, ['class' => 'col-md-3']) !!}
        {!! Form::textarea('description', $group->description, ['class' => 'col-md-3']) !!}
        {!! Form::checkbox('is_active', 1, $group->is_active, ['class' => 'col-md-1']) !!}
        {!! Form::checkbox('is_hidden', 1, $group->is_hidden, ['class' => 'col-md-1']) !!}
        {!! Form::checkbox('is_reserved', 1, $group->is_reserved, ['class' => 'col-md-1']) !!}
*/
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-group');

        $response = $this->actingAs($user)->get(route('group.index'));

        $response->assertOk();
        $response->assertViewIs('groups.index');
        $response->assertViewHas('groups');
        $response->assertSee('Group Index');

    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-group');
        $group = factory(\App\Group::class)->create();

        $response = $this->actingAs($user)->get(route('group.show', [$group]));

        $response->assertOk();
        $response->assertViewIs('groups.show');
        $response->assertViewHas('group');
        $response->assertViewHas('members');
        $response->assertSee($group->description);

    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-group');
        $group_name = ucfirst(implode(' ', $this->faker->words));
        $response = $this->actingAs($user)->post(route('group.store'), [
            'name' => $group_name,
            'title' => Str::plural($group_name),
            'description' => 'New Group of '.Str::plural($group_name),
            'is_active' => '1',
            'is_hidden' => '0',
            'is_reserved' => '0',
        ]);

        $new_group = \App\Group::whereName($group_name)->firstOrFail();
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('GroupController@show', $new_group->id));
        $this->assertDatabaseHas('group', [
          'name' => $group_name,
          'title' => Str::plural($group_name),
          'description' => 'New Group of '.Str::plural($group_name),
        ]);

    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'store',
            \App\Http\Requests\StoreGroupRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-group');
        $group = factory(\App\Group::class)->create();
        $new_group_name = ucfirst($this->faker->unique()->word);

        $response = $this->actingAs($user)->put(route('group.update', [$group]), [
            'name' => $new_group_name,
            'title' => Str::plural($new_group_name),
            'description' => 'Renewed Group of '.Str::plural($new_group_name),
        ]);
        $updated = \App\Group::findOrFail($group->id);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('GroupController@show', $group->id));
        $this->assertEquals($updated->name, $new_group_name);
        $this->assertNotEquals($updated->name, $group->name);

    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'update',
            \App\Http\Requests\UpdateGroupRequest::class
        );
    }

    // test cases...
}
