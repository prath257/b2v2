<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogbooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blogbooks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('title',255);
            $table->string('cover',255)->default('http://b2.com/Images/BlogBook.jpg');
            $table->text('description');
            $table->integer('category')->unsigned()->default(0);
            $table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
            $table->integer('ifc')->unsigned()->default(0);
            $table->integer('chapters')->default(0);
            $table->integer('userid')->unsigned()->default(0);
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->integer('users')->unsigned()->default(0);
            $table->enum('review', array('passed','toreview','reviewed'));
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
		Schema::drop('blogbooks');
	}

}
