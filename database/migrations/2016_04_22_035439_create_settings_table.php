<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('value');
            $table->text('description')->nullable();
<<<<<<< HEAD
=======
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')
                    ->references('id')
                    ->on('setting_groups')
                    ->onDelete('cascade');
            //$table->integer('autoload')->default(1);
>>>>>>> 7eaab6a5459193667aec5fcc4b8f2a69cba68f29
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
