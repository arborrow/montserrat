<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    use WithFaker;

    /**
     * unused
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-user');

        $response = $this->actingAs($user)->get(route('user.create'));

        $response->assertOk();
        $response->assertViewIs('admin.users.create');
        $response->assertSeeText('Create User');
    }

    /**
     * unused
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-user');
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->delete(route('user.destroy', [$user]));

        $response->assertRedirect(action('UserController@index'));
        $this->assertSoftDeleted($user);
    }

    /**
     * unused
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-user');
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get(route('user.edit', [$user]));

        $response->assertOk();
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $user->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $user->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $user->description, 'text', $response->getContent()));

    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-role');

        $response = $this->actingAs($user)->get(route('user.index'));

        $response->assertOk();
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
        $response->assertSeeText('Index of Users');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-role');
        $new_user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get(route('user.show', [$new_user]));

        $response->assertOk();
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user');
        $response->assertSeeText('User details for');
        $response->assertSeeText($new_user->name);
    }

    /**
     * unused
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-user');

        $new_name = $this->faker->jobTitle;
        $new_description = $this->faker->sentence;

        $response = $this->actingAs($user)->post(route('user.store'), [
          'name' => $new_name,
          'display_name' => $new_name,
          'description' => $new_description,
        ]);

        $response->assertRedirect(action('UserController@index'));
        $this->assertDatabaseHas('users', [
          'name' => $new_name,
          'display_name' => $new_name,
          'description' => $new_description,
        ]);
    }

    /**
     * unused
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-user');
        $user = factory(\App\User::class)->create();

        $original_description = $user->description;
        $new_name = $this->faker->jobTitle;
        $new_description = $this->faker->sentence;

        $response = $this->actingAs($user)->put(route('user.update', [$user]), [
            'id'  => $user->id,
            'name' => $new_name,
            'display_name' => $new_name,
            'description' => $new_description,
        ]);

        $updated = \App\User::findOrFail($user->id);

        $response->assertRedirect(action('UserController@index'));
        $this->assertEquals($updated->description, $new_description);
        $this->assertNotEquals($updated->description, $original_description);
    }


    // test cases...
}
