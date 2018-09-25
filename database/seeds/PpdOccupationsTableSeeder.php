<?php

use Illuminate\Database\Seeder;

class PpdOccupationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ppd_occupations')->delete();
        
        \DB::table('ppd_occupations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Accountant/CPA/Auditor',
                'occ_code' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Account Manager',
                'occ_code' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Actor/Actress',
                'occ_code' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Actuary',
                'occ_code' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Administrative Assistant',
                'occ_code' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Administrator',
                'occ_code' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Advertising',
                'occ_code' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Aeronautics',
                'occ_code' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Aerospace',
                'occ_code' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Agronomist',
                'occ_code' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Air Conditioning',
                'occ_code' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Air Traffic',
                'occ_code' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Aircraft Industry',
                'occ_code' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Airline Industry',
                'occ_code' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Analyst',
                'occ_code' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Anesthesiologist',
                'occ_code' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Anthropologist',
                'occ_code' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Apartment Industry',
                'occ_code' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Architecture',
                'occ_code' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Artist',
                'occ_code' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Astronomer',
                'occ_code' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Athletics',
                'occ_code' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Auto Mechanic',
                'occ_code' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Baker',
                'occ_code' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Banking',
                'occ_code' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Barber',
                'occ_code' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Bartender',
                'occ_code' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Biologist',
                'occ_code' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Blacksmith',
                'occ_code' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Bookkeeping',
                'occ_code' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Bricklayer',
                'occ_code' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Building Inspector',
                'occ_code' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Bus Driver',
                'occ_code' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Meat Cutter',
                'occ_code' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Cable Industry',
                'occ_code' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Caregiver',
                'occ_code' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Carpentry',
                'occ_code' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Carpet Industry',
                'occ_code' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Cashier',
                'occ_code' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Catering',
                'occ_code' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Cattle',
                'occ_code' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Chaplain',
                'occ_code' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Chauffeur',
                'occ_code' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Chef',
                'occ_code' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Chemical Engineer',
                'occ_code' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Chemist',
                'occ_code' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Childcare',
                'occ_code' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Chiropractor',
                'occ_code' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'City Management',
                'occ_code' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Civil Engineer',
                'occ_code' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Civil Service',
                'occ_code' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Claims Adjuster',
                'occ_code' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Cleaning Service',
                'occ_code' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Clergy',
                'occ_code' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Clerk',
                'occ_code' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Collections',
                'occ_code' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'College Professor',
                'occ_code' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Communications',
                'occ_code' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Computer Programmer/Analyst',
                'occ_code' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Construction Industry',
                'occ_code' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Consultant',
                'occ_code' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Cook',
                'occ_code' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Cosmetologist',
                'occ_code' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Counseling',
                'occ_code' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Credit Manager',
                'occ_code' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Customer Services',
                'occ_code' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Customs',
                'occ_code' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Dairy',
                'occ_code' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Data Processing',
                'occ_code' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Deacon',
                'occ_code' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Decorator',
                'occ_code' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Dental',
                'occ_code' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Dentist',
                'occ_code' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Detective',
                'occ_code' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Dietitian',
                'occ_code' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Disabled',
                'occ_code' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Dispatcher',
                'occ_code' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Draftsman',
                'occ_code' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Driver',
                'occ_code' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Dry Cleaning',
                'occ_code' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Economist',
                'occ_code' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Editor',
                'occ_code' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Education',
                'occ_code' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Electrical Engineer',
                'occ_code' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Electrician',
                'occ_code' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Executive',
                'occ_code' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Executive Assistant',
                'occ_code' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Farming',
                'occ_code' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Floral Industry',
                'occ_code' => NULL,
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Fireman',
                'occ_code' => NULL,
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'Food Industry',
                'occ_code' => NULL,
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'Forestry',
                'occ_code' => NULL,
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'Funeral Industry',
                'occ_code' => NULL,
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Furrier',
                'occ_code' => NULL,
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Geologist',
                'occ_code' => NULL,
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Grocery',
                'occ_code' => NULL,
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Hair Stylist',
                'occ_code' => NULL,
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Health & Welfare',
                'occ_code' => NULL,
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Homemaker',
                'occ_code' => NULL,
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'Hotel Industry',
                'occ_code' => NULL,
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Industrial Engineer',
                'occ_code' => NULL,
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'Inspector',
                'occ_code' => NULL,
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'Insurance',
                'occ_code' => NULL,
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Interior Design',
                'occ_code' => NULL,
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Internal Revenue Service',
                'occ_code' => NULL,
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Inventory',
                'occ_code' => NULL,
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Investments',
                'occ_code' => NULL,
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'Jeweler',
                'occ_code' => NULL,
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'Journalist/Reporter',
                'occ_code' => NULL,
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Laborer',
                'occ_code' => NULL,
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Landscaping',
                'occ_code' => NULL,
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Law Enforcement',
                'occ_code' => NULL,
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'Legal Assistant',
                'occ_code' => NULL,
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Librarian',
                'occ_code' => NULL,
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Locksmith',
                'occ_code' => NULL,
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Machinist',
                'occ_code' => NULL,
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'Maid',
                'occ_code' => NULL,
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'Mailing Service',
                'occ_code' => NULL,
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'Maintenance',
                'occ_code' => NULL,
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'Marketing',
                'occ_code' => NULL,
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'Massage',
                'occ_code' => NULL,
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'Mathematician/Statistician',
                'occ_code' => NULL,
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'Mechanical Engineer',
                'occ_code' => NULL,
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'Medical',
                'occ_code' => NULL,
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'Metallurgical Engineer',
                'occ_code' => NULL,
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'Meter Reader',
                'occ_code' => NULL,
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Meterologist',
                'occ_code' => NULL,
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Military',
                'occ_code' => NULL,
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'Miner',
                'occ_code' => NULL,
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'Minister',
                'occ_code' => NULL,
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'Musician',
                'occ_code' => NULL,
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'Newspaper Industry',
                'occ_code' => NULL,
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'No Work Code Available',
                'occ_code' => NULL,
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'Nuclear Industry',
                'occ_code' => NULL,
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'Nursery/Horticulture',
                'occ_code' => NULL,
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'Office Manager',
                'occ_code' => NULL,
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'Oil & Gas Industry',
                'occ_code' => NULL,
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'Optician',
                'occ_code' => NULL,
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'Optometrist',
                'occ_code' => NULL,
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'Owner Business',
                'occ_code' => NULL,
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'Painter',
                'occ_code' => NULL,
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'Paralegal',
                'occ_code' => NULL,
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'Pathologist',
                'occ_code' => NULL,
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'Personnel/Human Resources',
                'occ_code' => NULL,
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'Pharmacist',
                'occ_code' => NULL,
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'Photography',
                'occ_code' => NULL,
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'Physical Therapist',
                'occ_code' => NULL,
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'Physician',
                'occ_code' => NULL,
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'Physicist',
                'occ_code' => NULL,
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'Physiologist',
                'occ_code' => NULL,
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'Pilot',
                'occ_code' => NULL,
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'Plumber',
                'occ_code' => NULL,
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'Podiatrist',
                'occ_code' => NULL,
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'Police Officer',
                'occ_code' => NULL,
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'Postal Service',
                'occ_code' => NULL,
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'Priest',
                'occ_code' => NULL,
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'Printing',
                'occ_code' => NULL,
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'Nurse',
                'occ_code' => NULL,
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'Psychiatrist',
                'occ_code' => NULL,
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'Psychologist',
                'occ_code' => NULL,
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'Psychotherapist',
                'occ_code' => NULL,
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'Purchasing',
                'occ_code' => NULL,
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'Radio/Television',
                'occ_code' => NULL,
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'Railroad',
                'occ_code' => NULL,
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'Real Estate',
                'occ_code' => NULL,
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'Registered Nurse',
                'occ_code' => NULL,
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'Retail',
                'occ_code' => NULL,
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'Retired',
                'occ_code' => NULL,
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'Roofing',
                'occ_code' => NULL,
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'Sailor',
                'occ_code' => NULL,
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'Sales',
                'occ_code' => NULL,
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'School',
                'occ_code' => NULL,
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'Secretary',
                'occ_code' => NULL,
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'Security',
                'occ_code' => NULL,
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'Self Employed',
                'occ_code' => NULL,
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'Shipping/Receiving',
                'occ_code' => NULL,
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'Social Work',
                'occ_code' => NULL,
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'Speech',
                'occ_code' => NULL,
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'Stockbroker',
                'occ_code' => NULL,
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'Student',
                'occ_code' => NULL,
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'Surgeon',
                'occ_code' => NULL,
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'Tailor',
                'occ_code' => NULL,
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'Teaching',
                'occ_code' => NULL,
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'Telecommunications',
                'occ_code' => NULL,
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'Telemarketing',
                'occ_code' => NULL,
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'Telephone',
                'occ_code' => NULL,
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'Teller',
                'occ_code' => NULL,
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'Therapist',
                'occ_code' => NULL,
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'Transportation',
                'occ_code' => NULL,
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'Unemployed',
                'occ_code' => NULL,
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'Upholsterer',
                'occ_code' => NULL,
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'Utilities',
                'occ_code' => NULL,
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'Waitress',
                'occ_code' => NULL,
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'Warehouse Operations',
                'occ_code' => NULL,
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'Welder',
                'occ_code' => NULL,
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'Writer',
                'occ_code' => NULL,
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'Zoologist',
                'occ_code' => NULL,
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'Financial',
                'occ_code' => NULL,
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'Investigator',
                'occ_code' => NULL,
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'Clerical',
                'occ_code' => NULL,
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'Accounting',
                'occ_code' => NULL,
            ),
            201 => 
            array (
                'id' => 203,
                'name' => 'Assistant Director',
                'occ_code' => NULL,
            ),
            202 => 
            array (
                'id' => 204,
                'name' => 'Attorney',
                'occ_code' => NULL,
            ),
            203 => 
            array (
                'id' => 205,
                'name' => 'Engineer',
                'occ_code' => NULL,
            ),
            204 => 
            array (
                'id' => 206,
                'name' => 'CFO',
                'occ_code' => NULL,
            ),
            205 => 
            array (
                'id' => 207,
                'name' => 'Volunteer',
                'occ_code' => NULL,
            ),
            206 => 
            array (
                'id' => 208,
                'name' => 'Manager',
                'occ_code' => NULL,
            ),
            207 => 
            array (
                'id' => 209,
                'name' => 'Health Care',
                'occ_code' => NULL,
            ),
            208 => 
            array (
                'id' => 210,
                'name' => 'Audiologist',
                'occ_code' => NULL,
            ),
            209 => 
            array (
                'id' => 211,
                'name' => 'Property Management',
                'occ_code' => NULL,
            ),
            210 => 
            array (
                'id' => 212,
                'name' => 'Temporary',
                'occ_code' => NULL,
            ),
            211 => 
            array (
                'id' => 213,
                'name' => 'Government',
                'occ_code' => NULL,
            ),
            212 => 
            array (
                'id' => 214,
                'name' => 'Provost',
                'occ_code' => NULL,
            ),
            213 => 
            array (
                'id' => 215,
                'name' => 'Contractor',
                'occ_code' => NULL,
            ),
            214 => 
            array (
                'id' => 216,
                'name' => 'Nanny',
                'occ_code' => NULL,
            ),
            215 => 
            array (
                'id' => 217,
                'name' => 'Travel Agent',
                'occ_code' => NULL,
            ),
            216 => 
            array (
                'id' => 218,
                'name' => 'Pediatrician',
                'occ_code' => NULL,
            ),
            217 => 
            array (
                'id' => 219,
                'name' => 'Ophthalmologist',
                'occ_code' => NULL,
            ),
            218 => 
            array (
                'id' => 220,
                'name' => 'Veterinarian',
                'occ_code' => NULL,
            ),
            219 => 
            array (
                'id' => 221,
                'name' => 'Assembly',
                'occ_code' => NULL,
            ),
            220 => 
            array (
                'id' => 222,
                'name' => 'Receptionist',
                'occ_code' => NULL,
            ),
            221 => 
            array (
                'id' => 223,
                'name' => 'Scheduler',
                'occ_code' => NULL,
            ),
            222 => 
            array (
                'id' => 224,
                'name' => 'Interpreter',
                'occ_code' => NULL,
            ),
            223 => 
            array (
                'id' => 225,
                'name' => 'Training',
                'occ_code' => NULL,
            ),
            224 => 
            array (
                'id' => 226,
                'name' => 'Systems Analyst',
                'occ_code' => NULL,
            ),
            225 => 
            array (
                'id' => 227,
                'name' => 'Public Relations',
                'occ_code' => NULL,
            ),
            226 => 
            array (
                'id' => 228,
                'name' => 'Mechanic',
                'occ_code' => NULL,
            ),
            227 => 
            array (
                'id' => 229,
                'name' => 'Freight',
                'occ_code' => NULL,
            ),
            228 => 
            array (
                'id' => 230,
                'name' => 'Pastor',
                'occ_code' => NULL,
            ),
            229 => 
            array (
                'id' => 231,
                'name' => 'School Crossing Guard',
                'occ_code' => NULL,
            ),
            230 => 
            array (
                'id' => 232,
                'name' => 'Microbiologist',
                'occ_code' => NULL,
            ),
            231 => 
            array (
                'id' => 233,
                'name' => 'Copywriter',
                'occ_code' => NULL,
            ),
            232 => 
            array (
                'id' => 234,
                'name' => 'Seminary',
                'occ_code' => NULL,
            ),
            233 => 
            array (
                'id' => 235,
                'name' => 'Tool & Die',
                'occ_code' => NULL,
            ),
            234 => 
            array (
                'id' => 236,
                'name' => 'Manicurist',
                'occ_code' => NULL,
            ),
            235 => 
            array (
                'id' => 237,
                'name' => 'Probation Officer',
                'occ_code' => NULL,
            ),
            236 => 
            array (
                'id' => 238,
                'name' => 'Evangelist',
                'occ_code' => NULL,
            ),
            237 => 
            array (
                'id' => 239,
                'name' => 'Translator',
                'occ_code' => NULL,
            ),
            238 => 
            array (
                'id' => 240,
                'name' => 'Missionary',
                'occ_code' => NULL,
            ),
            239 => 
            array (
                'id' => 241,
                'name' => 'Pastoral Associate',
                'occ_code' => NULL,
            ),
            240 => 
            array (
                'id' => 242,
                'name' => 'Flight Attendant',
                'occ_code' => NULL,
            ),
            241 => 
            array (
                'id' => 243,
                'name' => 'Research',
                'occ_code' => NULL,
            ),
            242 => 
            array (
                'id' => 244,
                'name' => 'Transcriptionist',
                'occ_code' => NULL,
            ),
            243 => 
            array (
                'id' => 245,
                'name' => 'Restaurant Management',
                'occ_code' => NULL,
            ),
            244 => 
            array (
                'id' => 246,
                'name' => 'Auto Dealership',
                'occ_code' => NULL,
            ),
            245 => 
            array (
                'id' => 247,
                'name' => 'Spiritual Director',
                'occ_code' => NULL,
            ),
            246 => 
            array (
                'id' => 248,
                'name' => 'Music Director',
                'occ_code' => NULL,
            ),
            247 => 
            array (
                'id' => 249,
                'name' => 'Youth Minister',
                'occ_code' => NULL,
            ),
            248 => 
            array (
                'id' => 250,
                'name' => 'Manufacturing',
                'occ_code' => NULL,
            ),
            249 => 
            array (
                'id' => 251,
                'name' => 'Liturgist',
                'occ_code' => NULL,
            ),
            250 => 
            array (
                'id' => 252,
                'name' => 'Media',
                'occ_code' => NULL,
            ),
            251 => 
            array (
                'id' => 253,
                'name' => 'Distribution',
                'occ_code' => NULL,
            ),
            252 => 
            array (
                'id' => 254,
                'name' => 'Recruiting',
                'occ_code' => NULL,
            ),
            253 => 
            array (
                'id' => 255,
                'name' => 'Computer Industry',
                'occ_code' => NULL,
            ),
            254 => 
            array (
                'id' => 256,
                'name' => 'High Tech Industry',
                'occ_code' => NULL,
            ),
            255 => 
            array (
                'id' => 257,
                'name' => 'Radiology',
                'occ_code' => NULL,
            ),
            256 => 
            array (
                'id' => 258,
                'name' => 'Linguist',
                'occ_code' => NULL,
            ),
            257 => 
            array (
                'id' => 259,
                'name' => 'Judge',
                'occ_code' => NULL,
            ),
            258 => 
            array (
                'id' => 260,
                'name' => 'Ski Instructor',
                'occ_code' => NULL,
            ),
            259 => 
            array (
                'id' => 261,
                'name' => 'Graphic Arts/Designer',
                'occ_code' => NULL,
            ),
            260 => 
            array (
                'id' => 262,
                'name' => 'Health & Fitness',
                'occ_code' => NULL,
            ),
            261 => 
            array (
                'id' => 263,
                'name' => 'Tech',
                'occ_code' => NULL,
            ),
            262 => 
            array (
                'id' => 264,
                'name' => 'Buyer/Asst. Buyer',
                'occ_code' => NULL,
            ),
            263 => 
            array (
                'id' => 265,
                'name' => 'Custodian',
                'occ_code' => NULL,
            ),
            264 => 
            array (
                'id' => 266,
                'name' => 'Ranching',
                'occ_code' => NULL,
            ),
            265 => 
            array (
                'id' => 267,
                'name' => 'Designer',
                'occ_code' => NULL,
            ),
            266 => 
            array (
                'id' => 268,
                'name' => 'News Reporter',
                'occ_code' => NULL,
            ),
            267 => 
            array (
                'id' => 269,
                'name' => 'Programming',
                'occ_code' => NULL,
            ),
            268 => 
            array (
                'id' => 270,
                'name' => 'Arbitrator/Mediator',
                'occ_code' => NULL,
            ),
            269 => 
            array (
                'id' => 271,
                'name' => 'Principal',
                'occ_code' => NULL,
            ),
            270 => 
            array (
                'id' => 272,
                'name' => 'Musician',
                'occ_code' => NULL,
            ),
            271 => 
            array (
                'id' => 273,
                'name' => 'Inventor',
                'occ_code' => NULL,
            ),
            272 => 
            array (
                'id' => 274,
                'name' => 'Parole Officer',
                'occ_code' => NULL,
            ),
            273 => 
            array (
                'id' => 275,
                'name' => 'Auditor',
                'occ_code' => NULL,
            ),
            274 => 
            array (
                'id' => 276,
                'name' => 'Loan Processing',
                'occ_code' => NULL,
            ),
            275 => 
            array (
                'id' => 277,
                'name' => 'Home Builder',
                'occ_code' => NULL,
            ),
            276 => 
            array (
                'id' => 278,
                'name' => 'Software Engineer',
                'occ_code' => NULL,
            ),
            277 => 
            array (
                'id' => 279,
                'name' => 'Glazer',
                'occ_code' => NULL,
            ),
            278 => 
            array (
                'id' => 280,
                'name' => 'Internet Industry',
                'occ_code' => NULL,
            ),
            279 => 
            array (
                'id' => 281,
                'name' => 'Phlebotomist',
                'occ_code' => NULL,
            ),
            280 => 
            array (
                'id' => 282,
                'name' => 'Systems Engineer',
                'occ_code' => NULL,
            ),
            281 => 
            array (
                'id' => 283,
                'name' => 'Golf Pro',
                'occ_code' => NULL,
            ),
            282 => 
            array (
                'id' => 284,
                'name' => 'Paramedic',
                'occ_code' => NULL,
            ),
            283 => 
            array (
                'id' => 285,
                'name' => 'Forensics',
                'occ_code' => NULL,
            ),
            284 => 
            array (
                'id' => 286,
                'name' => 'Pharmacy Tech',
                'occ_code' => NULL,
            ),
            285 => 
            array (
                'id' => 287,
                'name' => 'Farrier',
                'occ_code' => NULL,
            ),
            286 => 
            array (
                'id' => 288,
                'name' => 'Lithographer',
                'occ_code' => NULL,
            ),
            287 => 
            array (
                'id' => 289,
                'name' => 'Document Control',
                'occ_code' => NULL,
            ),
            288 => 
            array (
                'id' => 290,
                'name' => 'Zoo Keeper',
                'occ_code' => NULL,
            ),
            289 => 
            array (
                'id' => 291,
                'name' => 'Ministry',
                'occ_code' => NULL,
            ),
            290 => 
            array (
                'id' => 292,
                'name' => 'Student Ministry',
                'occ_code' => NULL,
            ),
            291 => 
            array (
                'id' => 293,
                'name' => 'Truck Driver',
                'occ_code' => NULL,
            ),
            292 => 
            array (
                'id' => 294,
                'name' => 'Scientist',
                'occ_code' => NULL,
            ),
            293 => 
            array (
                'id' => 295,
                'name' => 'Builder',
                'occ_code' => NULL,
            ),
            294 => 
            array (
                'id' => 296,
                'name' => 'Veterinary Assistant',
                'occ_code' => NULL,
            ),
            295 => 
            array (
                'id' => 297,
                'name' => 'Episcopal Priest',
                'occ_code' => NULL,
            ),
            296 => 
            array (
                'id' => 298,
                'name' => 'Legal Secretary',
                'occ_code' => NULL,
            ),
            297 => 
            array (
                'id' => 299,
                'name' => 'Mover',
                'occ_code' => NULL,
            ),
            298 => 
            array (
                'id' => 300,
                'name' => 'Underwriter',
                'occ_code' => NULL,
            ),
            299 => 
            array (
                'id' => 301,
                'name' => 'Bartender',
                'occ_code' => NULL,
            ),
            300 => 
            array (
                'id' => 302,
                'name' => 'Reporter',
                'occ_code' => NULL,
            ),
            301 => 
            array (
                'id' => 303,
                'name' => 'Horticulturist',
                'occ_code' => NULL,
            ),
            302 => 
            array (
                'id' => 304,
                'name' => 'Guide',
                'occ_code' => NULL,
            ),
            303 => 
            array (
                'id' => 305,
                'name' => 'Power Development',
                'occ_code' => NULL,
            ),
            304 => 
            array (
                'id' => 306,
                'name' => 'Appraiser',
                'occ_code' => NULL,
            ),
            305 => 
            array (
                'id' => 307,
                'name' => 'Director Adult Formation',
                'occ_code' => NULL,
            ),
            306 => 
            array (
                'id' => 308,
                'name' => 'DRE',
                'occ_code' => NULL,
            ),
            307 => 
            array (
                'id' => 309,
                'name' => 'Hispanic Ministry Coordinator',
                'occ_code' => NULL,
            ),
            308 => 
            array (
                'id' => 310,
                'name' => 'Director of Religious Education',
                'occ_code' => NULL,
            ),
            309 => 
            array (
                'id' => 311,
                'name' => 'Meteorologist',
                'occ_code' => NULL,
            ),
            310 => 
            array (
                'id' => 312,
                'name' => 'Human Resources',
                'occ_code' => NULL,
            ),
            311 => 
            array (
                'id' => 313,
                'name' => 'Braillist',
                'occ_code' => NULL,
            ),
            312 => 
            array (
                'id' => 314,
                'name' => 'Director Adult Education',
                'occ_code' => NULL,
            ),
            313 => 
            array (
                'id' => 315,
                'name' => 'Quality Control',
                'occ_code' => NULL,
            ),
            314 => 
            array (
                'id' => 316,
                'name' => 'Speech Pathologist',
                'occ_code' => NULL,
            ),
            315 => 
            array (
                'id' => 317,
                'name' => 'Leasing Consultant',
                'occ_code' => NULL,
            ),
            316 => 
            array (
                'id' => 318,
                'name' => 'Chief Financial Officer',
                'occ_code' => NULL,
            ),
            317 => 
            array (
                'id' => 319,
                'name' => 'TV Producer',
                'occ_code' => NULL,
            ),
            318 => 
            array (
                'id' => 320,
                'name' => 'Neuropsychologist',
                'occ_code' => NULL,
            ),
            319 => 
            array (
                'id' => 321,
                'name' => 'Fiduciary',
                'occ_code' => NULL,
            ),
            320 => 
            array (
                'id' => 322,
                'name' => 'Trader',
                'occ_code' => NULL,
            ),
            321 => 
            array (
                'id' => 323,
                'name' => 'Oral Surgeon',
                'occ_code' => NULL,
            ),
            322 => 
            array (
                'id' => 324,
                'name' => 'Grant Writer',
                'occ_code' => NULL,
            ),
            323 => 
            array (
                'id' => 325,
                'name' => 'Marine Science',
                'occ_code' => NULL,
            ),
            324 => 
            array (
                'id' => 326,
                'name' => 'House Cleaning',
                'occ_code' => NULL,
            ),
            325 => 
            array (
                'id' => 327,
                'name' => 'Pest Control',
                'occ_code' => NULL,
            ),
            326 => 
            array (
                'id' => 328,
                'name' => 'Sister',
                'occ_code' => NULL,
            ),
            327 => 
            array (
                'id' => 329,
                'name' => 'Fine Arts',
                'occ_code' => NULL,
            ),
            328 => 
            array (
                'id' => 330,
                'name' => 'Court Reporter',
                'occ_code' => NULL,
            ),
            329 => 
            array (
                'id' => 331,
                'name' => 'Nutrition Specialist',
                'occ_code' => NULL,
            ),
            330 => 
            array (
                'id' => 332,
                'name' => 'Esthetician',
                'occ_code' => NULL,
            ),
            331 => 
            array (
                'id' => 333,
                'name' => 'Sports Related',
                'occ_code' => NULL,
            ),
        ));
        
        
    }
}