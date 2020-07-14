<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountyAndCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('county_and_cities')->insert([
            [
                'county_name' => 'Brunswick',
                'zip' => '28461',
                'city_name' => 'Oak Island', 
                'state_id' => 1
            ],[
                'county_name' => 'Brunswick',
                'zip' => '28461',
                'city_name' => 'Southport', 
                'state_id' => 1
            ],[
                'county_name' => 'Brunswick',
                'zip' => '28461',
                'city_name' => 'Saint James', 
                'state_id' => 1
            ],[
                'county_name' => 'Alamance',
                'zip' => '27215',
                'city_name' => 'Burlington', 
                'state_id' => 1
            ],[
                'county_name' => 'Altamahaw',
                'zip' => '27202',
                'city_name' => 'Burlington', 
                'state_id' => 1
            ],[
                'county_name' => 'New Hanover',
                'zip' => '28428',
                'city_name' => 'Carolina Beach', 
                'state_id' => 1
            ],[
                'county_name' => 'Orange',
                'zip' => '92850',
                'city_name' => 'Anaheim', 
                'state_id' => 2
            ]
        ]);
    }
}
