<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AuthTest extends TestCase
{
    /**
     * A Register test.
     *
     * @return void
     */
    public function testRegister()
    {

        User::truncate();

        $response = $this->postJson('/api/v1/user/register', [
            "c_password" => "12345",
            "city_id" => 891, 
            "mobile" => "79999999999", 
            "name" => "oleg", 
            "password" => "12345"
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('user.id', 1)
            ->assertJsonPath('user.mobile', '79999999999')
            ->assertJsonPath('user.city.id', 891)
            ->assertJsonPath('user.name', 'oleg')
            ->assertJsonPath('user.vk', false)
            ->assertJsonPath('user.vkGroups', [])
            ->assertJson([
                'access_token' => true,
            ]);
    }

    /**
     * A login test.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->postJson('/api/v1/user/login', [
            "mobile" => "79999999999",
            "password" => "12345"
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('user.id', 1)
            ->assertJsonPath('user.mobile', '79999999999')
            ->assertJsonPath('user.city.id', 891)
            ->assertJsonPath('user.name', 'oleg')
            ->assertJsonPath('user.vk', false)
            ->assertJsonPath('user.vkGroups', [])
            ->assertJson([
                'access_token' => true,
            ]);
    }

    /**
     * A user me test
     *
     * @return void
     */
    public function testMe()
    {
        $user = User::find(1);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createAccessToken(),
        ])->getJson('/api/v1/user/me');

        $response
            ->assertStatus(200)
            ->assertJsonPath('id', 1)
            ->assertJsonPath('mobile', '79999999999')
            ->assertJsonPath('city.id', 891)
            ->assertJsonPath('name', 'oleg')
            ->assertJsonPath('vk', false)
            ->assertJsonPath('vkGroups', []);
    }

    /**
     * A user update test
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::find(1);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createAccessToken(),
        ])->postJson('/api/v1/user/update', [
            "name" => "oleg2",
            "email" => "oleg@o.o",
            "city_id" => 15
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('id', 1)
            ->assertJsonPath('mobile', '79999999999')
            ->assertJsonPath('city.id', 15)
            ->assertJsonPath('name', 'oleg2')
            ->assertJsonPath('email', 'oleg@o.o')
            ->assertJsonPath('vk', false)
            ->assertJsonPath('vkGroups', []);

        $user = User::find(1);

        if ($user->name !== 'oleg2') {
            throw new \Exception("name not saved");
        }

        if ($user->email !== 'oleg@o.o') {
            throw new \Exception("email not saved");
        }

        if ($user->city_id !== 15) {
            throw new \Exception("city_id not saved");
        }
    }
}
