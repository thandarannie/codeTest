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
            'name'=>'Admin',
            'email' =>'admin@gmail.com',
            'phone'=>'09798456123',
            'password' => Hash::make('123456789'),
           ]);
        $user->assignRole('Admin');

        $user =User::create([
            'name'=>'Project Manager',
            'email' =>'pm@gmail.com',
            'phone'=>'09978456123',
            'password' => Hash::make('123456789'),
           ]);
        $user->assignRole('Project Manager');
    }
}
