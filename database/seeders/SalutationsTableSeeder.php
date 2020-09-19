<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalutationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('salutations')->delete();

        \DB::table('salutations')->insert([
            0 => [
                'Salutation ID' => 1,
                'Salutation Name' => 'Mr.',
            ],
            1 => [
                'Salutation ID' => 2,
                'Salutation Name' => 'Mrs.',
            ],
            2 => [
                'Salutation ID' => 3,
                'Salutation Name' => 'Ms.',
            ],
            3 => [
                'Salutation ID' => 4,
                'Salutation Name' => 'Miss',
            ],
            4 => [
                'Salutation ID' => 5,
                'Salutation Name' => 'Sr.',
            ],
            5 => [
                'Salutation ID' => 6,
                'Salutation Name' => 'Bishop',
            ],
            6 => [
                'Salutation ID' => 7,
                'Salutation Name' => 'Fr.',
            ],
            7 => [
                'Salutation ID' => 8,
                'Salutation Name' => 'Bro.',
            ],
            8 => [
                'Salutation ID' => 9,
                'Salutation Name' => 'Pastor',
            ],
            9 => [
                'Salutation ID' => 10,
                'Salutation Name' => 'Rev.',
            ],
            10 => [
                'Salutation ID' => 11,
                'Salutation Name' => 'Dr.',
            ],
            11 => [
                'Salutation ID' => 12,
                'Salutation Name' => 'Mr. & Mrs.',
            ],
            12 => [
                'Salutation ID' => 13,
                'Salutation Name' => 'Deacon',
            ],
            13 => [
                'Salutation ID' => 14,
                'Salutation Name' => 'Rev. Msgr.',
            ],
            14 => [
                'Salutation ID' => 15,
                'Salutation Name' => 'Dr1.',
            ],
            15 => [
                'Salutation ID' => 16,
                'Salutation Name' => 'The Rev.',
            ],
            16 => [
                'Salutation ID' => 17,
                'Salutation Name' => 'Most Rev.',
            ],
            17 => [
                'Salutation ID' => 18,
                'Salutation Name' => 'Padre',
            ],
            18 => [
                'Salutation ID' => 19,
                'Salutation Name' => 'Father',
            ],
            19 => [
                'Salutation ID' => 20,
                'Salutation Name' => 'Ma.',
            ],
            20 => [
                'Salutation ID' => 21,
                'Salutation Name' => 'Deacon & Mrs.',
            ],
            21 => [
                'Salutation ID' => 1,
                'Salutation Name' => 'Mr.',
            ],
            22 => [
                'Salutation ID' => 2,
                'Salutation Name' => 'Mrs.',
            ],
            23 => [
                'Salutation ID' => 3,
                'Salutation Name' => 'Ms.',
            ],
            24 => [
                'Salutation ID' => 4,
                'Salutation Name' => 'Miss',
            ],
            25 => [
                'Salutation ID' => 5,
                'Salutation Name' => 'Sr.',
            ],
            26 => [
                'Salutation ID' => 6,
                'Salutation Name' => 'Bishop',
            ],
            27 => [
                'Salutation ID' => 7,
                'Salutation Name' => 'Fr.',
            ],
            28 => [
                'Salutation ID' => 8,
                'Salutation Name' => 'Bro.',
            ],
            29 => [
                'Salutation ID' => 9,
                'Salutation Name' => 'Pastor',
            ],
            30 => [
                'Salutation ID' => 10,
                'Salutation Name' => 'Rev.',
            ],
            31 => [
                'Salutation ID' => 11,
                'Salutation Name' => 'Dr.',
            ],
            32 => [
                'Salutation ID' => 12,
                'Salutation Name' => 'Mr. & Mrs.',
            ],
            33 => [
                'Salutation ID' => 13,
                'Salutation Name' => 'Deacon',
            ],
            34 => [
                'Salutation ID' => 14,
                'Salutation Name' => 'Rev. Msgr.',
            ],
            35 => [
                'Salutation ID' => 15,
                'Salutation Name' => 'Dr1.',
            ],
            36 => [
                'Salutation ID' => 16,
                'Salutation Name' => 'The Rev.',
            ],
            37 => [
                'Salutation ID' => 17,
                'Salutation Name' => 'Most Rev.',
            ],
            38 => [
                'Salutation ID' => 18,
                'Salutation Name' => 'Padre',
            ],
            39 => [
                'Salutation ID' => 19,
                'Salutation Name' => 'Father',
            ],
            40 => [
                'Salutation ID' => 20,
                'Salutation Name' => 'Ma.',
            ],
            41 => [
                'Salutation ID' => 21,
                'Salutation Name' => 'Deacon & Mrs.',
            ],
            42 => [
                'Salutation ID' => 1,
                'Salutation Name' => 'Mr.',
            ],
            43 => [
                'Salutation ID' => 2,
                'Salutation Name' => 'Mrs.',
            ],
            44 => [
                'Salutation ID' => 3,
                'Salutation Name' => 'Ms.',
            ],
            45 => [
                'Salutation ID' => 4,
                'Salutation Name' => 'Miss',
            ],
            46 => [
                'Salutation ID' => 5,
                'Salutation Name' => 'Sr.',
            ],
            47 => [
                'Salutation ID' => 6,
                'Salutation Name' => 'Bishop',
            ],
            48 => [
                'Salutation ID' => 7,
                'Salutation Name' => 'Fr.',
            ],
            49 => [
                'Salutation ID' => 8,
                'Salutation Name' => 'Bro.',
            ],
            50 => [
                'Salutation ID' => 9,
                'Salutation Name' => 'Pastor',
            ],
            51 => [
                'Salutation ID' => 10,
                'Salutation Name' => 'Rev.',
            ],
            52 => [
                'Salutation ID' => 11,
                'Salutation Name' => 'Dr.',
            ],
            53 => [
                'Salutation ID' => 12,
                'Salutation Name' => 'Mr. & Mrs.',
            ],
            54 => [
                'Salutation ID' => 13,
                'Salutation Name' => 'Deacon',
            ],
            55 => [
                'Salutation ID' => 14,
                'Salutation Name' => 'Rev. Msgr.',
            ],
            56 => [
                'Salutation ID' => 15,
                'Salutation Name' => 'Dr1.',
            ],
            57 => [
                'Salutation ID' => 16,
                'Salutation Name' => 'The Rev.',
            ],
            58 => [
                'Salutation ID' => 17,
                'Salutation Name' => 'Most Rev.',
            ],
            59 => [
                'Salutation ID' => 18,
                'Salutation Name' => 'Padre',
            ],
            60 => [
                'Salutation ID' => 19,
                'Salutation Name' => 'Father',
            ],
            61 => [
                'Salutation ID' => 20,
                'Salutation Name' => 'Ma.',
            ],
            62 => [
                'Salutation ID' => 21,
                'Salutation Name' => 'Deacon & Mrs.',
            ],
            63 => [
                'Salutation ID' => 1,
                'Salutation Name' => 'Mr.',
            ],
            64 => [
                'Salutation ID' => 2,
                'Salutation Name' => 'Mrs.',
            ],
            65 => [
                'Salutation ID' => 3,
                'Salutation Name' => 'Ms.',
            ],
            66 => [
                'Salutation ID' => 4,
                'Salutation Name' => 'Miss',
            ],
            67 => [
                'Salutation ID' => 5,
                'Salutation Name' => 'Sr.',
            ],
            68 => [
                'Salutation ID' => 6,
                'Salutation Name' => 'Bishop',
            ],
            69 => [
                'Salutation ID' => 7,
                'Salutation Name' => 'Fr.',
            ],
            70 => [
                'Salutation ID' => 8,
                'Salutation Name' => 'Bro.',
            ],
            71 => [
                'Salutation ID' => 9,
                'Salutation Name' => 'Pastor',
            ],
            72 => [
                'Salutation ID' => 10,
                'Salutation Name' => 'Rev.',
            ],
            73 => [
                'Salutation ID' => 11,
                'Salutation Name' => 'Dr.',
            ],
            74 => [
                'Salutation ID' => 12,
                'Salutation Name' => 'Mr. & Mrs.',
            ],
            75 => [
                'Salutation ID' => 13,
                'Salutation Name' => 'Deacon',
            ],
            76 => [
                'Salutation ID' => 14,
                'Salutation Name' => 'Rev. Msgr.',
            ],
            77 => [
                'Salutation ID' => 15,
                'Salutation Name' => 'Dr1.',
            ],
            78 => [
                'Salutation ID' => 16,
                'Salutation Name' => 'The Rev.',
            ],
            79 => [
                'Salutation ID' => 17,
                'Salutation Name' => 'Most Rev.',
            ],
            80 => [
                'Salutation ID' => 18,
                'Salutation Name' => 'Padre',
            ],
            81 => [
                'Salutation ID' => 19,
                'Salutation Name' => 'Father',
            ],
            82 => [
                'Salutation ID' => 20,
                'Salutation Name' => 'Ma.',
            ],
            83 => [
                'Salutation ID' => 21,
                'Salutation Name' => 'Deacon & Mrs.',
            ],
        ]);
    }
}
