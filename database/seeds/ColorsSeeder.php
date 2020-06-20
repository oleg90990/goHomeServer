<?php

use Illuminate\Database\Seeder;
use App\Color;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Color::truncate();
        
        $animals = [
            [
                "id" => 1,
                "name" => 'Коричневый',
                "value" => 'brown'
            ],
            [
                "id" => 2,
                "name" => 'Желтный',
                "value" => 'yellow'
            ],
            [
                "id" => 3,
                "name" => 'Черный',
                "value" => 'black'
            ],
            [
                "id" => 4,
                "name" => 'Белый',
                "value" => 'white'
            ],
            [
                "id" => 5,
                "name" => 'Серый',
                "value" => 'gray'
            ]
        ];

        foreach ($animals as $animal) {
            Color::create($animal);
        }
    }
}
