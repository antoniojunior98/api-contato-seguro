<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_list()
    {
        $response = $this->postJson('/users');

        $response->assertStatus(200);
    }

    public function test_create()
    {
        $payload = [
            'name' => 'teste',
            'email' => 'teste@gmail.com',
            'telephone' => '91985321753',
            'birthday' => '2022-08-18',
            'companies' => [1],
            'city' => 1
        ];
        $response = $this->postJson('/user/store', $payload);
        $response->assertStatus(201);
    }

    public function test_update()
    {
        $user = New User();
        $user->name = 'teste';
        $user->email = 'teste2@gmail.com';
        $user->telephone = '91985321753';
        $user->birthday = '2022-08-18';
        $user->city_id = 1;
        $user->save();

        $payload = [
            'name' => 'teste 2',
            'email' => 'teste2@gmail.com',
            'telephone' => '91985321753',
            'birthday' => '2022-08-18',
            'companies' => [1],
            'city' => 1
        ];

        $response = $this->putJson("/user/{$user->id}/update", $payload);
        $response->assertStatus(201);
    }

    public function test_delete()
    {
        $user = New User();
        $user->name = 'teste';
        $user->email = 'teste3@gmail.com';
        $user->telephone = '91985321753';
        $user->birthday = '2022-08-18';
        $user->city_id = 1;
        $user->save();

        $response = $this->deleteJson("/user/{$user->id}/delete");
        $response->assertStatus(201);
    }
}
