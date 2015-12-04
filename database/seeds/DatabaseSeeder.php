<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use \montserrat\Innkeeper;
use \montserrat\Retreat;
use \montserrat\Retreatant;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
          Innkeeper::create([
			'title' => 'Fr.',
                        'firstname' => 'Ron',
                        'lastname' => 'Boudreaux',
                        'suffix' => 'S.J.',
                        'address1' => 'Montserrat Retreat House',
                        'address2' => '600 N. Shady Shores Road',
                        'city' => 'Lake Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '940-321-6020 x237',
                        'workphone' => '940-321-6020 x237',
                        'mobilephone' => '940-395-7447',
                        'gender' => 'Male',
                        'languages' => 'English, Spanish',
			'email' => 'ron.boudreaux@montserratretreat.org',
			'password' => bcrypt('admin')
		]);
        
         Innkeeper::create([
			'title' => 'Fr.',
                        'firstname' => 'Anthony',
                        'lastname' => 'Borrow',
                        'suffix' => 'S.J.',
                        'address1' => 'Montserrat Retreat House',
                        'address2' => '600 N. Shady Shores Road',
                        'city' => 'Lake Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '940-321-6020 x233',
                        'workphone' => '940-321-6020 x233',
                        'mobilephone' => '504-383-5852',
                        'url' => 'https://arborrow.org',
                        'gender' => 'Male',
                        'languages' => 'English/Spanish',
			'email' => 'anthony.borrow@montserratretreat.org',
			'password' => bcrypt('admin')
		]);
         
            Innkeeper::create([
			'title' => 'Fr.',
                        'firstname' => 'John',
                        'lastname' => 'Payne',
                        'suffix' => 'S.J.',
                        'address1' => 'Montserrat Retreat House',
                        'address2' => '600 N. Shady Shores Road',
                        'city' => 'Lake Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '940-321-6020 x229',
                        'workphone' => '940-321-6020 x229',
                        'mobilephone' => '512-289-3370',
                        'gender' => 'Male',
                        'languages' => 'English',
			'email' => 'john.payne@montserratretreat.org',
			'password' => bcrypt('admin')
		]);

            // Retreat::unprepared(File::get('database\seeds\retreats.sql'));
            
            Retreatant::create([
			'title' => 'Mr.',
                        'firstname' => 'Michael',
                        'lastname' => 'Lee',
                        'address1' => '1234 Park Place',
                        'city' => 'Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '123-456-789',
                        'workphone' => '234-567-8901',
                        'mobilephone' => '345-678-9012',
                        'gender' => 'Male',
                        'languages' => 'English',
			'email' => 'michael.lee@montserratretreat.org',
			'password' => bcrypt('admin')
		]);
            Retreatant::create([
			'title' => 'Mrs.',
                        'firstname' => 'Sara',
                        'lastname' => 'Lee',
                        'address1' => '1234 Cake Place',
                        'city' => 'Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '123-456-789',
                        'workphone' => '234-567-8901',
                        'mobilephone' => '345-678-9012',
                        'gender' => 'Male',
                        'languages' => 'English',
			'email' => 'sara.lee@montserratretreat.org',
			'password' => bcrypt('admin')
		]);
            Retreatant::create([
			'title' => 'Dr.',
                        'firstname' => 'Michael',
                        'lastname' => 'Moon',
                        'address1' => '1234 Sun Place',
                        'city' => 'Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '123-456-789',
                        'workphone' => '234-567-8901',
                        'mobilephone' => '345-678-9012',
                        'gender' => 'Male',
                        'languages' => 'English',
			'email' => 'michael.moon@montserratretreat.org',
			'password' => bcrypt('admin')
		]);
            Retreatant::create([
			'title' => 'Fr.',
                        'firstname' => 'Joseph',
                        'lastname' => 'Christopher',
                        'address1' => '1234 Carpenter Place',
                        'city' => 'Dallas',
                        'state' => 'TX',
                        'zip' => '75065',
                        'country' => 'USA',
                        'homephone' => '123-456-789',
                        'workphone' => '234-567-8901',
                        'mobilephone' => '345-678-9012',
                        'gender' => 'Male',
                        'languages' => 'English',
			'email' => 'joseph.christopher@montserratretreat.org',
			'password' => bcrypt('admin')
		]);
            
        Model::reguard();
    }
}
