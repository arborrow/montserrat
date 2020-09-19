<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $self_contact = \App\Models\Contact::create([
        'contact_type' => config('polanco.contact_type.organization'),
        'subcontact_type' => config('polanco.contact_type.retreat_house'),
        'sort_name' => config('polanco.self.name'),
        'display_name' => config('polanco.self.name'),
        'sort_name' => config('polanco.self.name'),
        'legal_name' => config('polanco.self.name'),
        'organization_name' => config('polanco.self.name'),
      ]);
    }
}
