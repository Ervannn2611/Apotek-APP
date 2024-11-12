<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([ 
            'name' => 'admin',
            'email' => 'apotek_admin@gmail.com',
            'password' => Hash::make('adminapotek'),
            'role' => 'admin'
        ]);
    //     User::create([
    //         'name' => 'user',
    //         'email' => 'user123@gmail.com',
    //         'password' => Hash::make('user123'),
    //         'role' => 'user'
    //     ]);
    }
}
