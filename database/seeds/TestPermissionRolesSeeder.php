<?php

use Illuminate\Database\Seeder;

class TestPermissionRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \App\Permission::all();

        foreach ($permissions as $permission) {
            $role = \App\Role::create([
                'name' => 'test-role:' . $permission->name,
                'display_name' => 'test-role:' . $permission->name,
                'description' => 'Test role with permission: ' . $permission->name
            ]);
            $role->givePermissionTo($permission);
        }
    }
}
