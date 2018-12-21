<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            ['name' => 'owner', 'display_name' => 'Owner'],
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'agent', 'display_name' => 'Agent'],
            ['name' => 'guest', 'display_name' => 'Guest']
        ]);

    }
}
