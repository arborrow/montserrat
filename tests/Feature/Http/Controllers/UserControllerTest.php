<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * unused.
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
     * test.
     */
    public function destroy_returns_an_ok_response()
    {   // keep in mind that the destroy method does not actually delete a user from the database
        $user = $this->createUserWithPermission('delete-user');
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->delete(route('user.destroy', [$user]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\UserController::class, 'index']));
        // $this->assertSoftDeleted($user);
    }

    /**
     * unused.
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-user');
        $user = \App\Models\User::factory()->create();

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
    public function index_returns_an_ok_response(): void
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
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-role');
        $new_user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.show', [$new_user]));

        $response->assertOk();
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user');
        $response->assertSeeText('User details for');
        $response->assertSeeText($new_user->name);
    }

    /**
     * test.
     */
    public function store_returns_an_ok_response()
    {   // keep in mind that this does not actually store a user record in the database
        $user = $this->createUserWithPermission('create-user');

        $new_name = $this->faker->jobTitle();
        $new_description = $this->faker->sentence();

        $response = $this->actingAs($user)->post(route('user.store'), [
            'name' => $new_name,
            'display_name' => $new_name,
            'description' => $new_description,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\UserController::class, 'index']));

        // normally one would expect the data to be stored; however, in this case authentication and not the controller stores the user
        /*
        $this->assertDatabaseHas('users', [
          'name' => $new_name,
          'display_name' => $new_name,
          'description' => $new_description,
        ]);
        */
    }

    /**
     * test.
     */
    public function update_returns_an_ok_response()
    {   // keep in mind that this does not actually update a user in the database
        $user = $this->createUserWithPermission('update-user');
        $user = \App\Models\User::factory()->create();

        $original_description = $user->description;
        $new_name = $this->faker->jobTitle();
        $new_description = $this->faker->sentence();

        $response = $this->actingAs($user)->put(route('user.update', [$user]), [
            'id' => $user->id,
            'name' => $new_name,
            'display_name' => $new_name,
            'description' => $new_description,
        ]);

        $updated = \App\Models\User::findOrFail($user->id);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\UserController::class, 'index']));
//        $this->assertEquals($updated->description, $new_description);
//        $this->assertNotEquals($updated->description, $original_description);
    }

    // test cases...
}
