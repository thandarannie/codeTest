<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' =>'Admin',
            'guard_name' => 'web'
            ]);
        Role::create([
            'name' =>'M&E Manager',
            'guard_name' => 'web'
            ]);
        Role::create([
            'name' =>'Project Manager',
            'guard_name' => 'web'
            ]);
    }
}
