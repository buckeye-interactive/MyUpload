<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::firstOrCreate(
            ['email' => 'admin@test.com',],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'is_admin' => true
            ]
        );
    }
}
