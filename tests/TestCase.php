<?php

namespace Tests;

use JMac\Testing\Traits\HttpTestAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, HttpTestAssertions;

    protected function createUserWithPermission(string $permission, array $data = [])
    {
        $reference = \App\Permission::where('name', $permission)->first();
        if (is_null($reference)) {
            throw new \InvalidArgumentException('permission does not exist: ' . $reference);
        }

        $role = \App\Role::where('name', 'test-role:' . $permission)->first();
        if (is_null($role)) {
            throw new \InvalidArgumentException('A test role for the permission (' . $permission. ') does not exist. Did you run the seeder?');
        }

        $user = factory(\App\User::class)->create($data);
        $user->assignRole($role->name);

        return $user;
    }
}
