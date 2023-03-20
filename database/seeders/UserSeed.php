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
        User::factory()->count(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => bcrypt('password'), // str_random(10)
            'type' =>  UserRole::MITARBEITER,
        ]);
    }
}
