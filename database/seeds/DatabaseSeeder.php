<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name' => 'Ahmed Mohammed',
            'email' => 'user1@gmail.com',
            'phone' => '5000000001',
            'token' => 'user1',
            'password' => bcrypt('123456'),
        ]);
        User::create([
            'name' => 'Mohammed Ali',
            'email' => 'user2@gmail.com',
            'phone' => '5000000002',
            'token' => 'user2',
            'password' => bcrypt('123456'),
        ]);
        User::create([
            'name' => 'Adel Khalid',
            'email' => 'user3@gmail.com',
            'phone' => '5000000003',
            'token' => 'user3',
            'password' => bcrypt('123456'),
        ]);
    }
}
