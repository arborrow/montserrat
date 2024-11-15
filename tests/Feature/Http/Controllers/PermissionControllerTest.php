<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PermissionController
 */
final class PermissionControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    #[Test]
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-permission');

        $response = $this->actingAs($user)->get(route('permission.create'));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.create');
        $response->assertSeeText('Create Permission');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-permission');
        $permission = \App\Models\Permission::factory()->create();

        $response = $this->actingAs($user)->delete(route('permission.destroy', [$permission]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\PermissionController::class, 'index']));
        $this->assertSoftDeleted($permission);
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-permission');
        $permission = \App\Models\Permission::factory()->create();

        $response = $this->actingAs($user)->get(route('permission.edit', [$permission]));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.edit');
        $response->assertViewHas('permission');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $permission->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $permission->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $permission->description, 'text', $response->getContent()));
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-permission');

        $response = $this->actingAs($user)->get(route('permission.index'));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.index');
        $response->assertViewHas('permissions');
        $response->assertViewHas('actions');
        $response->assertViewHas('models');
        $response->assertSeeText('Permissions');
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-permission');
        $permission = \App\Models\Permission::factory()->create();

        $response = $this->actingAs($user)->get(route('permission.show', [$permission]));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.show');
        $response->assertViewHas('permission');
        $response->assertViewHas('roles');
        $response->assertSeeText('Permission details');
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-permission');
        $permission_name = 'New '.$this->faker->words(3, true);
        $permission_display_name = $this->faker->words(4, true);
        $permission_description = $this->faker->sentence(7, true);

        $response = $this->actingAs($user)->post(route('permission.store'), [
            'name' => $permission_name,
            'display_name' => $permission_display_name,
            'description' => $permission_description,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\PermissionController::class, 'index']));
        $this->assertDatabaseHas('permissions', [
            'name' => $permission_name,
            'display_name' => $permission_display_name,
            'description' => $permission_description,
        ]);
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-permission');
        $permission = \App\Models\Permission::factory()->create();
        $original_permission_name = $permission->name;
        $new_permission_name = 'New '.$this->faker->words(3, true);

        $response = $this->actingAs($user)->put(route('permission.update', [$permission]), [
            'id' => $permission->id,
            'name' => $new_permission_name,
            'display_name' => $this->faker->words(4, true),
            'description' => $this->faker->sentence(7, true),
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\PermissionController::class, 'index']));
        $updated = \App\Models\Permission::findOrFail($permission->id);
        $this->assertEquals($updated->name, $new_permission_name);
        $this->assertNotEquals($updated->name, $original_permission_name);
    }

    #[Test]
    public function update_roles_returns_an_ok_response(): void
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole('test-role:update_roles');
        $permission = \App\Models\Permission::factory()->create();
        $random_roles = \App\Models\Role::get()->random(2)->pluck('id');
        // dd($random_roles);
        $response = $this->actingAs($user)->post(route('admin.permission.update_roles'), [
            'id' => $permission->id,
            'roles' => $random_roles,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\PermissionController::class, 'index']));
    }

    // test cases...
}
