<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Helpers\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $roles = [
            RolesEnum::Super_admin,
            RolesEnum::Admin,
            RolesEnum::User,
        ];

        foreach($roles as $key => $role)
        {
            $new_role = new Role();
            $new_role->role = $role;
            $new_role->save();
        }
    }
}
