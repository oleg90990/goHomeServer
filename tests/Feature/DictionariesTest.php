<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DictionariesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDictionaries()
    {
        $response = $this->getJson('/api/v1/dictionaries');

        $response
          ->assertStatus(200)
          ->assertJsonStructure([
            'colors' => [
              '*' => [
                "name",
                "id",
                "value"
              ]
            ],
            'animals' => [
              '*' => [
                'name',
                'id',
                'img',
                'breeds' => [
                  '*' => [
                    "name",
                    "id",
                    "img"
                  ]
                ]
              ]
            ]
          ]);
    }
}
