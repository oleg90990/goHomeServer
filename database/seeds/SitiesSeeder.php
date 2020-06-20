<?php

use Illuminate\Database\Seeder;
use App\City;

class SitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = File::get('database/data/russian-cities.json');

        foreach (json_decode($cities) as $city) {
            $region = City::firstOrCreate([
                'name' => $city->subject,
                'parent_id' => null
            ]);

            City::create([
                'name' => $city->name,
                'parent_id' => $region->id
            ]);
        }
    }
}
