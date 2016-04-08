<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
             $table->tinyInteger('type')->default(0);
             $table->string('title',50)->unique();
             $table->string('url',50)->unique();
             $table->integer('parent_id')->default(0);
             $table->tinyInteger('sort_order')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu');
    }
}
