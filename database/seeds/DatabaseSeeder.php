<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ColorsSeeder::class,
            AnimalsSeeder::class,
            BreedsSeeder::class,
            SitiesSeeder::class
        ]);
    }
}
