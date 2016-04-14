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
            'name' => 'Mặc định'
        ]);
        DB::table('roles')->insert([
            'name' => 'Admin'
        ]);
        DB::table('permissions')->insert(['name' => 'RoleController@index']);
        DB::table('permission_role')->insert(['role_id' => '2','permission_id' => '1']);
    }
}
