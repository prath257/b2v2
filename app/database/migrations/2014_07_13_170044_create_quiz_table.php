<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quiz', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('title',255);
            $table->string('description',255)->nullable();
            $table->boolean('ispublic')->default(true);
            $table->integer('ifc')->unsigned()->default(0);
            $table->integer('category')->unsigned()->default(0);
            $table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
            $table->integer('time')->unsigned()->default(60);
            $table->integer('users')->unsigned()->default(0);
            $table->integer('ownerid')->unsigned()->default(0);
            $table->foreign('ownerid')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('quiz');
	}

}
