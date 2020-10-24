<?php


namespace API;

use App\User;

class AuthControllerTest extends \TestCase
{
    public function testRegister()
    {
        $this->assertTrue(true);
        factory(User::class)->create();

        dd(User::first());
    }
}
