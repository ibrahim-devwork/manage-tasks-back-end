<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $user = new User();
        $user->first_name = 'ibrahim';
        $user->last_name = 'AOULAD ABDERAHMAN';
        $user->username = 'Super admin';
        $user->email = 'Admin@gmail.com';
        $user->password = Hash::make('Admin123');
        $user->id_role = 1;
        $user->save();
    }
}
