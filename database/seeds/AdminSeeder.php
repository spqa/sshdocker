<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create(
            [
                'name'=>'adminsunfrog',
                'email'=>'admin@gmail.com',
                'password'=>bcrypt('1234@4321')
            ]
        );
    }
}
