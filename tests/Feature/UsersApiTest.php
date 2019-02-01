<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

class UsersApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testGetUsersApi()
    {
        $auth = Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        $headers = ['Authorization' => "Bearer $auth->api_token"];
        $response = $this->json('get', '/api/users', [], $headers);
        $responseData = $response->decodeResponseJson();
        $this->assertArrayHasKey('full_name', $responseData[0]);
        $this->assertArrayHasKey('email', $responseData[0]);
        $this->assertArrayHasKey('id_rol', $responseData[0]);
        $this->assertArrayHasKey('user_photo', $responseData[0]);
    }

    public function testValidationCreateUserApi()
    {
        $auth = Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        $headers = ['Authorization' => "Bearer $auth->api_token"];
        $response = $this->json('post', '/api/users', [
          "full_name" => '',
          "email" => '',
          "password" => '',
          "password_confirmation" => '',
          "id_rol" => '',
          "userPhoto" => '',
        ], $headers);
        $responseData = $response->decodeResponseJson();
        $this->assertArrayHasKey('full_name', $responseData['errors']);
        $this->assertArrayHasKey('email', $responseData['errors']);
        $this->assertArrayHasKey('password', $responseData['errors']);
        $this->assertArrayHasKey('password_confirmation', $responseData['errors']);
        $this->assertArrayHasKey('id_rol', $responseData['errors']);
        $this->assertArrayHasKey('user_photo', $responseData['errors']);
    }

    public function testCreateUserApi()
    {
        $auth = Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        $faker = Faker::create();
        $fullName = $faker->name;
        $email = $faker->email;
        $password = Hash::make('Admin.2019');
        $rol = 2;
        $userPhoto = $faker->image('public/storage/images', 400, 300, null, false);

        $headers = ['Authorization' => "Bearer $auth->api_token"];
        $response = $this->json('post', '/api/users', [
          "full_name" => $fullName,
          "email" => $email,
          "password" => $password,
          "password_confirmation" => $password,
          "id_rol" => $rol,
          "user_photo" => $userPhoto,
        ], $headers);

        $this->seeInDatabase('users', [
          "full_name" => $fullName,
          "email" => $email,
          "id_rol" => $rol,
          "user_photo" => $userPhoto,
        ]);
    }

    public function testUpdateUserApi()
    {
        $user = factory(User::class)->create();
        $auth = Passport::actingAs(
            $user,
            ['create-servers']
        );
        $headers = ['Authorization' => "Bearer $auth->api_token"];
        $this->json('put', '/api/users/' . $user->id, [
          "full_name" => "Custom name"
        ], $headers);

        $this->seeInDatabase('users', [
          'id' => $user->id,
          'full_name' => "Custom name",
        ]);
        $user->delete();
    }

    public function testDeleteUserApi()
    {
        $auth = Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        $userToDelete = factory(User::class)->create();
        $headers = ['Authorization' => "Bearer $auth->api_token"];
        $this->json('delete', '/api/users/'. $userToDelete->id, [], $headers);

        $response =$this->dontSeeInDatabase('users', [
          "id" => $userToDelete->id,
          "full_name" => $userToDelete->fullName,
          "email" => $userToDelete->email,
          "id_rol" => $userToDelete->rol,
          "user_photo" => $userToDelete->user_photo,
        ]);

        $responseData = $response->decodeResponseJson();

        $this->assertArrayHasKey('success', $responseData);
    }
}
