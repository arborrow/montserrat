<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permission_role')->delete();
        
        \DB::table('permission_role')->insert(array (
            0 => 
            array (
                'permission_id' => 1,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'permission_id' => 2,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'permission_id' => 2,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'permission_id' => 2,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'permission_id' => 2,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'permission_id' => 2,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'permission_id' => 7,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'permission_id' => 7,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'permission_id' => 8,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'permission_id' => 8,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'permission_id' => 11,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'permission_id' => 11,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'permission_id' => 11,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'permission_id' => 11,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'permission_id' => 11,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'permission_id' => 11,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'permission_id' => 11,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'permission_id' => 13,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'permission_id' => 13,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'permission_id' => 14,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'permission_id' => 15,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'permission_id' => 15,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'permission_id' => 15,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'permission_id' => 19,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'permission_id' => 21,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'permission_id' => 21,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'permission_id' => 21,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'permission_id' => 22,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'permission_id' => 26,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'permission_id' => 26,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'permission_id' => 26,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'permission_id' => 26,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'permission_id' => 26,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'permission_id' => 26,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'permission_id' => 26,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'permission_id' => 27,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'permission_id' => 27,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'permission_id' => 27,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'permission_id' => 27,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'permission_id' => 28,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'permission_id' => 28,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'permission_id' => 28,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'permission_id' => 28,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'permission_id' => 28,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'permission_id' => 29,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'permission_id' => 29,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'permission_id' => 29,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'permission_id' => 29,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            68 => 
            array (
                'permission_id' => 29,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            69 => 
            array (
                'permission_id' => 29,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            70 => 
            array (
                'permission_id' => 30,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            71 => 
            array (
                'permission_id' => 30,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            72 => 
            array (
                'permission_id' => 33,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            73 => 
            array (
                'permission_id' => 33,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            74 => 
            array (
                'permission_id' => 33,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            75 => 
            array (
                'permission_id' => 33,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            76 => 
            array (
                'permission_id' => 33,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            77 => 
            array (
                'permission_id' => 43,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            78 => 
            array (
                'permission_id' => 43,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            79 => 
            array (
                'permission_id' => 43,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            80 => 
            array (
                'permission_id' => 43,
                'role_id' => 5,
                'deleted_at' => NULL,
            ),
            81 => 
            array (
                'permission_id' => 43,
                'role_id' => 6,
                'deleted_at' => NULL,
            ),
            82 => 
            array (
                'permission_id' => 43,
                'role_id' => 7,
                'deleted_at' => NULL,
            ),
            83 => 
            array (
                'permission_id' => 43,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            84 => 
            array (
                'permission_id' => 43,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            85 => 
            array (
                'permission_id' => 43,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            86 => 
            array (
                'permission_id' => 43,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            87 => 
            array (
                'permission_id' => 44,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            88 => 
            array (
                'permission_id' => 45,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            89 => 
            array (
                'permission_id' => 45,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            90 => 
            array (
                'permission_id' => 45,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            91 => 
            array (
                'permission_id' => 45,
                'role_id' => 7,
                'deleted_at' => NULL,
            ),
            92 => 
            array (
                'permission_id' => 45,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            93 => 
            array (
                'permission_id' => 45,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            94 => 
            array (
                'permission_id' => 45,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            95 => 
            array (
                'permission_id' => 45,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            96 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            97 => 
            array (
                'permission_id' => 49,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            98 => 
            array (
                'permission_id' => 49,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            99 => 
            array (
                'permission_id' => 49,
                'role_id' => 7,
                'deleted_at' => NULL,
            ),
            100 => 
            array (
                'permission_id' => 49,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            101 => 
            array (
                'permission_id' => 49,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            102 => 
            array (
                'permission_id' => 49,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            103 => 
            array (
                'permission_id' => 49,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            104 => 
            array (
                'permission_id' => 52,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            105 => 
            array (
                'permission_id' => 52,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            106 => 
            array (
                'permission_id' => 52,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            107 => 
            array (
                'permission_id' => 52,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            108 => 
            array (
                'permission_id' => 53,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            109 => 
            array (
                'permission_id' => 54,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            110 => 
            array (
                'permission_id' => 54,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            111 => 
            array (
                'permission_id' => 54,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            112 => 
            array (
                'permission_id' => 54,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            113 => 
            array (
                'permission_id' => 54,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            114 => 
            array (
                'permission_id' => 54,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            115 => 
            array (
                'permission_id' => 54,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            116 => 
            array (
                'permission_id' => 55,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            117 => 
            array (
                'permission_id' => 55,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            118 => 
            array (
                'permission_id' => 56,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            119 => 
            array (
                'permission_id' => 56,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            120 => 
            array (
                'permission_id' => 56,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            121 => 
            array (
                'permission_id' => 56,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            122 => 
            array (
                'permission_id' => 56,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            123 => 
            array (
                'permission_id' => 56,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            124 => 
            array (
                'permission_id' => 57,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            125 => 
            array (
                'permission_id' => 57,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            126 => 
            array (
                'permission_id' => 57,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            127 => 
            array (
                'permission_id' => 57,
                'role_id' => 6,
                'deleted_at' => NULL,
            ),
            128 => 
            array (
                'permission_id' => 57,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            129 => 
            array (
                'permission_id' => 57,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            130 => 
            array (
                'permission_id' => 57,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            131 => 
            array (
                'permission_id' => 57,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            132 => 
            array (
                'permission_id' => 59,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            133 => 
            array (
                'permission_id' => 59,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            134 => 
            array (
                'permission_id' => 59,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            135 => 
            array (
                'permission_id' => 60,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            136 => 
            array (
                'permission_id' => 60,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            137 => 
            array (
                'permission_id' => 60,
                'role_id' => 4,
                'deleted_at' => NULL,
            ),
            138 => 
            array (
                'permission_id' => 60,
                'role_id' => 6,
                'deleted_at' => NULL,
            ),
            139 => 
            array (
                'permission_id' => 60,
                'role_id' => 7,
                'deleted_at' => NULL,
            ),
            140 => 
            array (
                'permission_id' => 60,
                'role_id' => 9,
                'deleted_at' => NULL,
            ),
            141 => 
            array (
                'permission_id' => 60,
                'role_id' => 10,
                'deleted_at' => NULL,
            ),
            142 => 
            array (
                'permission_id' => 60,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            143 => 
            array (
                'permission_id' => 60,
                'role_id' => 13,
                'deleted_at' => NULL,
            ),
            144 => 
            array (
                'permission_id' => 61,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            145 => 
            array (
                'permission_id' => 61,
                'role_id' => 3,
                'deleted_at' => NULL,
            ),
            146 => 
            array (
                'permission_id' => 61,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
            147 => 
            array (
                'permission_id' => 62,
                'role_id' => 2,
                'deleted_at' => NULL,
            ),
            148 => 
            array (
                'permission_id' => 64,
                'role_id' => 11,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}