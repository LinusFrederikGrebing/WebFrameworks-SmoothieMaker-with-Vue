<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creates 3 test customers, our administrator and a defined user "User" to increase the efficiency of testing
        User::factory()->count(3)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => bcrypt('password'), // str_random(10)
            'type' =>  UserRole::MITARBEITER,
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'User@user.com',
            'password' => bcrypt('password'), // str_random(10)
            'type' =>  UserRole::KUNDE,
        ]);
    }
}
