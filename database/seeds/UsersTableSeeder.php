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
            'first_name' => 'Nguyen',
            'last_name' => 'Van An',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);    
    }
}
