<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => app('hash')->make('secret')
    ];
});

$factory->define(\App\Employee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->dateTimeBetween('-30 years', '-10 years'),
        'hire_date' => $faker->dateTimeBetween('-10 years', '-1 years'),
        'gender' => $faker->randomElement(['M', 'F'])
    ];
});
