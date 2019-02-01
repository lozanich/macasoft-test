<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetRolApi()
    {
        $user = factory(User::class)->create();
        $auth = Passport::actingAs(
            $user,
            ['create-servers']
        );
        $headers = ['Authorization' => "Bearer $auth->api_token"];
        $response = $this->json('get', '/api/roles/'.$user->id_rol, [], $headers);
        $responseData = $response->decodeResponseJson();
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('id_rol', $responseData);
    }
}
