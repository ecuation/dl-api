<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'api/v1'], function() use (&$router)
{
    $router->post('/signup', [
        'uses' => 'AuthController@signup',
        'as' => 'auth.register'
    ]);

    $router->group(['middleware' => 'auth:api'], function() use (&$router) {
        $router->get('/employees', [
            'uses' => 'EmployeeController@index',
            'as' => 'employees.index'
        ]);
    });
});
