<?php

use Illuminate\Database\Seeder;
use App\Animal;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Animal::truncate();
        
        $animals = [
            [
                'id' => 1,
                'name' => 'Кот',
                'img' => 'animals/cat.png',
                'male' => 'Кот',
                'female' => 'Кошка',
                '_none' => 'Не выбрано',
            ],
            [
                'id' => 2,
                'name' => 'Собака',
                'img' => 'animals/dog.png',
                'male' => 'Кабель',
                'female' => 'Сука',
                '_none' => 'Не выбрано',
            ]
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
