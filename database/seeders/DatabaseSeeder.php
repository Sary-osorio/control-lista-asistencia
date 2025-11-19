<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => env('USER_NAME_ADMIN', 'admin2'),
            'email' =>  env('USER_MAIL_ADMIN', 'admin2@example.com'),
            'password' => bcrypt(env('USER_PASSWORD_ADMIN', 'password2')),
        ]);
    }
}
