<?php


namespace API;

use App\OauthClient;
use App\User;

class AuthControllerTest extends \TestCase
{
    public function testRegister()
    {
        $response = $this->createMainUser();
        $response['response']->assertResponseStatus(201);
        
        $this->assertEquals($response['response']->response->original['user']->email, $this->main_user_test['email']);
        $response['response']->seeJsonStructure([
            'user',
            'message',
        ]);
    }

    public function testLogin()
    {
        $this->createMainUser();
        $oauth_client = OauthClient::find(2);

        $body = [
            'username' => $this->main_user_test['email'],
            'password' => $this->main_user_test['password'],
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'grant_type' => 'password',
            'scope' => '*'
        ];

        $response = $this->json('POST','v1/oauth/token', $body, ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);

        $response->seeJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token'
        ]);
    }
}
