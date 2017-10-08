<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Alex',
            'email' => 'alex@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
