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

        $user               = new User();
        $user->first_name   = 'ibrahim';
        $user->last_name    = 'AOULAD ABDERAHMAN';
        $user->username     = 'Super admin';
        $user->email        = 'Admin@gmail.com';
        $user->password     = Hash::make('Admin123');
        $user->id_role      = 1;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'Admin01';
        $user->email        = 'Admin01@gmail.com';
        $user->password     = Hash::make('Admin01');
        $user->id_role      = 2;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User01';
        $user->email        = 'User01@gmail.com';
        $user->password     = Hash::make('User01');
        $user->id_role      = 3;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User02';
        $user->email        = 'User02@gmail.com';
        $user->password     = Hash::make('User02');
        $user->id_role      = 3;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User03';
        $user->email        = 'User03@gmail.com';
        $user->password     = Hash::make('User03');
        $user->id_role      = 3;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User04';
        $user->email        = 'User04@gmail.com';
        $user->password     = Hash::make('User04');
        $user->id_role      = 3;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User05';
        $user->email        = 'User05@gmail.com';
        $user->password     = Hash::make('User05');
        $user->id_role      = 3;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User06';
        $user->email        = 'User06@gmail.com';
        $user->password     = Hash::make('User06');
        $user->id_role      = 3;
        $user->save();

        $user               = new User();
        $user->first_name   = '';
        $user->last_name    = '';
        $user->username     = 'User07';
        $user->email        = 'User07@gmail.com';
        $user->password     = Hash::make('User07');
        $user->id_role      = 3;
        $user->save();
    }
}
