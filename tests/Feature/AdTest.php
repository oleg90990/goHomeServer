<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Ad;
use App\User;

class AdTest extends TestCase
{

    /**
     * create user
     *
     * @return void
     */
    public function getUser()
    {
        User::truncate();

        return User::create([
            'password' => '12345',
            'name' => 'name',
            'mobile' => 'mobile',
            'city_id' => 15,
        ]);
    }

    /**
     * A create ad test
     *
     * @return void
     */
    public function testCreate()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Ad::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = $this->getUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createAccessToken(),
        ])->postJson('/api/v1/ads/store', [
            'age' => 1, 
            'animal_id' => 1, 
            'breed_id' => 1, 
            'city_id' => 891, 
            'colors' => [1,3,4], 
            'content' => 'Content', 
            'gender' => '_none', 
            'id' => 12, 
            'socials' => [], 
            'sterilization' => '_none', 
            'title' => 'title', 
            'images' => [
                'http://127.0.0.1:8000/storage/photos/9/5ef8ae7c6b263.jpeg', 
                'http://127.0.0.1:8000/storage/photos/9/5eeb49ad1f262.jpeg'
            ]
        ]);

        $response->assertStatus(200)
            ->assertJsonPath("active", true)
            ->assertJsonPath("city_id", 891)
            ->assertJsonPath("colors", [1,3,4])
            ->assertJsonPath("vkPosts", [])
            ->assertJsonPath("id", 1)
            ->assertJsonPath("content", "Content")
            ->assertJsonPath("age", 1)
            ->assertJsonPath("phone", $user->mobile)
            ->assertJsonPath("gender", "_none")
            ->assertJsonPath("sterilization", "_none")
            ->assertJsonPath("user_id", $user->id)
            ->assertJsonPath("breed_id", 1)
            ->assertJsonPath("animal_id", 1)
            ->assertJsonPath("images", [
                "http://localhost/storage/photos/9/5ef8ae7c6b263.jpeg",
                "http://localhost/storage/photos/9/5eeb49ad1f262.jpeg"
            ]);
    }

    /**
     * A update ad test
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = $this->getUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createAccessToken(),
        ])->postJson('/api/v1/ads/update', [
            'id' => 1,
            'age' => 5, 
            'animal_id' => 1, 
            'breed_id' => 5, 
            'city_id' => 15, 
            'colors' => [1], 
            'content' => 'Content 2', 
            'gender' => 'male', 
            'socials' => [], 
            'sterilization' => '1', 
            'title' => 'title 2', 
            'images' => [
                'http://127.0.0.1:8000/storage/photos/9/5ef8ae7c6b263.jpeg'
            ]
        ]);

        $response->assertStatus(200)
            ->assertJsonPath("active", 1)
            ->assertJsonPath("city_id", 15)
            ->assertJsonPath("colors", [1])
            ->assertJsonPath("vkPosts", [])
            ->assertJsonPath("id", 1)
            ->assertJsonPath("content", 'Content 2')
            ->assertJsonPath("age", 5)
            ->assertJsonPath("phone", $user->mobile)
            ->assertJsonPath("gender", "male")
            ->assertJsonPath("sterilization", "1")
            ->assertJsonPath("user_id", $user->id)
            ->assertJsonPath("breed_id", 5)
            ->assertJsonPath("animal_id", 1)
            ->assertJsonPath("images", [
                "http://localhost/storage/photos/9/5ef8ae7c6b263.jpeg"
            ]);
    }

    /**
     * A get me ads
     *
     * @return void
     */
    public function testMe()
    {
        $user = $this->getUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createAccessToken(),
        ])->getJson('/api/v1/ads/me');

        $response->assertStatus(200)
            ->assertJsonFragment([
                "active" => 1,
                "city_id" => 15,
                "colors" => [1],
                "vkPosts" => [],
                "id" => 1,
                "content" => 'Content 2',
                "age" => 5,
                "phone" => $user->mobile,
                "gender" => "male",
                "sterilization" => "1",
                "user_id" => $user->id,
                "breed_id" => 5,
                "animal_id" => 1,
                "images" => [
                    "http://localhost/storage/photos/9/5ef8ae7c6b263.jpeg"
                ]
            ]);
    }
}

