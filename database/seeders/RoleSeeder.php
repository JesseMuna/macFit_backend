<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //manually input data into the database
        Role::create([
            'name' => 'Admin',
            'description'=> 'Administarator'
        ]);

         Role::create([
            'name' => 'Trainer',
            'description'=> 'This ia a trainer'
        ]);

         Role::create([
            'name' => 'User',
            'description'=> 'This is a normal user'
        ]);

         Role::create([
            'name' => 'Staff',
            'description'=> 'This is a member of staff'
        ]);

        
    }
}
