<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jack Reacher',
            'email' => 'jackreacher@mail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
