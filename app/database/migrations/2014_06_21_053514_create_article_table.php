<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',255);
            $table->string('cover',255);
            $table->text('description');
			$table->binary('text',32777216);
			$table->integer('ifc')->unsigned()->default(0);
			$table->integer('userid')->unsigned()->default(0);
			$table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
			$table->integer('category')->unsigned()->default(0);
			$table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
            $table->enum('type',array('Article','List','Film Review','Music Review','Book Review','Game Review','Code Article','Recipe','Travel Guide'));
			$table->integer('users')->unsigned()->default(0);
			$table->enum('review',array('toreview','passed'));
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
		Schema::drop('articles');
	}

}
