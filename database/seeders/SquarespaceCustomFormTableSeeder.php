<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SquarespaceCustomFormTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     */
    public function run(): void
    {
        \DB::table('squarespace_custom_form')->delete();

        \DB::table('squarespace_custom_form')->insert([
            0 => [
                'id' => 1,
                'name' => 'Retreat Registration Form',
                'created_at' => '2022-05-01 18:48:20',
                'updated_at' => '2022-05-01 19:11:18',
                'deleted_at' => '2022-05-01 19:11:18',
            ],
            1 => [
                'id' => 2,
                'name' => 'Retreat Registration Form',
                'created_at' => '2022-05-01 19:16:15',
                'updated_at' => '2022-05-02 08:25:46',
                'deleted_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Men\'s Retreat',
                'created_at' => '2022-05-02 15:59:46',
                'updated_at' => '2022-05-02 16:00:40',
                'deleted_at' => '2022-05-02 16:00:40',
            ],
            3 => [
                'id' => 4,
                'name' => 'Retiro Abierto (Hombres, Mujeres, y Parejas)',
                'created_at' => '2022-05-02 16:04:25',
                'updated_at' => '2022-05-27 16:29:19',
                'deleted_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Open Retreat (Men, Women, and Couples)',
                'created_at' => '2022-05-02 16:16:57',
                'updated_at' => '2022-05-21 09:45:18',
                'deleted_at' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'Special Event',
                'created_at' => '2022-05-02 16:17:27',
                'updated_at' => '2022-05-02 16:17:27',
                'deleted_at' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'Gift Certificate Purchase',
                'created_at' => '2022-05-02 16:18:06',
                'updated_at' => '2022-05-15 13:41:50',
                'deleted_at' => null,
            ],
            7 => [
                'id' => 8,
                'name' => 'Young Adults Registration Form',
                'created_at' => '2022-05-02 16:18:33',
                'updated_at' => '2022-05-02 16:18:33',
                'deleted_at' => '2022-05-01 07:04:49',
            ],
            8 => [
                'id' => 9,
                'name' => 'Gift Certificate Registration',
                'created_at' => '2022-05-15 13:40:17',
                'updated_at' => '2022-05-15 13:40:17',
                'deleted_at' => null,
            ],
            9 => [
                'id' => 10,
                'name' => 'Registro de Certificado de Regalo',
                'created_at' => '2022-05-15 13:59:36',
                'updated_at' => '2022-05-15 19:31:28',
                'deleted_at' => null,
            ],
        ]);
    }
}
