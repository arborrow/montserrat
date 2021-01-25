<?php

return [

    /*
     * Site administrator name and email for receiving notifications
     */

     'activity_contacts_type' => [
         'assignee' => '1',
         'creator' => '2',
         'target' => '3',
     ],

     'activity_type' => [
         'meeting' => '1',
         'call' => '2',
         'email' => '3',
         'text' => '4',
         'letter' => '5',
         'other' => '8',
     ],

    'admin_name' => 'Anthony Borrow',
    'admin_email' => 'anthony.borrow@montserratretreat.org',

    // list of donation_descriptions considered to be part of annual giving campaign
    'agc_cool_colors' => [
        0 => '51,105,232',
        1 => '255, 205, 86',
        2 => '255, 99, 132',
        3 => '244,67,54',
        4 => '211,159,153',
        5 => '205,211,153',
        6 =>'229,229,201',
        7 => '90,174,174',
        8 => '147,131,107',
    ],

    'agc_donation_descriptions' => [
        'AGC - General',
        'AGC - Endowment',
        'AGC - Scholarships',
        'AGC - Buildings & Maintenance',
    ],

    'asset_task_frequency' => [
        'daily' => 'daily',
        'weekly' => 'weekly',
        'monthly' => 'monthly',
        'yearly' => 'yearly',
    ],

    'asset_job_status' => [
        'Scheduled' => 'Scheduled',
        'Nonscheduled' => 'Nonscheduled',
        'Completed' => 'Completed',
        'Canceled' => 'Canceled',
    ],

    'finance_email' => 'finance@montserratretreat.org',
    'notify_registration_event_change' => '1',

    'country_id_usa' => '1228',
    'state_province_id_tx' => '1042',

    'contact_type' => [
        'individual' => '1',
        'household' => '2',
        'organization' => '3',
        'parish' => '4',
        'diocese' => '5',
        'province' => '6',
        'community' => '7',
        'retreat_house' => '8',
        'vendor' => '9',
        'religious_catholic' => '10',
        'religious_noncatholic' => '11',
        'contract' => '12',
        'foundation' => '13',
    ],

    'contact' => [
        'montserrat' => '620',
    ],
    // when creating database with the seeder, the first event created is the open deposit event
    'event' => [
        'open_deposit' => env('OPEN_DEPOSIT_EVENT_ID', 1),
    ],

    'event_type' => [
        'conference' => '1',
        'exhibition' => '2',
        'fundraiser' => '3',
        'meeting' => '4',
        'performance' => '5',
        'workshop' => '6',
        'ignatian' => '7',
        'diocesan' => '8',
        'other' => '9',
        'day' => '10',
        'contract' => '11',
        'directed' => '12',
        'isi' => '13',
        'jesuit' => '14',
        'saturday' => '15',
    ],

    /*
    * Export list types to fill export_list.type field
    */

    'export_list_types' => [
        'Email' => 'Email',
        'Mailing' => 'Mailing',
        'Other' => 'Other',
    ],

    'file_type' => [
        'contact_attachment' => '1',
        'event_schedule' => '2',
        'event_evaluation' => '3',
        'event_contract' => '4',
        'event_group_photo' => '5',
        'contact_avatar' => '6',
        'event_attachment' => '7',
        'signature' => '8',
        'asset_photo' => '9',
        'asset_attachment' => '10',
    ],

    'group_id' => [
        'innkeeper' => '1',
        'director' => '2',
        'assistant' => '3',
        'bishop' => '4',
        'priest' => '5',
        'deacon' => '6',
        'jesuit' => '7',
        'provincial' => '8',
        'superior' => '9',
        'pastor' => '10',
        'ambassador' => '11',
        'board' => '12',
        'staff' => '13',
        'volunteer' => '14',
        'steward' => '15',
        'runner' => '16',
        'hlm2017' => '17',
    ],

    // communication locations (phone, email, address, etc.)
    'location_type' => [
        'home' => '1',
        'work' => '2',
        'main' => '3',
        'other' => '4',
        'billing' => '5',
    ],
    // physical types of locations
    'locations_type' => [
        'Site' => 'Site',
        'Grounds' => 'Grounds',
        'Building' => 'Building',
        'Floor' => 'Floor',
        'Room' => 'Room',
        'Closet' => 'Closet',
        'Other' => 'Other',
    ],

    'medium' => [
        'in person' => '1',
        'phone' => '2',
        'email' => '3',
        'fax' => '4',
        'letter' => '5',
    ],

    'operators' => [
        '<' => '<',
        '<=' => '<=',
        '=' => '=',
        '>=' => '>=',
        '>' => '>',
    ],

    'participant_role_id' => [
        'ambassador' => '11',
        'retreatant' => '5',
        'retreat_director' => '8',
        'retreat_innkeeper' => '9',
        'retreat_assistant' => '10',
    ],

    'payment_method' => [
        'Unassigned' => 'Unassigned',
        'Cash' => 'Cash',
        'Check' => 'Check',
        'Credit card' => 'Credit card',
        'Gift cert funded' => 'Gift cert funded',
        'Gift cert unfunded' => 'Gift cert unfunded',
        'Journal' => 'Journal',
        'NSF' => 'NSF',
        'Reallocation' => 'Reallocation',
        'Refund' => 'Refund',
        'Other' => 'Other',
        'Wire transfer' => 'Wire transfer',
    ],

    'preferred_communication_method' => [
        '0' => 'N/A',
        '1' => 'Phone',
        '2' => 'Email',
        '3' => 'Postal Mail',
        '4' => 'SMS',
    ],

    'priority' => [
        'emergency' => '0',
        'urgent' => '1',
        'serious' => '2',
        'normal' => '3',
        'low' => '4',
    ],

    'registration_status_id' => [
        'registered' => '1',
        'no_show' => '3',
        'canceled' => '4',
        'waitlist' => '7',
        'nonparticipaitng' => '17',

    ],

    'registration_source' => [
        'N/A' => 'N/A',
        'Squarespace' => 'Squarespace',
        'Phone' => 'Phone',
        'Email' => 'Email',
        'In person' => 'In person',
        'Postal Mail' => 'Postal Mail',
    ],

    'relationship_type' => [
        'child_parent' => '1',
        'husband_wife' => '2',
        'sibling' => '4',
        'staff' => '5',
        'volunteer' => '6',
        'parishioner' => '11',
        'bishop' => '12',
        'diocese' => '13',
        'pastor' => '14',
        'superior' => '15',
        'provincial' => '16',
        'community_member' => '17',
        'board_member' => '18',
        'retreat_director' => '19',
        'retreat_assistant' => '20',
        'retreat_innkeeper' => '21',
        'retreatant' => '22',
        'donor' => '23',
        'ambassador' => '24',
        'priest' => '25',
        'deacon' => '26',
        'community' => '27',
        'primary_contact' => '28',
    ],

    'touchpoint_source' => [
        'Call' => 'Call',
        'Email' => 'Email',
        'Face' => 'Face to Face',
        'Letter' => 'Letter',
        'Other' => 'Other',
    ],

    // when using the database seeder the first contact created is the self organization
    // name is used by database seeder to create self contact record
    'self' => [
        'id' => env('SELF_CONTACT_ID', 620),
        'name' => env('SELF_NAME', 'Montserrat Jesuit Retreat House'),
    ],

    /*
     *  Polanco's name
     *  TODO: rename self.name and self.id to site.id and use site.variable consistently throughout Polanco
     */

    'site_name' => 'Polanco',

    /*
     *  Polanco's email address for sending notifications
     */

    'site_email' => 'polanco@montserratretreat.org',

    /*
     * Restrict socialite authentication to a particular domain
     */
    'socialite_domain_restriction' => 'montserratretreat.org',

    /*
    * Unit of measurement types to fill uom.type enum field
     */
    'uom_types' => [
        'Area' => 'Area',
        'Electric current' => 'Electric current',
        'Length' => 'Length',
        'Luminosity' => 'Luminosity',
        'Mass' => 'Mass',
        'Temperature' => 'Temperature',
        'Time' => 'Time',
        'Volume' => 'Volume',
    ],

    'website_types' => [
        'Personal' => 'Personal',
        'Work' => 'Work',
        'Main' => 'Main',
        'Facebook' => 'Facebook',
        'Google' => 'Google',
        'Instagram' => 'Instagram',
        'LinkedIn' => 'LinkedIn',
        'MySpace' => 'MySpace',
        'Other' => 'Other',
        'Pinterest' => 'Pinterest',
        'SnapChat' => 'SnapChat',
        'Tumblr' => 'Tumblr',
        'Twitter' => 'Twitter',
        'Vine' => 'Vine',
    ],

];
