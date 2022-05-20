<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Action::truncate();
        Schema::enableForeignKeyConstraints();
        
        $actions = [
            'manage-users', 
            'manage-projects', 
            'manage-tasks'
        ];

        foreach($actions as $key => $action)
        {
            $new_action = new Action();
            $new_action->action = $action;
            $new_action->save();
        }
    }
}
