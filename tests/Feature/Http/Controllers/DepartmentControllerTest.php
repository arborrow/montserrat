<?php

namespace Tests\Feature\Http\Controllers;

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

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-department');

        $response = $this->actingAs($user)->get(route('department.create'));

        $response->assertOk();
        $response->assertViewIs('admin.departments.create');
        $response->assertSeeText('Create department');
        $response->assertViewHas('parents');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-department');
        $department = \App\Models\Department::factory()->create();

        $response = $this->actingAs($user)->delete(route('department.destroy', [$department]));
        $response->assertSessionHas('flash_notification');

        $response->assertRedirect(action('DepartmentController@index'));
        $this->assertSoftDeleted($department);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
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

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-department');

        $response = $this->actingAs($user)->get(route('department.index'));

        $response->assertOk();
        $response->assertViewIs('admin.departments.index');
        $response->assertViewHas('departments');
        $response->assertSeeText('Departments');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
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

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-department');

        $department_name = $this->faker->word;
        $department_description = $this->faker->sentence(7, true);

        $response = $this->actingAs($user)->post(route('department.store'), [
            'name' => $department_name,
            'label' => $department_name,
            'description' => $department_description,
        ]);

        $response->assertRedirect(action('DepartmentController@index'));
        $response->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('departments', [
            'name' => $department_name,
            'description' => $department_description,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-department');

        $department = \App\Models\Department::factory()->create();

        $department_name = $this->faker->word;
        $department_description = $this->faker->sentence(7, true);

        $original_department_name = $department->name;
        $new_department_name = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('department.update', [$department]), [
            'id' => $department->id,
            'name' => $new_department_name,
            'description' => $this->faker->sentence(7, true),
        ]);

        $response->assertRedirect(action('DepartmentController@show', $department->id));
        $response->assertSessionHas('flash_notification');

        $updated = \App\Models\Department::findOrFail($department->id);

        $this->assertEquals($updated->name, $new_department_name);
        $this->assertNotEquals($updated->name, $original_department_name);
    }

    // test cases...
}
