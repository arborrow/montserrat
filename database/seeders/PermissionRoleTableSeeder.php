<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->delete();

        DB::table('permission_role')->insert([
            0 => [
                'permission_id' => 1,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            1 => [
                'permission_id' => 2,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            2 => [
                'permission_id' => 2,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            3 => [
                'permission_id' => 2,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            4 => [
                'permission_id' => 2,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            5 => [
                'permission_id' => 2,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            6 => [
                'permission_id' => 7,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            7 => [
                'permission_id' => 7,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            8 => [
                'permission_id' => 8,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            9 => [
                'permission_id' => 8,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            10 => [
                'permission_id' => 8,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            11 => [
                'permission_id' => 8,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            12 => [
                'permission_id' => 9,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            13 => [
                'permission_id' => 9,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            14 => [
                'permission_id' => 11,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            15 => [
                'permission_id' => 11,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            16 => [
                'permission_id' => 11,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            17 => [
                'permission_id' => 11,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            18 => [
                'permission_id' => 11,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            19 => [
                'permission_id' => 11,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            20 => [
                'permission_id' => 11,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            21 => [
                'permission_id' => 13,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            22 => [
                'permission_id' => 13,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            23 => [
                'permission_id' => 13,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            24 => [
                'permission_id' => 13,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            25 => [
                'permission_id' => 14,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            26 => [
                'permission_id' => 14,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            27 => [
                'permission_id' => 15,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            28 => [
                'permission_id' => 15,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            29 => [
                'permission_id' => 15,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            30 => [
                'permission_id' => 15,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            31 => [
                'permission_id' => 16,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            32 => [
                'permission_id' => 16,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            33 => [
                'permission_id' => 17,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            34 => [
                'permission_id' => 17,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            35 => [
                'permission_id' => 18,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            36 => [
                'permission_id' => 18,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            37 => [
                'permission_id' => 19,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            38 => [
                'permission_id' => 20,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            39 => [
                'permission_id' => 20,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            40 => [
                'permission_id' => 21,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            41 => [
                'permission_id' => 21,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            42 => [
                'permission_id' => 21,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            43 => [
                'permission_id' => 21,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            44 => [
                'permission_id' => 21,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            45 => [
                'permission_id' => 22,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            46 => [
                'permission_id' => 22,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            47 => [
                'permission_id' => 25,
                'role_id' => 1,
                'deleted_at' => null,
            ],
            48 => [
                'permission_id' => 26,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            49 => [
                'permission_id' => 26,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            50 => [
                'permission_id' => 26,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            51 => [
                'permission_id' => 26,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            52 => [
                'permission_id' => 26,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            53 => [
                'permission_id' => 26,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            54 => [
                'permission_id' => 26,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            55 => [
                'permission_id' => 27,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            56 => [
                'permission_id' => 27,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            57 => [
                'permission_id' => 27,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            58 => [
                'permission_id' => 27,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            59 => [
                'permission_id' => 28,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            60 => [
                'permission_id' => 28,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            61 => [
                'permission_id' => 28,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            62 => [
                'permission_id' => 28,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            63 => [
                'permission_id' => 28,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            64 => [
                'permission_id' => 29,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            65 => [
                'permission_id' => 29,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            66 => [
                'permission_id' => 29,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            67 => [
                'permission_id' => 29,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            68 => [
                'permission_id' => 29,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            69 => [
                'permission_id' => 29,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            70 => [
                'permission_id' => 30,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            71 => [
                'permission_id' => 30,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            72 => [
                'permission_id' => 33,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            73 => [
                'permission_id' => 33,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            74 => [
                'permission_id' => 33,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            75 => [
                'permission_id' => 33,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            76 => [
                'permission_id' => 33,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            77 => [
                'permission_id' => 43,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            78 => [
                'permission_id' => 43,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            79 => [
                'permission_id' => 43,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            80 => [
                'permission_id' => 43,
                'role_id' => 5,
                'deleted_at' => null,
            ],
            81 => [
                'permission_id' => 43,
                'role_id' => 6,
                'deleted_at' => null,
            ],
            82 => [
                'permission_id' => 43,
                'role_id' => 7,
                'deleted_at' => null,
            ],
            83 => [
                'permission_id' => 43,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            84 => [
                'permission_id' => 43,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            85 => [
                'permission_id' => 43,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            86 => [
                'permission_id' => 43,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            87 => [
                'permission_id' => 44,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            88 => [
                'permission_id' => 45,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            89 => [
                'permission_id' => 45,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            90 => [
                'permission_id' => 45,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            91 => [
                'permission_id' => 45,
                'role_id' => 7,
                'deleted_at' => null,
            ],
            92 => [
                'permission_id' => 45,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            93 => [
                'permission_id' => 45,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            94 => [
                'permission_id' => 45,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            95 => [
                'permission_id' => 45,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            96 => [
                'permission_id' => 49,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            97 => [
                'permission_id' => 49,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            98 => [
                'permission_id' => 49,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            99 => [
                'permission_id' => 49,
                'role_id' => 7,
                'deleted_at' => null,
            ],
            100 => [
                'permission_id' => 49,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            101 => [
                'permission_id' => 49,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            102 => [
                'permission_id' => 49,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            103 => [
                'permission_id' => 49,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            104 => [
                'permission_id' => 52,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            105 => [
                'permission_id' => 52,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            106 => [
                'permission_id' => 52,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            107 => [
                'permission_id' => 52,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            108 => [
                'permission_id' => 53,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            109 => [
                'permission_id' => 54,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            110 => [
                'permission_id' => 54,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            111 => [
                'permission_id' => 54,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            112 => [
                'permission_id' => 54,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            113 => [
                'permission_id' => 54,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            114 => [
                'permission_id' => 54,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            115 => [
                'permission_id' => 54,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            116 => [
                'permission_id' => 55,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            117 => [
                'permission_id' => 55,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            118 => [
                'permission_id' => 56,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            119 => [
                'permission_id' => 56,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            120 => [
                'permission_id' => 56,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            121 => [
                'permission_id' => 56,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            122 => [
                'permission_id' => 56,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            123 => [
                'permission_id' => 56,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            124 => [
                'permission_id' => 57,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            125 => [
                'permission_id' => 57,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            126 => [
                'permission_id' => 57,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            127 => [
                'permission_id' => 57,
                'role_id' => 6,
                'deleted_at' => null,
            ],
            128 => [
                'permission_id' => 57,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            129 => [
                'permission_id' => 57,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            130 => [
                'permission_id' => 57,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            131 => [
                'permission_id' => 57,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            132 => [
                'permission_id' => 59,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            133 => [
                'permission_id' => 59,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            134 => [
                'permission_id' => 59,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            135 => [
                'permission_id' => 60,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            136 => [
                'permission_id' => 60,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            137 => [
                'permission_id' => 60,
                'role_id' => 4,
                'deleted_at' => null,
            ],
            138 => [
                'permission_id' => 60,
                'role_id' => 6,
                'deleted_at' => null,
            ],
            139 => [
                'permission_id' => 60,
                'role_id' => 7,
                'deleted_at' => null,
            ],
            140 => [
                'permission_id' => 60,
                'role_id' => 9,
                'deleted_at' => null,
            ],
            141 => [
                'permission_id' => 60,
                'role_id' => 10,
                'deleted_at' => null,
            ],
            142 => [
                'permission_id' => 60,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            143 => [
                'permission_id' => 60,
                'role_id' => 13,
                'deleted_at' => null,
            ],
            144 => [
                'permission_id' => 61,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            145 => [
                'permission_id' => 61,
                'role_id' => 3,
                'deleted_at' => null,
            ],
            146 => [
                'permission_id' => 61,
                'role_id' => 11,
                'deleted_at' => null,
            ],
            147 => [
                'permission_id' => 62,
                'role_id' => 2,
                'deleted_at' => null,
            ],
            148 => [
                'permission_id' => 64,
                'role_id' => 11,
                'deleted_at' => null,
            ],
        ]);
    }
}
