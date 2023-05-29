<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            array(
                'id'     =>   '1',
                'role_name'   =>   'Admin',
                'role_slug'   =>   'admin'
            )
        );
        DB::table('roles')->insert(
            array(
                'id'     =>   '2',
                'role_name'   =>   'Production',
                'role_slug'   =>   'production'
            )
        );
        DB::table('roles')->insert(
            array(
                'id'     =>   '3',
                'role_name'   =>   'Dispatch',
                'role_slug'   =>   'dispatch'
            )
        );
    }
}
