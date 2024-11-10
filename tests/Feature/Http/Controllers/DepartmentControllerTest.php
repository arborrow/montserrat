<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DepartmentController
 */
class DepartmentControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    #[Test]
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-department');

        $response = $this->actingAs($user)->get(route('department.create'));

        $response->assertOk();
        $response->assertViewIs('admin.departments.create');
        $response->assertSeeText('Create department');
        $response->assertViewHas('parents');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-department');
        $department = \App\Models\Department::factory()->create();

        $response = $this->actingAs($user)->delete(route('department.destroy', [$department]));
        $response->assertSessionHas('flash_notification');

        $response->assertRedirect(action([\App\Http\Controllers\DepartmentController::class, 'index']));
        $this->assertSoftDeleted($department);
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-department');
        $department = \App\Models\Department::factory()->create();

        $response = $this->actingAs($user)->get(route('department.edit', [$department]));

        $response->assertOk();
        $response->assertViewIs('admin.departments.edit');
        $response->assertViewHas('department');
        $response->assertViewHas('parents');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('name', $department->name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('label', $department->label, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $department->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('notes', $department->notes, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('parent_id', $department->parent_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_active', $department->is_active, 'checkbox', $response->getContent()));
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-department');

        $response = $this->actingAs($user)->get(route('department.index'));

        $response->assertOk();
        $response->assertViewIs('admin.departments.index');
        $response->assertViewHas('departments');
        $response->assertSeeText('Departments');
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-department');
        $department = \App\Models\Department::factory()->create();

        $response = $this->actingAs($user)->get(route('department.show', [$department]));

        $response->assertOk();
        $response->assertViewIs('admin.departments.show');
        $response->assertViewHas('department');
        $response->assertViewHas('children');
        $response->assertSeeText('Department details');
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {   // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-department');

        $department_name = $this->faker->word();
        $department_description = $this->faker->sentence(7, true);

        $response = $this->actingAs($user)->post(route('department.store'), [
            'name' => $department_name,
            'label' => $department_name,
            'description' => $department_description,
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\DepartmentController::class, 'index']));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('departments', [
            'name' => $department_name,
            'description' => $department_description,
        ]);
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-department');

        $department = \App\Models\Department::factory()->create();

        $department_name = $this->faker->word();
        $department_description = $this->faker->sentence(7, true);

        $original_department_name = $department->name;
        $new_department_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('department.update', [$department]), [
            'id' => $department->id,
            'name' => $new_department_name,
            'description' => $this->faker->sentence(7, true),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\DepartmentController::class, 'show'], $department->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\Models\Department::findOrFail($department->id);

        $this->assertEquals($updated->name, $new_department_name);
        $this->assertNotEquals($updated->name, $original_department_name);
    }

    // test cases...
}
