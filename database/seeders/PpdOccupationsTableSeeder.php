<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PpdOccupationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ppd_occupations')->delete();

        \DB::table('ppd_occupations')->insert([
            0 => [
                'id' => 1,
                'name' => 'Accountant/CPA/Auditor',
                'occ_code' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Account Manager',
                'occ_code' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Actor/Actress',
                'occ_code' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'Actuary',
                'occ_code' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Administrative Assistant',
                'occ_code' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'Administrator',
                'occ_code' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'Advertising',
                'occ_code' => null,
            ],
            7 => [
                'id' => 8,
                'name' => 'Aeronautics',
                'occ_code' => null,
            ],
            8 => [
                'id' => 9,
                'name' => 'Aerospace',
                'occ_code' => null,
            ],
            9 => [
                'id' => 10,
                'name' => 'Agronomist',
                'occ_code' => null,
            ],
            10 => [
                'id' => 11,
                'name' => 'Air Conditioning',
                'occ_code' => null,
            ],
            11 => [
                'id' => 12,
                'name' => 'Air Traffic',
                'occ_code' => null,
            ],
            12 => [
                'id' => 13,
                'name' => 'Aircraft Industry',
                'occ_code' => null,
            ],
            13 => [
                'id' => 14,
                'name' => 'Airline Industry',
                'occ_code' => null,
            ],
            14 => [
                'id' => 15,
                'name' => 'Analyst',
                'occ_code' => null,
            ],
            15 => [
                'id' => 16,
                'name' => 'Anesthesiologist',
                'occ_code' => null,
            ],
            16 => [
                'id' => 17,
                'name' => 'Anthropologist',
                'occ_code' => null,
            ],
            17 => [
                'id' => 18,
                'name' => 'Apartment Industry',
                'occ_code' => null,
            ],
            18 => [
                'id' => 19,
                'name' => 'Architecture',
                'occ_code' => null,
            ],
            19 => [
                'id' => 20,
                'name' => 'Artist',
                'occ_code' => null,
            ],
            20 => [
                'id' => 21,
                'name' => 'Astronomer',
                'occ_code' => null,
            ],
            21 => [
                'id' => 22,
                'name' => 'Athletics',
                'occ_code' => null,
            ],
            22 => [
                'id' => 23,
                'name' => 'Auto Mechanic',
                'occ_code' => null,
            ],
            23 => [
                'id' => 24,
                'name' => 'Baker',
                'occ_code' => null,
            ],
            24 => [
                'id' => 25,
                'name' => 'Banking',
                'occ_code' => null,
            ],
            25 => [
                'id' => 26,
                'name' => 'Barber',
                'occ_code' => null,
            ],
            26 => [
                'id' => 27,
                'name' => 'Bartender',
                'occ_code' => null,
            ],
            27 => [
                'id' => 28,
                'name' => 'Biologist',
                'occ_code' => null,
            ],
            28 => [
                'id' => 29,
                'name' => 'Blacksmith',
                'occ_code' => null,
            ],
            29 => [
                'id' => 30,
                'name' => 'Bookkeeping',
                'occ_code' => null,
            ],
            30 => [
                'id' => 31,
                'name' => 'Bricklayer',
                'occ_code' => null,
            ],
            31 => [
                'id' => 32,
                'name' => 'Building Inspector',
                'occ_code' => null,
            ],
            32 => [
                'id' => 33,
                'name' => 'Bus Driver',
                'occ_code' => null,
            ],
            33 => [
                'id' => 34,
                'name' => 'Meat Cutter',
                'occ_code' => null,
            ],
            34 => [
                'id' => 35,
                'name' => 'Cable Industry',
                'occ_code' => null,
            ],
            35 => [
                'id' => 36,
                'name' => 'Caregiver',
                'occ_code' => null,
            ],
            36 => [
                'id' => 37,
                'name' => 'Carpentry',
                'occ_code' => null,
            ],
            37 => [
                'id' => 38,
                'name' => 'Carpet Industry',
                'occ_code' => null,
            ],
            38 => [
                'id' => 39,
                'name' => 'Cashier',
                'occ_code' => null,
            ],
            39 => [
                'id' => 40,
                'name' => 'Catering',
                'occ_code' => null,
            ],
            40 => [
                'id' => 41,
                'name' => 'Cattle',
                'occ_code' => null,
            ],
            41 => [
                'id' => 42,
                'name' => 'Chaplain',
                'occ_code' => null,
            ],
            42 => [
                'id' => 43,
                'name' => 'Chauffeur',
                'occ_code' => null,
            ],
            43 => [
                'id' => 44,
                'name' => 'Chef',
                'occ_code' => null,
            ],
            44 => [
                'id' => 45,
                'name' => 'Chemical Engineer',
                'occ_code' => null,
            ],
            45 => [
                'id' => 46,
                'name' => 'Chemist',
                'occ_code' => null,
            ],
            46 => [
                'id' => 47,
                'name' => 'Childcare',
                'occ_code' => null,
            ],
            47 => [
                'id' => 48,
                'name' => 'Chiropractor',
                'occ_code' => null,
            ],
            48 => [
                'id' => 49,
                'name' => 'City Management',
                'occ_code' => null,
            ],
            49 => [
                'id' => 50,
                'name' => 'Civil Engineer',
                'occ_code' => null,
            ],
            50 => [
                'id' => 51,
                'name' => 'Civil Service',
                'occ_code' => null,
            ],
            51 => [
                'id' => 52,
                'name' => 'Claims Adjuster',
                'occ_code' => null,
            ],
            52 => [
                'id' => 53,
                'name' => 'Cleaning Service',
                'occ_code' => null,
            ],
            53 => [
                'id' => 54,
                'name' => 'Clergy',
                'occ_code' => null,
            ],
            54 => [
                'id' => 55,
                'name' => 'Clerk',
                'occ_code' => null,
            ],
            55 => [
                'id' => 56,
                'name' => 'Collections',
                'occ_code' => null,
            ],
            56 => [
                'id' => 57,
                'name' => 'College Professor',
                'occ_code' => null,
            ],
            57 => [
                'id' => 58,
                'name' => 'Communications',
                'occ_code' => null,
            ],
            58 => [
                'id' => 59,
                'name' => 'Computer Programmer/Analyst',
                'occ_code' => null,
            ],
            59 => [
                'id' => 60,
                'name' => 'Construction Industry',
                'occ_code' => null,
            ],
            60 => [
                'id' => 61,
                'name' => 'Consultant',
                'occ_code' => null,
            ],
            61 => [
                'id' => 62,
                'name' => 'Cook',
                'occ_code' => null,
            ],
            62 => [
                'id' => 63,
                'name' => 'Cosmetologist',
                'occ_code' => null,
            ],
            63 => [
                'id' => 64,
                'name' => 'Counseling',
                'occ_code' => null,
            ],
            64 => [
                'id' => 65,
                'name' => 'Credit Manager',
                'occ_code' => null,
            ],
            65 => [
                'id' => 66,
                'name' => 'Customer Services',
                'occ_code' => null,
            ],
            66 => [
                'id' => 67,
                'name' => 'Customs',
                'occ_code' => null,
            ],
            67 => [
                'id' => 68,
                'name' => 'Dairy',
                'occ_code' => null,
            ],
            68 => [
                'id' => 69,
                'name' => 'Data Processing',
                'occ_code' => null,
            ],
            69 => [
                'id' => 70,
                'name' => 'Deacon',
                'occ_code' => null,
            ],
            70 => [
                'id' => 71,
                'name' => 'Decorator',
                'occ_code' => null,
            ],
            71 => [
                'id' => 72,
                'name' => 'Dental',
                'occ_code' => null,
            ],
            72 => [
                'id' => 73,
                'name' => 'Dentist',
                'occ_code' => null,
            ],
            73 => [
                'id' => 74,
                'name' => 'Detective',
                'occ_code' => null,
            ],
            74 => [
                'id' => 75,
                'name' => 'Dietitian',
                'occ_code' => null,
            ],
            75 => [
                'id' => 76,
                'name' => 'Disabled',
                'occ_code' => null,
            ],
            76 => [
                'id' => 77,
                'name' => 'Dispatcher',
                'occ_code' => null,
            ],
            77 => [
                'id' => 78,
                'name' => 'Draftsman',
                'occ_code' => null,
            ],
            78 => [
                'id' => 79,
                'name' => 'Driver',
                'occ_code' => null,
            ],
            79 => [
                'id' => 80,
                'name' => 'Dry Cleaning',
                'occ_code' => null,
            ],
            80 => [
                'id' => 81,
                'name' => 'Economist',
                'occ_code' => null,
            ],
            81 => [
                'id' => 82,
                'name' => 'Editor',
                'occ_code' => null,
            ],
            82 => [
                'id' => 83,
                'name' => 'Education',
                'occ_code' => null,
            ],
            83 => [
                'id' => 84,
                'name' => 'Electrical Engineer',
                'occ_code' => null,
            ],
            84 => [
                'id' => 85,
                'name' => 'Electrician',
                'occ_code' => null,
            ],
            85 => [
                'id' => 86,
                'name' => 'Executive',
                'occ_code' => null,
            ],
            86 => [
                'id' => 87,
                'name' => 'Executive Assistant',
                'occ_code' => null,
            ],
            87 => [
                'id' => 88,
                'name' => 'Farming',
                'occ_code' => null,
            ],
            88 => [
                'id' => 89,
                'name' => 'Floral Industry',
                'occ_code' => null,
            ],
            89 => [
                'id' => 90,
                'name' => 'Fireman',
                'occ_code' => null,
            ],
            90 => [
                'id' => 91,
                'name' => 'Food Industry',
                'occ_code' => null,
            ],
            91 => [
                'id' => 92,
                'name' => 'Forestry',
                'occ_code' => null,
            ],
            92 => [
                'id' => 93,
                'name' => 'Funeral Industry',
                'occ_code' => null,
            ],
            93 => [
                'id' => 94,
                'name' => 'Furrier',
                'occ_code' => null,
            ],
            94 => [
                'id' => 95,
                'name' => 'Geologist',
                'occ_code' => null,
            ],
            95 => [
                'id' => 96,
                'name' => 'Grocery',
                'occ_code' => null,
            ],
            96 => [
                'id' => 97,
                'name' => 'Hair Stylist',
                'occ_code' => null,
            ],
            97 => [
                'id' => 98,
                'name' => 'Health & Welfare',
                'occ_code' => null,
            ],
            98 => [
                'id' => 99,
                'name' => 'Homemaker',
                'occ_code' => null,
            ],
            99 => [
                'id' => 100,
                'name' => 'Hotel Industry',
                'occ_code' => null,
            ],
            100 => [
                'id' => 101,
                'name' => 'Industrial Engineer',
                'occ_code' => null,
            ],
            101 => [
                'id' => 102,
                'name' => 'Inspector',
                'occ_code' => null,
            ],
            102 => [
                'id' => 103,
                'name' => 'Insurance',
                'occ_code' => null,
            ],
            103 => [
                'id' => 104,
                'name' => 'Interior Design',
                'occ_code' => null,
            ],
            104 => [
                'id' => 105,
                'name' => 'Internal Revenue Service',
                'occ_code' => null,
            ],
            105 => [
                'id' => 106,
                'name' => 'Inventory',
                'occ_code' => null,
            ],
            106 => [
                'id' => 107,
                'name' => 'Investments',
                'occ_code' => null,
            ],
            107 => [
                'id' => 108,
                'name' => 'Jeweler',
                'occ_code' => null,
            ],
            108 => [
                'id' => 109,
                'name' => 'Journalist/Reporter',
                'occ_code' => null,
            ],
            109 => [
                'id' => 110,
                'name' => 'Laborer',
                'occ_code' => null,
            ],
            110 => [
                'id' => 111,
                'name' => 'Landscaping',
                'occ_code' => null,
            ],
            111 => [
                'id' => 112,
                'name' => 'Law Enforcement',
                'occ_code' => null,
            ],
            112 => [
                'id' => 113,
                'name' => 'Legal Assistant',
                'occ_code' => null,
            ],
            113 => [
                'id' => 114,
                'name' => 'Librarian',
                'occ_code' => null,
            ],
            114 => [
                'id' => 115,
                'name' => 'Locksmith',
                'occ_code' => null,
            ],
            115 => [
                'id' => 116,
                'name' => 'Machinist',
                'occ_code' => null,
            ],
            116 => [
                'id' => 117,
                'name' => 'Maid',
                'occ_code' => null,
            ],
            117 => [
                'id' => 118,
                'name' => 'Mailing Service',
                'occ_code' => null,
            ],
            118 => [
                'id' => 119,
                'name' => 'Maintenance',
                'occ_code' => null,
            ],
            119 => [
                'id' => 120,
                'name' => 'Marketing',
                'occ_code' => null,
            ],
            120 => [
                'id' => 121,
                'name' => 'Massage',
                'occ_code' => null,
            ],
            121 => [
                'id' => 122,
                'name' => 'Mathematician/Statistician',
                'occ_code' => null,
            ],
            122 => [
                'id' => 123,
                'name' => 'Mechanical Engineer',
                'occ_code' => null,
            ],
            123 => [
                'id' => 124,
                'name' => 'Medical',
                'occ_code' => null,
            ],
            124 => [
                'id' => 125,
                'name' => 'Metallurgical Engineer',
                'occ_code' => null,
            ],
            125 => [
                'id' => 126,
                'name' => 'Meter Reader',
                'occ_code' => null,
            ],
            126 => [
                'id' => 127,
                'name' => 'Meterologist',
                'occ_code' => null,
            ],
            127 => [
                'id' => 128,
                'name' => 'Military',
                'occ_code' => null,
            ],
            128 => [
                'id' => 129,
                'name' => 'Miner',
                'occ_code' => null,
            ],
            129 => [
                'id' => 130,
                'name' => 'Minister',
                'occ_code' => null,
            ],
            130 => [
                'id' => 131,
                'name' => 'Musician',
                'occ_code' => null,
            ],
            131 => [
                'id' => 132,
                'name' => 'Newspaper Industry',
                'occ_code' => null,
            ],
            132 => [
                'id' => 133,
                'name' => 'No Work Code Available',
                'occ_code' => null,
            ],
            133 => [
                'id' => 134,
                'name' => 'Nuclear Industry',
                'occ_code' => null,
            ],
            134 => [
                'id' => 135,
                'name' => 'Nursery/Horticulture',
                'occ_code' => null,
            ],
            135 => [
                'id' => 136,
                'name' => 'Office Manager',
                'occ_code' => null,
            ],
            136 => [
                'id' => 137,
                'name' => 'Oil & Gas Industry',
                'occ_code' => null,
            ],
            137 => [
                'id' => 138,
                'name' => 'Optician',
                'occ_code' => null,
            ],
            138 => [
                'id' => 139,
                'name' => 'Optometrist',
                'occ_code' => null,
            ],
            139 => [
                'id' => 140,
                'name' => 'Owner Business',
                'occ_code' => null,
            ],
            140 => [
                'id' => 141,
                'name' => 'Painter',
                'occ_code' => null,
            ],
            141 => [
                'id' => 142,
                'name' => 'Paralegal',
                'occ_code' => null,
            ],
            142 => [
                'id' => 143,
                'name' => 'Pathologist',
                'occ_code' => null,
            ],
            143 => [
                'id' => 144,
                'name' => 'Personnel/Human Resources',
                'occ_code' => null,
            ],
            144 => [
                'id' => 145,
                'name' => 'Pharmacist',
                'occ_code' => null,
            ],
            145 => [
                'id' => 146,
                'name' => 'Photography',
                'occ_code' => null,
            ],
            146 => [
                'id' => 147,
                'name' => 'Physical Therapist',
                'occ_code' => null,
            ],
            147 => [
                'id' => 148,
                'name' => 'Physician',
                'occ_code' => null,
            ],
            148 => [
                'id' => 149,
                'name' => 'Physicist',
                'occ_code' => null,
            ],
            149 => [
                'id' => 150,
                'name' => 'Physiologist',
                'occ_code' => null,
            ],
            150 => [
                'id' => 151,
                'name' => 'Pilot',
                'occ_code' => null,
            ],
            151 => [
                'id' => 152,
                'name' => 'Plumber',
                'occ_code' => null,
            ],
            152 => [
                'id' => 153,
                'name' => 'Podiatrist',
                'occ_code' => null,
            ],
            153 => [
                'id' => 154,
                'name' => 'Police Officer',
                'occ_code' => null,
            ],
            154 => [
                'id' => 155,
                'name' => 'Postal Service',
                'occ_code' => null,
            ],
            155 => [
                'id' => 156,
                'name' => 'Priest',
                'occ_code' => null,
            ],
            156 => [
                'id' => 157,
                'name' => 'Printing',
                'occ_code' => null,
            ],
            157 => [
                'id' => 158,
                'name' => 'Nurse',
                'occ_code' => null,
            ],
            158 => [
                'id' => 159,
                'name' => 'Psychiatrist',
                'occ_code' => null,
            ],
            159 => [
                'id' => 160,
                'name' => 'Psychologist',
                'occ_code' => null,
            ],
            160 => [
                'id' => 161,
                'name' => 'Psychotherapist',
                'occ_code' => null,
            ],
            161 => [
                'id' => 162,
                'name' => 'Purchasing',
                'occ_code' => null,
            ],
            162 => [
                'id' => 163,
                'name' => 'Radio/Television',
                'occ_code' => null,
            ],
            163 => [
                'id' => 164,
                'name' => 'Railroad',
                'occ_code' => null,
            ],
            164 => [
                'id' => 165,
                'name' => 'Real Estate',
                'occ_code' => null,
            ],
            165 => [
                'id' => 166,
                'name' => 'Registered Nurse',
                'occ_code' => null,
            ],
            166 => [
                'id' => 167,
                'name' => 'Retail',
                'occ_code' => null,
            ],
            167 => [
                'id' => 168,
                'name' => 'Retired',
                'occ_code' => null,
            ],
            168 => [
                'id' => 169,
                'name' => 'Roofing',
                'occ_code' => null,
            ],
            169 => [
                'id' => 170,
                'name' => 'Sailor',
                'occ_code' => null,
            ],
            170 => [
                'id' => 171,
                'name' => 'Sales',
                'occ_code' => null,
            ],
            171 => [
                'id' => 172,
                'name' => 'School',
                'occ_code' => null,
            ],
            172 => [
                'id' => 173,
                'name' => 'Secretary',
                'occ_code' => null,
            ],
            173 => [
                'id' => 174,
                'name' => 'Security',
                'occ_code' => null,
            ],
            174 => [
                'id' => 175,
                'name' => 'Self Employed',
                'occ_code' => null,
            ],
            175 => [
                'id' => 176,
                'name' => 'Shipping/Receiving',
                'occ_code' => null,
            ],
            176 => [
                'id' => 177,
                'name' => 'Social Work',
                'occ_code' => null,
            ],
            177 => [
                'id' => 178,
                'name' => 'Speech',
                'occ_code' => null,
            ],
            178 => [
                'id' => 179,
                'name' => 'Stockbroker',
                'occ_code' => null,
            ],
            179 => [
                'id' => 180,
                'name' => 'Student',
                'occ_code' => null,
            ],
            180 => [
                'id' => 181,
                'name' => 'Surgeon',
                'occ_code' => null,
            ],
            181 => [
                'id' => 182,
                'name' => 'Tailor',
                'occ_code' => null,
            ],
            182 => [
                'id' => 183,
                'name' => 'Teaching',
                'occ_code' => null,
            ],
            183 => [
                'id' => 184,
                'name' => 'Telecommunications',
                'occ_code' => null,
            ],
            184 => [
                'id' => 185,
                'name' => 'Telemarketing',
                'occ_code' => null,
            ],
            185 => [
                'id' => 186,
                'name' => 'Telephone',
                'occ_code' => null,
            ],
            186 => [
                'id' => 187,
                'name' => 'Teller',
                'occ_code' => null,
            ],
            187 => [
                'id' => 188,
                'name' => 'Therapist',
                'occ_code' => null,
            ],
            188 => [
                'id' => 189,
                'name' => 'Transportation',
                'occ_code' => null,
            ],
            189 => [
                'id' => 190,
                'name' => 'Unemployed',
                'occ_code' => null,
            ],
            190 => [
                'id' => 191,
                'name' => 'Upholsterer',
                'occ_code' => null,
            ],
            191 => [
                'id' => 192,
                'name' => 'Utilities',
                'occ_code' => null,
            ],
            192 => [
                'id' => 193,
                'name' => 'Waitress',
                'occ_code' => null,
            ],
            193 => [
                'id' => 194,
                'name' => 'Warehouse Operations',
                'occ_code' => null,
            ],
            194 => [
                'id' => 195,
                'name' => 'Welder',
                'occ_code' => null,
            ],
            195 => [
                'id' => 196,
                'name' => 'Writer',
                'occ_code' => null,
            ],
            196 => [
                'id' => 197,
                'name' => 'Zoologist',
                'occ_code' => null,
            ],
            197 => [
                'id' => 198,
                'name' => 'Financial',
                'occ_code' => null,
            ],
            198 => [
                'id' => 199,
                'name' => 'Investigator',
                'occ_code' => null,
            ],
            199 => [
                'id' => 200,
                'name' => 'Clerical',
                'occ_code' => null,
            ],
            200 => [
                'id' => 201,
                'name' => 'Accounting',
                'occ_code' => null,
            ],
            201 => [
                'id' => 203,
                'name' => 'Assistant Director',
                'occ_code' => null,
            ],
            202 => [
                'id' => 204,
                'name' => 'Attorney',
                'occ_code' => null,
            ],
            203 => [
                'id' => 205,
                'name' => 'Engineer',
                'occ_code' => null,
            ],
            204 => [
                'id' => 206,
                'name' => 'CFO',
                'occ_code' => null,
            ],
            205 => [
                'id' => 207,
                'name' => 'Volunteer',
                'occ_code' => null,
            ],
            206 => [
                'id' => 208,
                'name' => 'Manager',
                'occ_code' => null,
            ],
            207 => [
                'id' => 209,
                'name' => 'Health Care',
                'occ_code' => null,
            ],
            208 => [
                'id' => 210,
                'name' => 'Audiologist',
                'occ_code' => null,
            ],
            209 => [
                'id' => 211,
                'name' => 'Property Management',
                'occ_code' => null,
            ],
            210 => [
                'id' => 212,
                'name' => 'Temporary',
                'occ_code' => null,
            ],
            211 => [
                'id' => 213,
                'name' => 'Government',
                'occ_code' => null,
            ],
            212 => [
                'id' => 214,
                'name' => 'Provost',
                'occ_code' => null,
            ],
            213 => [
                'id' => 215,
                'name' => 'Contractor',
                'occ_code' => null,
            ],
            214 => [
                'id' => 216,
                'name' => 'Nanny',
                'occ_code' => null,
            ],
            215 => [
                'id' => 217,
                'name' => 'Travel Agent',
                'occ_code' => null,
            ],
            216 => [
                'id' => 218,
                'name' => 'Pediatrician',
                'occ_code' => null,
            ],
            217 => [
                'id' => 219,
                'name' => 'Ophthalmologist',
                'occ_code' => null,
            ],
            218 => [
                'id' => 220,
                'name' => 'Veterinarian',
                'occ_code' => null,
            ],
            219 => [
                'id' => 221,
                'name' => 'Assembly',
                'occ_code' => null,
            ],
            220 => [
                'id' => 222,
                'name' => 'Receptionist',
                'occ_code' => null,
            ],
            221 => [
                'id' => 223,
                'name' => 'Scheduler',
                'occ_code' => null,
            ],
            222 => [
                'id' => 224,
                'name' => 'Interpreter',
                'occ_code' => null,
            ],
            223 => [
                'id' => 225,
                'name' => 'Training',
                'occ_code' => null,
            ],
            224 => [
                'id' => 226,
                'name' => 'Systems Analyst',
                'occ_code' => null,
            ],
            225 => [
                'id' => 227,
                'name' => 'Public Relations',
                'occ_code' => null,
            ],
            226 => [
                'id' => 228,
                'name' => 'Mechanic',
                'occ_code' => null,
            ],
            227 => [
                'id' => 229,
                'name' => 'Freight',
                'occ_code' => null,
            ],
            228 => [
                'id' => 230,
                'name' => 'Pastor',
                'occ_code' => null,
            ],
            229 => [
                'id' => 231,
                'name' => 'School Crossing Guard',
                'occ_code' => null,
            ],
            230 => [
                'id' => 232,
                'name' => 'Microbiologist',
                'occ_code' => null,
            ],
            231 => [
                'id' => 233,
                'name' => 'Copywriter',
                'occ_code' => null,
            ],
            232 => [
                'id' => 234,
                'name' => 'Seminary',
                'occ_code' => null,
            ],
            233 => [
                'id' => 235,
                'name' => 'Tool & Die',
                'occ_code' => null,
            ],
            234 => [
                'id' => 236,
                'name' => 'Manicurist',
                'occ_code' => null,
            ],
            235 => [
                'id' => 237,
                'name' => 'Probation Officer',
                'occ_code' => null,
            ],
            236 => [
                'id' => 238,
                'name' => 'Evangelist',
                'occ_code' => null,
            ],
            237 => [
                'id' => 239,
                'name' => 'Translator',
                'occ_code' => null,
            ],
            238 => [
                'id' => 240,
                'name' => 'Missionary',
                'occ_code' => null,
            ],
            239 => [
                'id' => 241,
                'name' => 'Pastoral Associate',
                'occ_code' => null,
            ],
            240 => [
                'id' => 242,
                'name' => 'Flight Attendant',
                'occ_code' => null,
            ],
            241 => [
                'id' => 243,
                'name' => 'Research',
                'occ_code' => null,
            ],
            242 => [
                'id' => 244,
                'name' => 'Transcriptionist',
                'occ_code' => null,
            ],
            243 => [
                'id' => 245,
                'name' => 'Restaurant Management',
                'occ_code' => null,
            ],
            244 => [
                'id' => 246,
                'name' => 'Auto Dealership',
                'occ_code' => null,
            ],
            245 => [
                'id' => 247,
                'name' => 'Spiritual Director',
                'occ_code' => null,
            ],
            246 => [
                'id' => 248,
                'name' => 'Music Director',
                'occ_code' => null,
            ],
            247 => [
                'id' => 249,
                'name' => 'Youth Minister',
                'occ_code' => null,
            ],
            248 => [
                'id' => 250,
                'name' => 'Manufacturing',
                'occ_code' => null,
            ],
            249 => [
                'id' => 251,
                'name' => 'Liturgist',
                'occ_code' => null,
            ],
            250 => [
                'id' => 252,
                'name' => 'Media',
                'occ_code' => null,
            ],
            251 => [
                'id' => 253,
                'name' => 'Distribution',
                'occ_code' => null,
            ],
            252 => [
                'id' => 254,
                'name' => 'Recruiting',
                'occ_code' => null,
            ],
            253 => [
                'id' => 255,
                'name' => 'Computer Industry',
                'occ_code' => null,
            ],
            254 => [
                'id' => 256,
                'name' => 'High Tech Industry',
                'occ_code' => null,
            ],
            255 => [
                'id' => 257,
                'name' => 'Radiology',
                'occ_code' => null,
            ],
            256 => [
                'id' => 258,
                'name' => 'Linguist',
                'occ_code' => null,
            ],
            257 => [
                'id' => 259,
                'name' => 'Judge',
                'occ_code' => null,
            ],
            258 => [
                'id' => 260,
                'name' => 'Ski Instructor',
                'occ_code' => null,
            ],
            259 => [
                'id' => 261,
                'name' => 'Graphic Arts/Designer',
                'occ_code' => null,
            ],
            260 => [
                'id' => 262,
                'name' => 'Health & Fitness',
                'occ_code' => null,
            ],
            261 => [
                'id' => 263,
                'name' => 'Tech',
                'occ_code' => null,
            ],
            262 => [
                'id' => 264,
                'name' => 'Buyer/Asst. Buyer',
                'occ_code' => null,
            ],
            263 => [
                'id' => 265,
                'name' => 'Custodian',
                'occ_code' => null,
            ],
            264 => [
                'id' => 266,
                'name' => 'Ranching',
                'occ_code' => null,
            ],
            265 => [
                'id' => 267,
                'name' => 'Designer',
                'occ_code' => null,
            ],
            266 => [
                'id' => 268,
                'name' => 'News Reporter',
                'occ_code' => null,
            ],
            267 => [
                'id' => 269,
                'name' => 'Programming',
                'occ_code' => null,
            ],
            268 => [
                'id' => 270,
                'name' => 'Arbitrator/Mediator',
                'occ_code' => null,
            ],
            269 => [
                'id' => 271,
                'name' => 'Principal',
                'occ_code' => null,
            ],
            270 => [
                'id' => 272,
                'name' => 'Musician',
                'occ_code' => null,
            ],
            271 => [
                'id' => 273,
                'name' => 'Inventor',
                'occ_code' => null,
            ],
            272 => [
                'id' => 274,
                'name' => 'Parole Officer',
                'occ_code' => null,
            ],
            273 => [
                'id' => 275,
                'name' => 'Auditor',
                'occ_code' => null,
            ],
            274 => [
                'id' => 276,
                'name' => 'Loan Processing',
                'occ_code' => null,
            ],
            275 => [
                'id' => 277,
                'name' => 'Home Builder',
                'occ_code' => null,
            ],
            276 => [
                'id' => 278,
                'name' => 'Software Engineer',
                'occ_code' => null,
            ],
            277 => [
                'id' => 279,
                'name' => 'Glazer',
                'occ_code' => null,
            ],
            278 => [
                'id' => 280,
                'name' => 'Internet Industry',
                'occ_code' => null,
            ],
            279 => [
                'id' => 281,
                'name' => 'Phlebotomist',
                'occ_code' => null,
            ],
            280 => [
                'id' => 282,
                'name' => 'Systems Engineer',
                'occ_code' => null,
            ],
            281 => [
                'id' => 283,
                'name' => 'Golf Pro',
                'occ_code' => null,
            ],
            282 => [
                'id' => 284,
                'name' => 'Paramedic',
                'occ_code' => null,
            ],
            283 => [
                'id' => 285,
                'name' => 'Forensics',
                'occ_code' => null,
            ],
            284 => [
                'id' => 286,
                'name' => 'Pharmacy Tech',
                'occ_code' => null,
            ],
            285 => [
                'id' => 287,
                'name' => 'Farrier',
                'occ_code' => null,
            ],
            286 => [
                'id' => 288,
                'name' => 'Lithographer',
                'occ_code' => null,
            ],
            287 => [
                'id' => 289,
                'name' => 'Document Control',
                'occ_code' => null,
            ],
            288 => [
                'id' => 290,
                'name' => 'Zoo Keeper',
                'occ_code' => null,
            ],
            289 => [
                'id' => 291,
                'name' => 'Ministry',
                'occ_code' => null,
            ],
            290 => [
                'id' => 292,
                'name' => 'Student Ministry',
                'occ_code' => null,
            ],
            291 => [
                'id' => 293,
                'name' => 'Truck Driver',
                'occ_code' => null,
            ],
            292 => [
                'id' => 294,
                'name' => 'Scientist',
                'occ_code' => null,
            ],
            293 => [
                'id' => 295,
                'name' => 'Builder',
                'occ_code' => null,
            ],
            294 => [
                'id' => 296,
                'name' => 'Veterinary Assistant',
                'occ_code' => null,
            ],
            295 => [
                'id' => 297,
                'name' => 'Episcopal Priest',
                'occ_code' => null,
            ],
            296 => [
                'id' => 298,
                'name' => 'Legal Secretary',
                'occ_code' => null,
            ],
            297 => [
                'id' => 299,
                'name' => 'Mover',
                'occ_code' => null,
            ],
            298 => [
                'id' => 300,
                'name' => 'Underwriter',
                'occ_code' => null,
            ],
            299 => [
                'id' => 301,
                'name' => 'Bartender',
                'occ_code' => null,
            ],
            300 => [
                'id' => 302,
                'name' => 'Reporter',
                'occ_code' => null,
            ],
            301 => [
                'id' => 303,
                'name' => 'Horticulturist',
                'occ_code' => null,
            ],
            302 => [
                'id' => 304,
                'name' => 'Guide',
                'occ_code' => null,
            ],
            303 => [
                'id' => 305,
                'name' => 'Power Development',
                'occ_code' => null,
            ],
            304 => [
                'id' => 306,
                'name' => 'Appraiser',
                'occ_code' => null,
            ],
            305 => [
                'id' => 307,
                'name' => 'Director Adult Formation',
                'occ_code' => null,
            ],
            306 => [
                'id' => 308,
                'name' => 'DRE',
                'occ_code' => null,
            ],
            307 => [
                'id' => 309,
                'name' => 'Hispanic Ministry Coordinator',
                'occ_code' => null,
            ],
            308 => [
                'id' => 310,
                'name' => 'Director of Religious Education',
                'occ_code' => null,
            ],
            309 => [
                'id' => 311,
                'name' => 'Meteorologist',
                'occ_code' => null,
            ],
            310 => [
                'id' => 312,
                'name' => 'Human Resources',
                'occ_code' => null,
            ],
            311 => [
                'id' => 313,
                'name' => 'Braillist',
                'occ_code' => null,
            ],
            312 => [
                'id' => 314,
                'name' => 'Director Adult Education',
                'occ_code' => null,
            ],
            313 => [
                'id' => 315,
                'name' => 'Quality Control',
                'occ_code' => null,
            ],
            314 => [
                'id' => 316,
                'name' => 'Speech Pathologist',
                'occ_code' => null,
            ],
            315 => [
                'id' => 317,
                'name' => 'Leasing Consultant',
                'occ_code' => null,
            ],
            316 => [
                'id' => 318,
                'name' => 'Chief Financial Officer',
                'occ_code' => null,
            ],
            317 => [
                'id' => 319,
                'name' => 'TV Producer',
                'occ_code' => null,
            ],
            318 => [
                'id' => 320,
                'name' => 'Neuropsychologist',
                'occ_code' => null,
            ],
            319 => [
                'id' => 321,
                'name' => 'Fiduciary',
                'occ_code' => null,
            ],
            320 => [
                'id' => 322,
                'name' => 'Trader',
                'occ_code' => null,
            ],
            321 => [
                'id' => 323,
                'name' => 'Oral Surgeon',
                'occ_code' => null,
            ],
            322 => [
                'id' => 324,
                'name' => 'Grant Writer',
                'occ_code' => null,
            ],
            323 => [
                'id' => 325,
                'name' => 'Marine Science',
                'occ_code' => null,
            ],
            324 => [
                'id' => 326,
                'name' => 'House Cleaning',
                'occ_code' => null,
            ],
            325 => [
                'id' => 327,
                'name' => 'Pest Control',
                'occ_code' => null,
            ],
            326 => [
                'id' => 328,
                'name' => 'Sister',
                'occ_code' => null,
            ],
            327 => [
                'id' => 329,
                'name' => 'Fine Arts',
                'occ_code' => null,
            ],
            328 => [
                'id' => 330,
                'name' => 'Court Reporter',
                'occ_code' => null,
            ],
            329 => [
                'id' => 331,
                'name' => 'Nutrition Specialist',
                'occ_code' => null,
            ],
            330 => [
                'id' => 332,
                'name' => 'Esthetician',
                'occ_code' => null,
            ],
            331 => [
                'id' => 333,
                'name' => 'Sports Related',
                'occ_code' => null,
            ],
        ]);
    }
}
