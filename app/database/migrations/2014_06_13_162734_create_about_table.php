<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('writtenby')->unsigned()->default(0);
            $table->integer('writtenfor')->unsigned()->default(0);
            $table->text('content');
            $table->integer('ifc')->unsigned()->default(100);
            $table->enum('status',array('new','accepted'));
            $table->foreign('writtenby')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('writtenfor')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('about');
    }

}
