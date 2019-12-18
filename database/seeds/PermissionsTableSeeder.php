<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'create-retreat',
                'display_name' => 'Create retreat',
                'description' => 'Create retreat',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-12-26 15:18:58',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'create-contact',
                'display_name' => 'Create contact',
                'description' => 'Create contact',
                'created_at' => '2016-02-11 21:00:00',
                'updated_at' => '2016-12-26 10:11:00',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'create-permission',
                'display_name' => 'Create permission',
                'description' => 'Create permission',
                'created_at' => '2016-02-21 13:13:24',
                'updated_at' => '2016-12-26 15:18:37',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'create-role',
                'display_name' => 'Create role',
                'description' => 'Create role',
                'created_at' => '2016-02-21 13:19:11',
                'updated_at' => '2016-12-26 15:19:13',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'create-dock',
                'display_name' => 'docking',
                'description' => 'The dock is under water',
                'created_at' => '2016-02-21 13:37:13',
                'updated_at' => '2016-02-21 13:37:22',
                'deleted_at' => '2016-02-21 13:37:22',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'delete-contact',
                'display_name' => 'Delete Contact',
                'description' => 'Delete Contact',
                'created_at' => '2016-08-05 11:26:56',
                'updated_at' => '2016-12-25 21:21:47',
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'create-attachment',
                'display_name' => 'Create attachment',
                'description' => 'Create and update attachment',
                'created_at' => '2016-12-25 13:09:49',
                'updated_at' => '2016-12-25 20:48:44',
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'show-attachment',
                'display_name' => 'Show attachment',
                'description' => 'Show attachment',
                'created_at' => '2016-12-25 13:09:49',
                'updated_at' => '2016-12-25 13:09:49',
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'update-attachment',
                'display_name' => 'Update attachment',
                'description' => 'Update attachment',
                'created_at' => '2016-12-25 13:09:49',
                'updated_at' => '2016-12-25 13:09:49',
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'delete-attachment',
                'display_name' => 'Delete attachment',
                'description' => 'Delete attachment',
                'created_at' => '2016-12-25 13:09:49',
                'updated_at' => '2016-12-25 13:09:49',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'show-avatar',
                'display_name' => 'Show avatar',
                'description' => 'Show avatar',
                'created_at' => '2016-12-25 17:16:06',
                'updated_at' => '2016-12-25 17:16:06',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'show-admin-menu',
                'display_name' => 'Show admin menu',
                'description' => 'Show admin menu',
                'created_at' => '2016-12-25 19:31:25',
                'updated_at' => '2016-12-25 19:31:25',
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'show-event-attachment',
                'display_name' => 'Show event attachment',
                'description' => 'Show event attachment',
                'created_at' => '2016-12-25 19:35:18',
                'updated_at' => '2016-12-25 19:35:18',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'show-event-evaluation',
                'display_name' => 'Show event evaluation',
                'description' => 'Show event evaluation',
                'created_at' => '2016-12-25 19:35:42',
                'updated_at' => '2016-12-25 19:35:42',
                'deleted_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'show-event-group-photo',
                'display_name' => 'Show event group photo',
                'description' => 'Show event group photo',
                'created_at' => '2016-12-25 19:36:11',
                'updated_at' => '2016-12-25 19:36:11',
                'deleted_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'create-avatar',
                'display_name' => 'Create avatar',
                'description' => 'Create and update avatar',
                'created_at' => '2016-12-25 20:32:13',
                'updated_at' => '2016-12-25 20:49:04',
                'deleted_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'create-event-contract',
                'display_name' => 'Create event contract',
                'description' => 'Create and update event contract',
                'created_at' => '2016-12-25 20:37:42',
                'updated_at' => '2016-12-25 20:49:16',
                'deleted_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'create-event-schedule',
                'display_name' => 'Create event schedule',
                'description' => 'Create and update event schedule',
                'created_at' => '2016-12-25 20:38:12',
                'updated_at' => '2016-12-25 21:22:17',
                'deleted_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'create-event-evaluation',
                'display_name' => 'Create event evaluation',
                'description' => 'Create and update event evaluation',
                'created_at' => '2016-12-25 20:38:43',
                'updated_at' => '2016-12-25 20:49:50',
                'deleted_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'create-event-group-photo',
                'display_name' => 'Create event group photo',
                'description' => 'Create and update event group photo',
                'created_at' => '2016-12-25 20:39:10',
                'updated_at' => '2016-12-25 20:50:04',
                'deleted_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'show-event-contract',
                'display_name' => 'Show event contract',
                'description' => 'Show event contract',
                'created_at' => '2016-12-25 21:00:11',
                'updated_at' => '2016-12-25 21:00:11',
                'deleted_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'update-retreat',
                'display_name' => 'Update retreat',
                'description' => 'Update retreat',
                'created_at' => '2016-12-25 21:15:04',
                'updated_at' => '2016-12-25 21:15:04',
                'deleted_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'manage-permission',
                'display_name' => 'Manage permission',
                'description' => 'Manage permissions and roles',
                'created_at' => '2016-12-25 22:27:44',
                'updated_at' => '2016-12-25 22:27:44',
                'deleted_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'delete-retreat',
                'display_name' => 'Delete Retreat',
                'description' => 'Delete Retreat',
                'created_at' => '2016-12-26 09:29:12',
                'updated_at' => '2016-12-26 09:29:12',
                'deleted_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'superuser',
                'display_name' => 'Super user',
            'description' => 'Super user permission can do everything (not yet implemented)',
                'created_at' => '2016-12-26 09:51:24',
                'updated_at' => '2016-12-26 09:51:24',
                'deleted_at' => NULL,
            ),
            25 =>
            array (
                'id' => 26,
                'name' => 'show-contact',
                'display_name' => 'Show contact',
                'description' => 'Show contact',
                'created_at' => '2016-12-26 10:11:28',
                'updated_at' => '2016-12-26 10:11:28',
                'deleted_at' => NULL,
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'update-contact',
                'display_name' => 'Update contact',
                'description' => 'Update contact',
                'created_at' => '2016-12-26 10:11:50',
                'updated_at' => '2016-12-26 10:11:50',
                'deleted_at' => NULL,
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'create-touchpoint',
                'display_name' => 'Create touchpoint',
                'description' => 'Create touchpoint',
                'created_at' => '2016-12-26 12:23:05',
                'updated_at' => '2016-12-26 12:23:05',
                'deleted_at' => NULL,
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'show-touchpoint',
                'display_name' => 'Show touchpoint',
                'description' => 'Show touchpoint',
                'created_at' => '2016-12-26 12:23:31',
                'updated_at' => '2016-12-26 12:23:31',
                'deleted_at' => NULL,
            ),
            29 =>
            array (
                'id' => 30,
                'name' => 'update-touchpoint',
                'display_name' => 'Update touchpoint',
                'description' => 'Update touchpoint',
                'created_at' => '2016-12-26 12:23:47',
                'updated_at' => '2016-12-26 12:23:47',
                'deleted_at' => NULL,
            ),
            30 =>
            array (
                'id' => 31,
                'name' => 'delete-touchpoint',
                'display_name' => 'Delete touchpoint',
                'description' => 'Delete touchpoint',
                'created_at' => '2016-12-26 12:24:09',
                'updated_at' => '2016-12-26 12:24:09',
                'deleted_at' => NULL,
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'create-room',
                'display_name' => 'Create room',
                'description' => 'Create room',
                'created_at' => '2016-12-26 12:39:13',
                'updated_at' => '2016-12-26 12:39:13',
                'deleted_at' => NULL,
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'show-room',
                'display_name' => 'Show room',
                'description' => 'Show room',
                'created_at' => '2016-12-26 12:39:27',
                'updated_at' => '2016-12-26 12:39:27',
                'deleted_at' => NULL,
            ),
            33 =>
            array (
                'id' => 34,
                'name' => 'update-room',
                'display_name' => 'Update room',
                'description' => 'Update room',
                'created_at' => '2016-12-26 12:39:41',
                'updated_at' => '2016-12-26 12:39:41',
                'deleted_at' => NULL,
            ),
            34 =>
            array (
                'id' => 35,
                'name' => 'delete-room',
                'display_name' => 'Delete room',
                'description' => 'Delete room',
                'created_at' => '2016-12-26 12:39:55',
                'updated_at' => '2016-12-26 12:39:55',
                'deleted_at' => NULL,
            ),
            35 =>
            array (
                'id' => 36,
                'name' => 'show-permission',
                'display_name' => 'Show permission',
                'description' => 'Show permission',
                'created_at' => '2016-12-26 15:13:17',
                'updated_at' => '2016-12-26 15:13:17',
                'deleted_at' => NULL,
            ),
            36 =>
            array (
                'id' => 37,
                'name' => 'update-permission',
                'display_name' => 'Update permission',
                'description' => 'Update permission',
                'created_at' => '2016-12-26 15:13:31',
                'updated_at' => '2016-12-26 15:13:31',
                'deleted_at' => NULL,
            ),
            37 =>
            array (
                'id' => 38,
                'name' => 'delete-permission',
                'display_name' => 'Delete permission',
                'description' => 'Delete permission',
                'created_at' => '2016-12-26 15:13:47',
                'updated_at' => '2016-12-26 15:13:47',
                'deleted_at' => NULL,
            ),
            38 =>
            array (
                'id' => 39,
                'name' => 'show-role',
                'display_name' => 'Show role',
                'description' => 'Show role',
                'created_at' => '2016-12-26 15:14:09',
                'updated_at' => '2016-12-26 15:14:09',
                'deleted_at' => NULL,
            ),
            39 =>
            array (
                'id' => 40,
                'name' => 'update-role',
                'display_name' => 'Update role',
                'description' => 'Update role',
                'created_at' => '2016-12-26 15:14:30',
                'updated_at' => '2016-12-26 15:14:30',
                'deleted_at' => NULL,
            ),
            40 =>
            array (
                'id' => 41,
                'name' => 'delete-role',
                'display_name' => 'Delete role',
                'description' => 'Delete role',
                'created_at' => '2016-12-26 15:14:49',
                'updated_at' => '2016-12-26 15:14:49',
                'deleted_at' => NULL,
            ),
            41 =>
            array (
                'id' => 42,
                'name' => 'manage-role',
                'display_name' => 'Manage role',
                'description' => 'Manage role',
                'created_at' => '2016-12-26 15:15:01',
                'updated_at' => '2016-12-26 15:15:01',
                'deleted_at' => NULL,
            ),
            42 =>
            array (
                'id' => 43,
                'name' => 'show-retreat',
                'display_name' => 'Show retreat',
                'description' => 'Show retreat',
                'created_at' => '2016-12-26 20:57:12',
                'updated_at' => '2016-12-26 20:57:12',
                'deleted_at' => NULL,
            ),
            43 =>
            array (
                'id' => 44,
                'name' => 'create-group',
                'display_name' => 'Create group',
                'description' => 'Create group',
                'created_at' => '2016-12-29 11:52:10',
                'updated_at' => '2016-12-29 11:52:10',
                'deleted_at' => NULL,
            ),
            44 =>
            array (
                'id' => 45,
                'name' => 'show-group',
                'display_name' => 'Show group',
                'description' => 'Show group',
                'created_at' => '2016-12-29 11:52:27',
                'updated_at' => '2016-12-29 11:52:27',
                'deleted_at' => NULL,
            ),
            45 =>
            array (
                'id' => 46,
                'name' => 'update-group',
                'display_name' => 'Update group',
                'description' => 'Update group',
                'created_at' => '2016-12-29 11:52:40',
                'updated_at' => '2016-12-29 11:52:40',
                'deleted_at' => NULL,
            ),
            46 =>
            array (
                'id' => 47,
                'name' => 'delete-group',
                'display_name' => 'Delete group',
                'description' => 'Delete group',
                'created_at' => '2016-12-29 11:52:52',
                'updated_at' => '2016-12-29 11:52:52',
                'deleted_at' => NULL,
            ),
            47 =>
            array (
                'id' => 48,
                'name' => 'create-relationshiptype',
                'display_name' => 'Create relationship type',
                'description' => 'Create relationship type',
                'created_at' => '2016-12-29 13:31:53',
                'updated_at' => '2016-12-29 13:31:53',
                'deleted_at' => NULL,
            ),
            48 =>
            array (
                'id' => 49,
                'name' => 'show-relationshiptype',
                'display_name' => 'Show relationship type',
                'description' => 'Show relationship type',
                'created_at' => '2016-12-29 13:32:24',
                'updated_at' => '2016-12-29 13:32:24',
                'deleted_at' => NULL,
            ),
            49 =>
            array (
                'id' => 50,
                'name' => 'update-relationshiptype',
                'display_name' => 'Update relationship type',
                'description' => 'Update relationship type',
                'created_at' => '2016-12-29 13:32:40',
                'updated_at' => '2016-12-29 13:32:40',
                'deleted_at' => NULL,
            ),
            50 =>
            array (
                'id' => 51,
                'name' => 'delete-relationshiptype',
                'display_name' => 'Delete relationship type',
                'description' => 'Delete relationship type',
                'created_at' => '2016-12-29 13:33:04',
                'updated_at' => '2016-12-29 13:33:04',
                'deleted_at' => NULL,
            ),
            51 =>
            array (
                'id' => 52,
                'name' => 'create-relationship',
                'display_name' => 'Create relationship',
                'description' => 'Create relationship',
                'created_at' => '2016-12-29 13:33:25',
                'updated_at' => '2016-12-29 13:33:25',
                'deleted_at' => NULL,
            ),
            52 =>
            array (
                'id' => 53,
                'name' => 'delete-relationship',
                'display_name' => 'Delete relationship',
                'description' => 'Delete relationship',
                'created_at' => '2016-12-29 13:33:44',
                'updated_at' => '2016-12-29 13:33:44',
                'deleted_at' => NULL,
            ),
            53 =>
            array (
                'id' => 54,
                'name' => 'show-relationship',
                'display_name' => 'Show relationship',
                'description' => 'Show relationship',
                'created_at' => '2016-12-29 13:34:05',
                'updated_at' => '2016-12-29 13:34:05',
                'deleted_at' => NULL,
            ),
            54 =>
            array (
                'id' => 55,
                'name' => 'update-relationship',
                'display_name' => 'Update relationship',
                'description' => 'Update relationship',
                'created_at' => '2016-12-29 13:34:27',
                'updated_at' => '2016-12-29 13:34:27',
                'deleted_at' => NULL,
            ),
            55 =>
            array (
                'id' => 56,
                'name' => 'create-registration',
                'display_name' => 'Create registration',
                'description' => 'Create registration',
                'created_at' => '2016-12-29 20:00:27',
                'updated_at' => '2016-12-29 20:00:27',
                'deleted_at' => NULL,
            ),
            56 =>
            array (
                'id' => 57,
                'name' => 'show-registration',
                'display_name' => 'Show registration',
                'description' => 'Show registration',
                'created_at' => '2016-12-29 20:01:07',
                'updated_at' => '2016-12-29 20:01:07',
                'deleted_at' => NULL,
            ),
            57 =>
            array (
                'id' => 58,
                'name' => 'delete-registration',
                'display_name' => 'Delete registration',
                'description' => 'Delete registration',
                'created_at' => '2016-12-29 20:01:22',
                'updated_at' => '2016-12-29 20:01:22',
                'deleted_at' => NULL,
            ),
            58 =>
            array (
                'id' => 59,
                'name' => 'update-registration',
                'display_name' => 'Update registration',
                'description' => 'Update registration',
                'created_at' => '2016-12-29 20:02:05',
                'updated_at' => '2016-12-29 20:02:05',
                'deleted_at' => NULL,
            ),
            59 =>
            array (
                'id' => 60,
                'name' => 'show-event-schedule',
                'display_name' => 'Show event schedule',
                'description' => 'Show event schedule',
                'created_at' => '2017-01-03 19:04:54',
                'updated_at' => '2017-01-03 19:26:41',
                'deleted_at' => NULL,
            ),
            60 =>
            array (
                'id' => 61,
                'name' => 'show-donor',
                'display_name' => 'Show donor',
                'description' => '',
                'created_at' => '2017-04-10 13:10:11',
                'updated_at' => '2017-04-10 13:10:11',
                'deleted_at' => NULL,
            ),
            61 =>
            array (
                'id' => 62,
                'name' => 'update-donor',
                'display_name' => 'Update donor',
                'description' => '',
                'created_at' => '2017-04-10 13:10:40',
                'updated_at' => '2017-04-10 13:11:31',
                'deleted_at' => NULL,
            ),
            62 =>
            array (
                'id' => 63,
                'name' => 'create-test',
                'display_name' => 'create-test',
                'description' => 'Testing',
                'created_at' => '2017-05-04 16:58:50',
                'updated_at' => '2017-05-04 16:58:50',
                'deleted_at' => NULL,
            ),
            63 =>
            array (
                'id' => 64,
                'name' => 'show-donation',
                'display_name' => 'Show donation',
                'description' => 'Show donation',
                'created_at' => '2018-04-04 15:06:21',
                'updated_at' => '2018-04-04 15:06:21',
                'deleted_at' => NULL,
            ),
            64 =>
            array (
                'id' => 65,
                'name' => 'create-donation',
                'display_name' => 'Create donation',
                'description' => 'Create donation',
                'created_at' => '2018-04-04 15:06:58',
                'updated_at' => '2018-04-04 15:06:58',
                'deleted_at' => NULL,
            ),
            65 =>
            array (
                'id' => 66,
                'name' => 'delete-donation',
                'display_name' => 'Delete donation',
                'description' => 'Delete donation',
                'created_at' => '2018-04-04 15:07:42',
                'updated_at' => '2018-04-04 15:07:42',
                'deleted_at' => NULL,
            ),
            66 =>
            array (
                'id' => 67,
                'name' => 'update-donation',
                'display_name' => 'Update donation',
                'description' => 'Update donation',
                'created_at' => '2018-04-04 15:07:59',
                'updated_at' => '2018-04-04 15:07:59',
                'deleted_at' => NULL,
            ),
            67 =>
            array (
                'id' => 68,
                'name' => 'create-payment',
                'display_name' => 'create-payment',
                'description' => 'Create payment',
                'created_at' => '2018-10-12 14:52:40',
                'updated_at' => '2018-10-12 14:52:40',
                'deleted_at' => NULL,
            ),
            68 =>
            array (
                'id' => 69,
                'name' => 'show-payment',
                'display_name' => 'show-payment',
                'description' => 'Show payment',
                'created_at' => '2018-10-12 14:52:52',
                'updated_at' => '2018-10-12 14:52:52',
                'deleted_at' => NULL,
            ),
            69 =>
            array (
                'id' => 70,
                'name' => 'update-payment',
                'display_name' => 'update-payment',
                'description' => 'Update payment',
                'created_at' => '2018-10-12 14:53:03',
                'updated_at' => '2018-10-12 14:53:03',
                'deleted_at' => NULL,
            ),
            70 =>
            array (
                'id' => 71,
                'name' => 'delete-payment',
                'display_name' => 'delete-payment',
                'description' => 'Delete payment',
                'created_at' => '2018-10-12 14:53:20',
                'updated_at' => '2018-10-12 14:53:20',
                'deleted_at' => NULL,
            ),
            71 =>
            array (
                'id' => 72,
                'name' => 'show-gate',
                'display_name' => 'Show gate',
                'description' => 'Show main gate control options',
                'created_at' => '2018-12-06 12:53:51',
                'updated_at' => '2018-12-06 12:55:38',
                'deleted_at' => NULL,
            ),
            72 =>
            array (
                'id' => 73,
                'name' => 'admin-mailgun',
                'display_name' => 'Administer mailgun',
                'description' => 'Administer mailgun settings',
                'created_at' => '2018-12-06 12:53:51',
                'updated_at' => '2018-12-06 12:55:38',
                'deleted_at' => NULL,
            )
        ));
    }
}
