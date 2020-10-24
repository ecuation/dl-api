<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(in_array(env('APP_ENV'), ['testing', 'local'])) {
            $this->call('UsersTableSeeder');
        }
    }
}
