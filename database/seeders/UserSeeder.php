<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        $user = new User();
        $user->name = "Peter Watts";
        $user->email = "peter@gmail.com";
        $user->save();
    }
}
