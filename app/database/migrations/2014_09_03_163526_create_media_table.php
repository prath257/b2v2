<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('cover',255)->default('http://b2.com/Images/Media.jpg');
            $table->string('title',255);
            $table->text('trivia');
            $table->integer('category')->unsigned()->default(0);
            $table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
            $table->integer('ifc')->unsigned()->default(0);
            $table->integer('users')->unsigned()->default(0);
            $table->string('path',255);
            $table->string('type',10);
            $table->boolean('ispublic');
            $table->integer('userid')->unsigned()->default(0);
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('media');
	}

}
