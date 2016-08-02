<?php

use Illuminate\Database\Seeder;
use montserrat\Ethnicities;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class EthnicitiesTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
          Ethnicity::create([
			'ethnicity' => 'Unspecified',
                        
		]);
          Ethnicity::create([
			'ethnicity' => 'Asian',
                        
		]);
          Ethnicity::create([
			'ethnicity' => 'Black',
                        
		]);
          Ethnicity::create([
			'ethnicity' => 'Native',
                        
		]);
          Ethnicity::create([
			'ethnicity' => 'Pacific',
                        
		]);
          Ethnicity::create([
			'ethnicity' => 'White',
                        
		]);
          Ethnicity::create([
			'ethnicity' => 'Other',
                        
		]);
        
    }
}
