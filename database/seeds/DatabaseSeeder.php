<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use \montserrat\Retreat;
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

            
        Model::reguard();
    }
}
