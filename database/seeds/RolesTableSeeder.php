<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        \DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Can see and do everything',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-02-11 21:00:00',
                'deleted_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Can see and do almost everything',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-02-11 21:00:00',
                'deleted_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'employee',
                'display_name' => 'Employee',
                'description' => 'Can see and do essential tasks',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-02-11 21:00:00',
                'deleted_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'captain',
                'display_name' => 'Captian',
                'description' => 'Can perform captain related duties',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-02-11 21:00:00',
                'deleted_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'guest',
                'display_name' => 'Guest',
                'description' => 'Can view public information',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-02-11 21:00:00',
                'deleted_at' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'retreatant',
                'display_name' => 'Retreatant',
                'description' => 'Can view public information and information about self',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-02-11 21:00:00',
                'deleted_at' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'grantwriter',
                'display_name' => 'Grant writer',
                'description' => 'Has more access to general report information',
                'created_at' => '2016-02-21 13:47:27',
                'updated_at' => '2016-02-21 13:52:33',
                'deleted_at' => null,
            ],
            7 => [
                'id' => 9,
                'name' => 'tester',
                'display_name' => 'General tester',
                'description' => 'Generic test account',
                'created_at' => '2016-02-21 13:48:56',
                'updated_at' => '2016-02-21 13:48:56',
                'deleted_at' => null,
            ],
            8 => [
                'id' => 10,
                'name' => 'Volunteer',
                'display_name' => 'Volunteer',
                'description' => 'Volunteer',
                'created_at' => '2016-12-26 08:56:37',
                'updated_at' => '2016-12-26 08:56:37',
                'deleted_at' => null,
            ],
            9 => [
                'id' => 11,
                'name' => 'jesuit',
                'display_name' => 'Jesuit',
                'description' => 'Jesuit',
                'created_at' => '2016-12-28 08:37:24',
                'updated_at' => '2016-12-28 08:37:24',
                'deleted_at' => null,
            ],
            10 => [
                'id' => 12,
                'name' => 'Slug',
                'display_name' => 'Slug',
                'description' => 'Slugs',
                'created_at' => '2017-05-04 17:13:36',
                'updated_at' => '2017-05-04 17:14:32',
                'deleted_at' => '2017-05-04 17:14:32',
            ],
            11 => [
                'id' => 13,
                'name' => 'board',
                'display_name' => 'Board Members',
                'description' => 'Montserrat Jesuit Retreat House Board Members',
                'created_at' => '2017-12-30 18:40:51',
                'updated_at' => '2017-12-30 18:41:32',
                'deleted_at' => null,
            ],
        ]);
    }
}
