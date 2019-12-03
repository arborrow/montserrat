<?php

return [

    /*
     * Restrict socialite authentication to a particular domain
     */
    'socialite_domain_restriction' => 'montserratretreat.org',

    /*
     *  Polanco's name
     */

    'site_name' => 'Polanco',

    /*
     *  Polanco's email address for sending notifications
     */

    'site_email' => 'polanco@montserratretreat.org',

    /*
     * Site administrator name and email for receiving notifications
     */

    'admin_name' => 'Anthony Borrow',
    'admin_email' => 'anthony.borrow@montserratretreat.org',
    'finance_email' => 'finance@montserratretreat.org',
    'notify_registration_event_change' => '1',

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
        'captain' => '24',
        'priest' => '25',
        'deacon' => '26',
        'community' => '27',
        'primary_contact' => '28',
    ],

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

    'location_type' => [
        'home' => '1',
        'work' => '2',
        'main' => '3',
        'other' => '4',
        'billing' => '5',
    ],
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
    'medium' => [
        'in person' => '1',
        'phone' => '2',
        'email' => '3',
        'fax' => '4',
        'letter' => '5',
    ],
    'priority' => [
        'urgent' => '1',
        'normal' => '2',
        'low' => '3',
    ],

    'country_id_usa' => '1228',
    'state_province_id_tx' => '1042',

    'contact' => [
        'montserrat' => '620',
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
    ],

    'file_type' => [
        'contact_attachment' => '1',
        'event_schedule' => '2',
        'event_evaluation' => '3',
        'event_contract' => '4',
        'event_group_photo' => '5',
        'contact_avatar' => '6',
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
        'captain' => '11',
        'board' => '12',
        'staff' => '13',
        'volunteer' => '14',
        'steward' => '15',
        'runner' => '16',
        'hlm2017' => '17',
    ],

    'participant_role_id' => [
        'captain' => '11',
        'retreatant' => '5',
        'retreat_director' => '8',
        'retreat_innkeeper' => '9',
        'retreat_assistant' => '10',
    ],

    'registration_status_id' => [
        'registered' => '1',
        'attended' => '2',
        'no_show' => '3',
        'canceled' => '4',
        'pending' => '5',
        'waitlist' => '7',
        'rejected' => '11',
    ],

    'registration_source' => [
        'N/A' => 'N/A',
        'Squarespace' => 'Squarespace',
        'Phone' => 'Phone',
        'Email' => 'Email',
        'In person' => 'In person',
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

];
