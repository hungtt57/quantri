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
        DB::table('roles')->insert([
            'name' => 'Default'
        ]);
        DB::table('roles')->insert([
            'name' => 'Admin'
        ]);
        DB::table('roles')->insert([
            'name' => 'Supervisor'
        ]);
        DB::table('roles')->insert([
            'name' => 'Manager'
        ]);
        DB::table('roles')->insert([
            'name' => 'Distributor'
        ]);
        DB::table('roles')->insert([
            'name' => 'Operator'
        ]);
    }
}
