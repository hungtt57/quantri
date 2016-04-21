<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 20; $i++) {
    		DB::table('articles')->insert([ //,
    	        'title' => $faker->sentence(mt_rand(3, 10)),
    		    'content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6)))
    	    ]);
        }
    }
}
