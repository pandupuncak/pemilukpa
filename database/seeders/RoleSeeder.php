<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'superadmin',
            'description' => 'superadmin - has highest privileges',
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'admin - election commitee',
        ]);

        DB::table('roles')->insert([
            'name' => 'regular',
            'description' => 'regular - general organization member',
        ]);
    }
}
