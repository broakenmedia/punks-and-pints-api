<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //Just a very basic seed user, we don't want to be committing passwords for things in reality of course.
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@punks.local',
            'password' => Hash::make('password'),
        ]);
    }
}
