<?php


class MainUserSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $user_data = [
            "first_name" => "John",
            "last_name" => "Doe",
            "email" => 'test-user@docline.development',
            'password' => app('hash')->make('secret123')
        ];

        $user = new \App\User($user_data);
        $user->save();
        $token = $user->createToken('docline')->accessToken;

        $this->command->info('Admin user has been created successfully');
    }
}
