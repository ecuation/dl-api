<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{

    public $main_user_test;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp() : void
    {
        parent::setUp();

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Artisan::call('passport:install');
        $this->setMainUserTest();
    }

    public function setMainUserTest()
    {
        $this->main_user_test = [
            "first_name" => "John",
            "last_name" => "Doe",
            "email" => 'john.doe@test.dev',
            "password" => "secret123",
        ];
    }

    public function createMainUser()
    {
        $response = $this->json('POST', route('auth.register'), $this->main_user_test, [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);

        return [
            'response' => $response,
            'token' => json_decode($response->response->getContent())->token
        ];
    }
}
