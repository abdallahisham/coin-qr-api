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
            'phone' => '5000000001',
            'token' => 'user1',
            'balance' => 500.0
        ]);
        User::create([
            'name' => 'Mohammed Ali',
            'phone' => '5000000002',
            'token' => 'user2',
            'balance' => 500.0
        ]);
        User::create([
            'name' => 'Adel Khalid',
            'phone' => '5000000003',
            'token' => 'user3',
            'balance' => 500.0
        ]);
    }
}
