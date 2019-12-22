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
        // manually create some roles where more than one permission is required

        $role = \App\Role::create([
          'name' => 'test-role:' . 'finance_reconcile_deposit_show',
          'display_name' => 'test-role:' .'finance_reconcile_deposit_show',
          'description' => 'Test role with permissions: ' .'finance_reconcile_deposit_show',
        ]);
        $permission = \App\Permission::whereName('show-donation')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Permission::whereName('show-registration')->first();
        $role->givePermissionTo($permission);

        /**
         * PageController retreatantinforeport
         * Permissions: show-contact, show-registration
         */
        $role = \App\Role::create([
          'name' => 'test-role:' . 'retreatantinforeport',
          'display_name' => 'test-role:' .'retreatantinforeport',
          'description' => 'Test role with permissions: ' .'retreatantinforeport',
        ]);
        $permission = \App\Permission::whereName('show-contact')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Permission::whereName('show-registration')->first();
        $role->givePermissionTo($permission);
    }
}
