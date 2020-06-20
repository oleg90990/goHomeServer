<?php

use Illuminate\Database\Seeder;
use App\Breed;

class BreedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Breed::truncate();

        $breeds = [
            1 => File::get('database/data/breeds/1.json'),
            2 => File::get('database/data/breeds/2.json')
        ];

        foreach ($breeds as $animalId => $breedsJson) {
            $list = json_decode($breedsJson, true);

            foreach ($list as $breed) {
                Breed::create(array_merge($breed, [
                    'animal_id' => $animalId
                ]));
            }
        }
    }
}
