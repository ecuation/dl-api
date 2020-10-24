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

$router->get('/', function () use ($router) {

    /*dd(\App\Department::find('d009')->managers);
    return $router->app->version();*/

    dd(\App\Employee::first()->salaries->pluck('salary'));
    dd(\App\Department::find('d007')->employees->count());
    foreach (\App\Department::find('d007')->employees as $manager){
        echo $manager->emp_no . '<br>';
    }


    dd(\App\Employee::first()->salaries);
});

$router->post('/signup', [
    'uses' => 'AuthController@signup'
]);

$router->post('/login', [
    'uses' => 'AuthController@login'
]);

