<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name' => 'Fito Satrio',
            'level' => 'admin',
            'username' => 'fitosatrioo',
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(60),
        ]);
    }
}