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
     *
     * @return void
     */
    public function run()
    {
        $user =User::create([
            'name'=>'Union',
            'email' =>'union2023@gmail.com',
            'password' => Hash::make('union2023'),
           ]);
        $user->assignRole('Admin');

        $user =User::create([
            'name'=>'Project Manager',
            'email' =>'pm@gmail.com',
            'password' => Hash::make('123456789'),
           ]);
        $user->assignRole('Project Manager');
    }
}
