<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_owner = Roles::where('name', 'owner')->first();

        User::create([
            'name'=>'Syazwana Rakha M',
            'email'=>'fsyazwan24@gmail.com',
            'password'=>Hash::make(1234567),
            'role_id'=>$role_owner->id
        ]);

        $role_owner = Roles::where('name', 'admin')->first();

        User::create([
            'name'=>'Syazwani Adinda M',
            'email'=>'112.syazwani@gmail.com',
            'password'=>Hash::make(1234567),
            'role_id'=>$role_owner->id
        ]);


    }
}
